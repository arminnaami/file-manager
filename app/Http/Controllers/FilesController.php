<?php

namespace App\Http\Controllers;

use App\Classes\DirectoryCls;
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
        $this->middleware('auth');
    }

    public function store($id = '', Request $request)
    {
        if (!$request->file('file')) {
            $request->session()->flash('alert-error', 'Please select file');
            return redirect()->back();
        }

        $directory = new Directory();
        if($id != ''){
            $directory = Directory::find($id);
        }

        $user = Auth::user();
        FileCls::SaveFile($user, $request->file('file'), $directory);

        $request->session()->flash('alert-success', 'File upload complete');
        return redirect()->back();
    }

    public function download($id, Request $request)
    {
        $file = File::find($id);
        if (!$file) {
            $request->session()->flash('alert-error', 'File does not exists');
            return redirect()->back();
        }

        $creator = $file->users()->where('is_creator', true)->first();

        $path = FileCls::GetFilePath($file, $creator);

        if (!Storage::disk('local')->exists($path)) {
            $request->session()->flash('alert-error', 'File does not exists');
            return redirect()->back();
        }

        $storagePrefix = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $name          = "{$file->name}.{$file->extension}";
        return response()->download($storagePrefix . $path, $name);

    }

    public function delete($id, Request $request){
        $file = File::find($id);
        $user = Auth::user();

        if(!$file){
            $request->session()->flash('alert-error', 'File does not exists');
            return redirect()->back();
        }

        FileCls::DeleteFile($file, $user);

        $request->session()->flash('alert-success', 'File deleted!');
        return redirect()->back();
    }
    public function share(Request $request){
        if($request->user_email == '')
        {
            return \Response::json(array('message' => 'Please enter valid email address'), 404);
        }

        if($request->user_email == Auth::user()->email)
        {
            return \Response::json(array('message' => "Can't share file with yourself"), 404);
        }

        $user = User::where('email', $request->user_email)->first();
        if(!$user){
            return \Response::json(array('message' => 'User not found'), 404);
        }

        if($request->file_id == '')
        {
            return \Response::json(array('message' => 'Please select file to share'), 404);
        }

        $file = File::find($request->file_id);
        if(!$file){
            return \Response::json(array('message' => 'File not found'), 404);
        }

        if($file->users()->where('user_id', $user->id)->first()){

            return \Response::json(array('message' => 'This file is already shared with selected user'), 404);
        }

        $file->users()->attach($user->id);
        return \Response::json(array('success'), 201);
    }
}
