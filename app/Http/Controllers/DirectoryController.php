<?php

namespace App\Http\Controllers;

use App\Directory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Storage;

class DirectoryController extends Controller
{

    public function index($id = '')
    {
        if ($id != '') {
            $directory = Directory::find($id);
            $dirModel = new Directory();
            $parents = array();
            $parents = $dirModel->getParents($directory, $parents);
            return view('directory')->with(['directory' => $directory, 'parents' => $parents]);
        } else {
            return redirect()->route('home');
        }
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $user     = Auth::user();
        $name     = md5($request->directory_name . $user->id . time());
        $fullPath = "{$user->id}/{$name}";

        Storage::makeDirectory($fullPath);

        $directory                = new Directory();
        $directory->name          = $name;
        $directory->user_id       = $user->id;
        $directory->original_name = $request->directory_name;
        if ($request->parent_id != '') {
            $parent = Directory::find($request->parent_id);

            if (!$parent) {
                $request->session()->flash('alert-error', 'Parent directory not exists!');
                return redirect()->route("home");
            }
            $parent->directories()->save($directory);
        } else {
            $directory->save();

        }

        $request->session()->flash('alert-success', 'Directory created!');
        if ($request->parent_id != '') {
            return redirect()->route("directory", ['id' => $request->parent_id]);
        }
        return redirect()->route("home");
    }

    private function validator(array $data)
    {
        return Validator::make($data, [
            'directory_name' => 'required|max:255',
        ]);
    }
}
