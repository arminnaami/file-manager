<?php

namespace App\Http\Controllers;

use App\Directory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Classes\DirectoryCls;

class DirectoryController extends Controller
{

    public function index($id = '')
    {
        if ($id != '') {
            $directory = Directory::find($id);
            $dirModel = new Directory();
            $parents = array();
            $parents = DirectoryCls::GetParentsTree($directory);
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

        $directory                = new Directory();
        $directory->name          = $name;
        $directory->original_name = $request->directory_name;
        $directory->parent_id     = $request->parent_id;

        DirectoryCls::CreateDirectory($directory);

        $request->session()->flash('alert-success', 'Directory created!');
        if ($request->parent_id != '') {
            return redirect()->route("directory", ['id' => $request->parent_id]);
        }
        return redirect()->route("home");
    }

    public function delete($id, Request $request){

        $directory = Directory::find($id);
        $parentId = '';
        if($directory->parent)
        {
            $parentId = $directory->parent->id;
        }
        DirectoryCls::DeleteDirectory($directory);
        $request->session()->flash('alert-success', 'Directory deleted!');
        if($parentId != ''){
            return redirect()->route("directory", ['id' => $parentId]);
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
