<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Role;
class AdminController extends Controller
{
    public function index(){

        return view('admin.index');
    }
    
    public function users(){
        $users = Role::with('users')->where('code', '!=', 'admin')->get();
        $users = $users[0]->users()->paginate(50);
        return view('admin.users')->with('users', $users);
    }

    public function managers(){
        $users = Role::with('users')->where('code', 'manager')->get();
        $users = $users[0]->users()->paginate(50);
        return view('admin.users')->with('users', $users);
    }

    public function blockUser($id, Request $request){
        $user = User::find($id);
        if($user == null){
            $request->session()->flash('alert-error', 'User not found');
            return redirect()->back();
        }

        $user->is_blocked = true;
        $user->save();

        $request->session()->flash('alert-success', 'User blocked');
        return redirect()->back();
    }

    public function unblockUser($id, Request $request){
        $user = User::find($id);
        if($user == null){
            $request->session()->flash('alert-error', 'User not found');
            return redirect()->back();
        }

        $user->is_blocked = false;
        $user->save();

        $request->session()->flash('alert-success', 'User unblocked');
        return redirect()->back();

    }
    public function makeManager($id, Request $request){
        $user = User::find($id);
        if($user == null){
            $request->session()->flash('alert-error', 'User not found');
            return redirect()->back();
        }
        $role = Role::where('code', 'manager')->first();
        $user->addRole($role);
        $request->session()->flash('alert-success', 'User promoted');
        return redirect()->back();

    }
    public function removeManager($id, Request $request){
        $user = User::find($id);
        if($user == null){
            $request->session()->flash('alert-error', 'User not found');
            return redirect()->back();
        }
        $role = Role::where('code', 'user')->first();
        $user->addRole($role);
        $request->session()->flash('alert-success', 'Manager removed');
        return redirect()->back();

    }
}
