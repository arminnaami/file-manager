<?php

namespace App\Http\Controllers;

use App\Classes\FileCls;
use App\Directory;
use App\File;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

class FilesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['downloadWithToken']]);
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {

        $user = Auth::user();
        ///////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////

        if (!$request->file('file'))
        {
            $request->session()->flash('alert-error', 'Please select file');
            return redirect()->back();
        }

        if ($user->getInodes() >= $user->package->max_inodes)
        {
            $request->session()->flash('alert-error', 'Can not upload file! Inodes limit reached!');
            return redirect()->back();
        }

        $fileSize = $request->file('file')->getClientSize();
        $fileSize = floatval($fileSize / (1024 * 1024));

        if ($fileSize >= $user->package->max_file_size)
        {
            $request->session()->flash('alert-error', 'Can not upload file! Maximum file size limit reached!');
            return redirect()->back();
        }
        $allocatedDiskSpace = floatval(\App\Classes\DirectoryCls::GetUserDriveSize($user));

        if ($allocatedDiskSpace + $fileSize >= $user->package->max_disk_space)
        {
            $request->session()->flash('alert-error', 'Can not upload file! Maximum disk space limit reached!');
            return redirect()->back();
        }
        $extension = \App\Extension::find(pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_EXTENSION));
        if ($extension == null || $extension->is_blocked)
        {
            $request->session()->flash('alert-error', 'Can not upload file! This file type is not allowed!');
            return redirect()->back();
        }
        ///////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////
        $dirId     = $request->dir_id;
        $directory = null;
        if ($dirId != '')
        {
            $directory = Directory::find($dirId);
        }
        FileCls::SaveFile($user, $request->file('file'), $directory);

        $request->session()->flash('alert-success', 'File upload complete');
        return redirect()->back();
    }

    /**
     * @param $id
     * @param Request $request
     */
    public function download($id, Request $request)
    {
        $file = File::find($id);
        if (!$file)
        {
            $request->session()->flash('alert-error', 'File does not exists');
            return redirect()->back();
        }

        $creator = $file->users()->where('is_creator', true)->first();

        $path = FileCls::GetFilePath($file, $creator);

        if (!Storage::disk('local')->exists($path))
        {
            $request->session()->flash('alert-error', 'File does not exists');
            return redirect()->back();
        }

        $storagePrefix = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $name          = "{$file->name}.{$file->extension}";
        return response()->download($storagePrefix . $path, $name);

    }

    /**
     * @param $id
     * @param Request $request
     */
    public function delete($id, Request $request)
    {
        $file = File::find($id);
        $user = Auth::user();
        if (!$file)
        {
            $request->session()->flash('alert-error', 'File does not exists');
            return redirect()->back();
        }

        FileCls::DeleteFile($file, $user);

        $request->session()->flash('alert-success', 'File deleted!');
        return redirect()->back();
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
            return \Response::json(array('message' => "Can't share file with yourself"), 404);
        }

        $user = User::where('email', $request->user_email)->first();
        if (!$user)
        {
            return \Response::json(array('message' => 'User not found'), 404);
        }

        if ($request->file_id == '')
        {
            return \Response::json(array('message' => 'Please select file to share'), 404);
        }

        $file = File::find($request->file_id);
        if (!$file)
        {
            return \Response::json(array('message' => 'File not found'), 404);
        }

        if ($file->users()->where('user_id', $user->id)->first())
        {

            return \Response::json(array('message' => 'This file is already shared with selected user'), 404);
        }

        $user->addFile($file);
        return \Response::json(array('success'), 201);
    }

    /**
     * @param Request $request
     */
    public function rename(Request $request)
    {
        if ($request->file_name == '')
        {
            return \Response::json(array('message' => 'File name is required!'), 404);
        }
        if ($request->file_id == '')
        {
            return \Response::json(array('message' => 'File not found!'), 404);
        }
        $file = File::find($request->file_id);
        if (!$file)
        {
            return \Response::json(array('message' => 'File not found!'), 404);
        }

        $file->name = htmlspecialchars(trim($request->file_name));
        $file->save();
        return \Response::json(array('message' => 'File has been renmaed!'), 200);
    }

    /**
     * @param Request $request
     */
    public function getFileToken(Request $request)
    {
        $user  = Auth::user();
        $file  = $user->files()->find($request->file_id);
        $token = $file->pivot->file_access_token;
        if ($token == '')
        {
            $token = sha1($file->private_name . time() . $user->id);

            $user->files()->updateExistingPivot($request->file_id, ['file_access_token' => $token]);
        }
        $url = url('file/get', $parameters = ['token' => $token], $secure = null);
        return \Response::json(array('token' => $url), 200);

    }

    /**
     * @param $token
     */
    public function downloadWithToken($token)
    {
        $file = \DB::table('access_rights')->where('file_access_token', $token)->first();
        if (!$file)
        {
            $request->session()->flash('alert-error', 'File does not exists');
            return redirect()->to('/');
        }
        $file    = File::find($file->file_id);
        $creator = $file->users()->where('is_creator', true)->first();

        $path = FileCls::GetFilePath($file, $creator);

        if (!Storage::disk('local')->exists($path))
        {
            $request->session()->flash('alert-error', 'File does not exists');
            return redirect()->to('/');
        }

        $storagePrefix = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $name          = "{$file->name}.{$file->extension}";
        return response()->download($storagePrefix . $path, $name);
    }
}
