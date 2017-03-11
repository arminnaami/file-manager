<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user        = Auth::user();
        $directories = $user->directories()->where('is_creator', true)->where('parent_id', null)->get();
        $files       = $user->files()->where('is_creator', true)->where('directory_id', null)->get();

        return view('home')->with(['directories' => $directories, 'files' => $files]);
    }

    public function sharedWithMe()
    {

        $user        = Auth::user();
        $directories = $user->directories()->where('is_creator', false)->get();
        $files       = $user->files()->where('is_creator', false)->where('directory_id', null)->get();
        return view('home')->with(['directories' => $directories, 'files' => $files]);
    }
}
