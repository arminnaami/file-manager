<?php

namespace App\Http\Controllers;

use App\Directory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DirectoryController extends Controller
{
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $directory          = new Directory();
        $directory->name    = $request->directory_name;
        $directory->user_id = Auth::user()->id;
        $directory->save();

        $request->session()->flash('alert-success', 'Directory created!');
        return redirect()->route("home");
    }

    private function validator(array $data)
    {
        return Validator::make($data, [
            'directory_name' => 'required|max:255',
        ]);
    }
}
