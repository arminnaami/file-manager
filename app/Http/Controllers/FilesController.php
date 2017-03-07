<?php

namespace App\Http\Controllers;

use App\Classes\FileCls;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request){
    	if(!$request->file('file')){
    		$request->session()->flash('alert-error', 'Please select file');
            return redirect()->back();
    	}
    	$user = Auth::user();
    	FileCls::SaveFile($user, $request->file('file'));

    	$request->session()->flash('alert-success', 'File upload complete');
		return redirect()->back();
    }
}
