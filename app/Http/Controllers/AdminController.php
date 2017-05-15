<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('roles');
    }
    public function index(){

        return view('admin.index')->with('user', Auth::user())->with('is_creator', false);
    }
}
