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
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $id = $request->id;
        if ($id != '') {
            $directory = Directory::find($id);
            if (!$directory) {

                $request->session()->flash('alert-error', 'Directory not found or removed by the creator!');
                return redirect()->route('home');
            }
            $dirModel = new Directory();
            $parents  = array();
            $parents  = DirectoryCls::GetParentsTree($directory);

            $user = Auth::user();
            foreach ($parents as $k => $parent) {
                if (!$parent->users()->find($user->id)) {
                    unset($parents[$k]);
                }
            }

            return view('directory')->with(['mainDir' => $directory, 'parents' => $parents]);
        } else {
            return redirect()->route('home');
        }
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = Auth::user();
        $name = md5($request->directory_name . $user->id . time());

        $directory                = new Directory();
        $directory->name          = $name;
        $directory->original_name = $request->directory_name;
        $directory->parent_id     = $request->parent_id;

        DirectoryCls::CreateDirectory($directory, $user);

        $request->session()->flash('alert-success', 'Directory created!');
        if ($request->parent_id != '') {
            return redirect()->route("directory", ['id' => $request->parent_id]);
        }
        return redirect()->route("home");
    }

    public function delete($id, Request $request)
    {

        $directory = Directory::find($id);
        $parentId  = '';
        if ($directory->parent) {
            $parentId = $directory->parent->id;
        }
        $user = Auth::user();
        DirectoryCls::DeleteDirectory($directory, $user);
        $request->session()->flash('alert-success', 'Directory deleted!');
        if ($parentId != '') {
            return redirect()->route("directory", ['id' => $parentId]);
        }

        return redirect()->back();
    }

    public function share(Request $request)
    {
        if ($request->user_email == '') {
            return \Response::json(array('message' => 'Please enter valid email address'), 404);
        }

        if ($request->user_email == Auth::user()->email) {
            return \Response::json(array('message' => "Can't share folder with yourself"), 404);
        }

        $user = User::where('email', $request->user_email)->first();
        if (!$user) {
            return \Response::json(array('message' => 'User not found'), 404);
        }

        if ($request->directory_id == '') {
            return \Response::json(array('message' => 'Please select folder to share'), 404);
        }

        $directory = Directory::find($request->directory_id);
        if (!$directory) {
            return \Response::json(array('message' => 'Directory not found'), 404);
        }

        if ($directory->users()->where('user_id', $user->id)->first()) {

            return \Response::json(array('message' => 'This folder is already shared with selected user'), 404);
        }

        $directory->users()->attach($user->id, ['is_creator' => false]);
        return \Response::json(array('success'), 201);
    }

    public function download($dirId)
    {
        $directory = Directory::find($dirId);
        $zipPath   = DirectoryCls::Zip($directory);
        return response()->download($zipPath)->deleteFileAfterSend(true);

    }

    private function validator(array $data)
    {
        return Validator::make($data, [
            'directory_name' => 'required|max:255',
        ]);
    }
}
