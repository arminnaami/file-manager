<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
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

    public function index()
    {
        return view('profile.index')->with('user', Auth::user());
    }

    public function edit()
    {
        return view('profile.edit')->with('user', Auth::user());
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $user        = Auth::user();
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        $request->session()->flash('alert-success', 'User was successfully edited!');
        return redirect()->route("profile");
    }

    private function validator(array $data)
    {
        $user = Auth::user();
        return Validator::make($data, [
            'name'  => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);
    }

}
