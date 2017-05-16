<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {

        return view('admin.index');
    }

    public function users()
    {
        $users = Role::with('users')->where('code', '!=', 'ADMIN')->get();
        $users = $users[0]->users()->paginate(50);
        return view('admin.users')->with('users', $users)->with('showManagers', false);
    }

    public function managers()
    {
        $users = Role::with('users')->where('code', 'MANAGER')->paginate(50);
        return view('admin.users')->with('users', $users)->with('showManagers', true);
    }

    public function blockUser($id, Request $request)
    {
        $user = User::find($id);
        if ($user == null) {
            $request->session()->flash('alert-error', 'User not found');
            return redirect()->back();
        }

        $user->is_blocked = true;
        $user->save();

        $request->session()->flash('alert-success', 'User blocked');
        return redirect()->back();
    }

    public function unblockUser($id, Request $request)
    {
        $user = User::find($id);
        if ($user == null) {
            $request->session()->flash('alert-error', 'User not found');
            return redirect()->back();
        }

        $user->is_blocked = false;
        $user->save();

        $request->session()->flash('alert-success', 'User unblocked');
        return redirect()->back();

    }
    public function makeManager($id, Request $request)
    {
        $user = User::find($id);
        if ($user == null) {
            $request->session()->flash('alert-error', 'User not found');
            return redirect()->back();
        }
        $role = Role::where('code', 'MANAGER')->first();
        $user->addRole($role);
        $request->session()->flash('alert-success', 'User promoted');
        return redirect()->back();

    }
    public function removeManager($id, Request $request)
    {
        $user = User::find($id);
        if ($user == null) {
            $request->session()->flash('alert-error', 'User not found');
            return redirect()->back();
        }
        $role = Role::where('code', 'USER')->first();
        $user->addRole($role);
        $request->session()->flash('alert-success', 'Manager removed');
        return redirect()->back();

    }
}
