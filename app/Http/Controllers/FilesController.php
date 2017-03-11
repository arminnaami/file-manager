<?php

namespace App\Http\Controllers;

use App\Classes\DirectoryCls;
use App\Classes\FileCls;
use App\Directory;
use App\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

class FilesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        if (!$request->file('file')) {
            $request->session()->flash('alert-error', 'Please select file');
            return redirect()->back();
        }
        $user = Auth::user();
        FileCls::SaveFile($user, $request->file('file'));

        $request->session()->flash('alert-success', 'File upload complete');
        return redirect()->back();
    }

    public function download($id, Request $request)
    {
        $user = Auth::user();
        $file = File::find($id);
        if (!$file) {
            $request->session()->flash('alert-error', 'File does not exists');
            return redirect()->back();
        }

        $fileDir = ($file->directory == null) ? new Directory() : $file->directory;
        $path    = DirectoryCls::GetDirectoryFullPath($fileDir, $user);
        $path    = "{$path}/{$file->private_name}";

        if (!Storage::disk('local')->exists($path)) {
            $request->session()->flash('alert-error', 'File does not exists');
            return redirect()->back();
        }

        $storagePrefix = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $name          = "{$file->name}.{$file->extension}";
        return response()->download($storagePrefix . $path, $name);

    }
}
