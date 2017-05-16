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
        $user = Auth::user();
        $user->getInodes();
        $directories = $user->getOwnedDirectories();
        $files       = $user->getOwnedFiles();

        return view('home')->with([
            'directories' => $directories,
            'files'       => $files,
            'mainDir'     => null,
            'is_creator'  => true]);
    }

    public function sharedWithMe()
    {

        $user        = Auth::user();
        $directories = $user->getSharedWithMeDirectories();
        $files       = $user->getSharedWIthMeFiles();

        return view('home')->with([
            'directories' => $directories,
            'files'       => $files,
            'is_creator'  => false]);
    }
}
