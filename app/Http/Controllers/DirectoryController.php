<?php

namespace App\Http\Controllers;

use App\Classes\DirectoryCls;
use App\Directory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DirectoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['downloadWithToken']]);
    }

    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        $id = $request->id;
        if ($id != '')
        {

            $user      = Auth::user();
            $directory = Directory::find($id);

            if (!$directory)
            {
                $request->session()->flash('alert-error', 'Directory not found or removed by the creator!');
                return redirect()->route('home');
            }

            $parents = array();
            $parents = $directory->getParentsTree();
            foreach ($parents as $k => $parent)
            {
                if (!$parent->users()->find($user->id))
                {
                    unset($parents[$k]);
                }
            }
            $arrDirectories = array();
            foreach ($directory->directories as $child)
            {
                $relationData = $child->users()->find($user->id);
                if ($relationData)
                {
                    $arrDirectories[] = array(
                        'dir'        => $child,
                        'is_creator' => $relationData->pivot->is_creator,
                    );
                }
            }
            //////////////////////////////////////////////////
            $arrFiles = array();
            foreach ($directory->files as $file)
            {
                $relationData = $file->users()->find($user->id);
                if ($relationData)
                {
                    $arrFiles[] = array(
                        'file'       => $file,
                        'is_creator' => $relationData->pivot->is_creator,
                    );
                }
            }
            //////////////////////////////////////////////////
            $isCreator = $directory->users()->find($user->id)->pivot->is_creator;

            $allocatedDiskSpace = floatval(\App\Classes\DirectoryCls::GetUserDriveSize($user));
            $allowedSpace       = $user->package->max_disk_space;
            $freeSpace          = $allowedSpace - $allocatedDiskSpace;

            return view('directory')->with([
                'mainDir'        => $directory,
                'allowUpload'    => $isCreator,
                'is_creator'     => $isCreator,
                'parents'        => $parents,
                'arrDirectories' => $arrDirectories,
                'arrFiles'       => $arrFiles,
                'freeSpace'      => $freeSpace,
            ]);
        }
        else
        {
            return redirect()->route('home');
        }
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = Auth::user();

        if ($user->getInodes() >= $user->package->max_inodes)
        {
            $request->session()->flash('alert-error', 'Can not create folder! Inodes limit reached!');
            return redirect()->back();
        }

        if (floatval(DirectoryCls::GetUserDriveSize($user)) >= $user->package->max_disk_space)
        {
            $request->session()->flash('alert-error', 'Can not create folder! Maximum disk space limit reached!');
            return redirect()->back();
        }

        $name = md5($request->directory_name . $user->id . time());

        $directory                = new Directory();
        $directory->name          = $name;
        $directory->original_name = $request->directory_name;
        $directory->parent_id     = $request->parent_id;

        DirectoryCls::CreateDirectory($directory, $user);

        $request->session()->flash('alert-success', 'Directory created!');
        if ($request->parent_id != '')
        {
            return redirect()->route("directory", ['id' => $request->parent_id]);
        }
        return redirect()->route("home");
    }

    /**
     * @param $id
     * @param Request $request
     */
    public function delete($id, Request $request)
    {

        $directory = Directory::find($id);
        $parent    = $directory->parent;
        $user      = Auth::user();

        $isCreatorDeleting = $directory->users()->find($user->id)->pivot->is_creator;
        DirectoryCls::DeleteDirectory($directory, $user);
        $request->session()->flash('alert-success', 'Directory deleted!');

        if ($parent && $parent->users()->find($user->id))
        {
            return redirect()->route("directory", ['id' => $parent->id]);
        }

        if ($isCreatorDeleting)
        {
            return redirect()->route('home');
        }

        return redirect()->route("sharedWithMe");
    }

    /**
     * @param Request $request
     */
    public function share(Request $request)
    {
        if ($request->user_email == '')
        {
            return \Response::json(array('message' => 'Please enter valid email address'), 404);
        }

        if ($request->user_email == Auth::user()->email)
        {
            return \Response::json(array('message' => "Can't share folder with yourself"), 404);
        }

        $user = User::where('email', $request->user_email)->first();
        if (!$user)
        {
            return \Response::json(array('message' => 'User not found'), 404);
        }

        if ($request->directory_id == '')
        {
            return \Response::json(array('message' => 'Please select folder to share'), 404);
        }

        $directory = Directory::find($request->directory_id);
        if (!$directory)
        {
            return \Response::json(array('message' => 'Directory not found'), 404);
        }

        if ($directory->users()->where('user_id', $user->id)->first())
        {

            return \Response::json(array('message' => 'This folder is already shared with selected user'), 404);
        }

        $user->addDirectory($directory);
        return \Response::json(array('success'), 201);
    }

    /**
     * @param $dirId
     */
    public function download($dirId)
    {
        $directory = Directory::find($dirId);
        $zipPath   = DirectoryCls::Zip($directory);
        return response()->download($zipPath)->deleteFileAfterSend(true);

    }
    /**
     * @param Request $request
     */
    public function rename(Request $request)
    {
        if ($request->dir_name == '')
        {
            return \Response::json(array('message' => 'Directory name is required!'), 404);
        }
        if ($request->dir_id == '')
        {
            return \Response::json(array('message' => 'Directory not found!'), 404);
        }
        $dir = Directory::find($request->dir_id);
        if (!$dir)
        {
            return \Response::json(array('message' => 'Directory not found!'), 404);
        }

        $dir->original_name = htmlspecialchars(trim($request->dir_name));
        $dir->save();
        return \Response::json(array('message' => 'Directory has been renmaed!'), 200);
    }

    /**
     * @param array $data
     */
    private function validator(array $data)
    {
        return Validator::make($data, [
            'directory_name' => 'required|max:255',
        ]);
    }

    /**
     * @param Request $request
     */
    public function getDirToken(Request $request)
    {
        $user  = Auth::user();
        $dir   = $user->directories()->find($request->directory_id);
        $token = $dir->pivot->directory_access_token;
        if ($token == '')
        {
            $token = sha1($dir->name . time() . $user->id);

            $user->directories()->updateExistingPivot($request->directory_id, ['directory_access_token' => $token]);
        }
        $url = url('directory/get', $parameters = ['token' => $token], $secure = null);
        return \Response::json(array('token' => $url), 200);

    }

    /**
     * @param $token
     */
    public function downloadWithToken($token)
    {
        $dir = \DB::table('directories_accress_rights')->where('directory_access_token', $token)->first();
        if (!$dir)
        {
            $request->session()->flash('alert-error', 'Directory does not exists');
            return redirect()->to('/');
        }
        $dir     = Directory::find($dir->directory_id);
        $creator = $dir->users()->where('is_creator', true)->first();

        $path = DirectoryCls::GetDirectoryFullPath($dir, $creator);

        if (!\Storage::disk('local')->exists($path))
        {
            $request->session()->flash('alert-error', 'Directory does not exists');
            return redirect()->to('/');
        }

        $zipPath = DirectoryCls::Zip($dir);
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    /**
     * @param $id
     */
    public function back($id)
    {
        $directory = Directory::find($id);
        $parent    = $directory->parent;
        $user      = Auth::user();

        $isCreator = $directory->users()->find($user->id)->pivot->is_creator;
        if ($parent && $parent->users()->find($user->id))
        {
            return redirect()->route("directory", ['id' => $parent->id]);
        }

        if ($isCreator)
        {
            return redirect()->route('home');
        }

        return redirect()->route("sharedWithMe");
    }

}
