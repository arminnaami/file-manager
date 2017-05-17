<?php

namespace App\Http\Controllers;

use App\Package;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class AdminUsersController extends Controller
{

    public function index()
    {
        $users = User::whereHas(
            'role', function ($q)
            {
                $q->where('code', 'USER');
            }
        )->paginate(50);

        $packages = Package::all();

        return view('admin.users.index')
            ->with('users', $users)
            ->with('showManagers', false)
            ->with('packages', $packages);
    }

    public function managers()
    {
        $users = User::whereHas(
            'role', function ($q)
            {
                $q->where('code', 'MANAGER');
            }
        )->paginate(50);

        $packages = Package::all();

        return view('admin.users.index')
            ->with('users', $users)
            ->with('showManagers', true)
            ->with('packages', $packages);
    }
    /**
     * @param Request $request
     */
    public function changePackage(Request $request)
    {
        if ($request->user_id == '')
        {
            return \Response::json(array('message' => 'User not found'), 404);
        }

        $user = User::find($request->user_id);
        if (!$user)
        {
            return \Response::json(array('message' => 'User not found'), 404);
        }

        if ($request->user_package_id == '')
        {
            return \Response::json(array('message' => 'Please select package'), 404);
        }

        $package = Package::find($request->user_package_id);
        if (!$package)
        {
            return \Response::json(array('message' => 'Package not found'), 404);
        }

        $user->package_id = $package->id;
        $user->save();

        return \Response::json(array('success'), 201);
    }
    /**
     * @param $id
     * @param Request $request
     */
    public function blockUser($id, Request $request)
    {
        $user = User::find($id);
        if ($user == null)
        {
            $request->session()->flash('alert-error', 'User not found');
            return redirect()->back();
        }

        $user->is_blocked = true;
        $user->save();

        $request->session()->flash('alert-success', 'User blocked');
        return redirect()->back();
    }

    /**
     * @param $id
     * @param Request $request
     */
    public function unblockUser($id, Request $request)
    {
        $user = User::find($id);
        if ($user == null)
        {
            $request->session()->flash('alert-error', 'User not found');
            return redirect()->back();
        }

        $user->is_blocked = false;
        $user->save();

        $request->session()->flash('alert-success', 'User unblocked');
        return redirect()->back();

    }

    /**
     * @param $id
     * @param Request $request
     */
    public function makeManager($id, Request $request)
    {
        $user = User::find($id);
        if ($user == null)
        {
            $request->session()->flash('alert-error', 'User not found');
            return redirect()->back();
        }
        $role = Role::where('code', 'MANAGER')->first();
        $user->addRole($role);
        $request->session()->flash('alert-success', 'User promoted');
        return redirect()->back();

    }
    /**
     * @param $id
     * @param Request $request
     */
    public function removeManager($id, Request $request)
    {
        $user = User::find($id);
        if ($user == null)
        {
            $request->session()->flash('alert-error', 'User not found');
            return redirect()->back();
        }
        $role = Role::where('code', 'USER')->first();
        $user->addRole($role);
        $request->session()->flash('alert-success', 'Manager removed');
        return redirect()->back();
    }
}
