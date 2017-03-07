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
        $directories = Auth::user()->directories()->where('is_creator', true)->where('parent_id', null)->get();
        return view('home')->with(['directories' => $directories]);
    }

    public function sharedWithMe(){
        $directories = Auth::user()->directories()->where('is_creator', null)->get();
        return view('home')->with(['directories' => $directories]);
    }
}
