<?php

namespace App\Http\Controllers;

use App\Classes\FileCls;
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
		$user = Auth::user();
		$allocatedDiskSpace = floatval(\App\Classes\DirectoryCls::GetUserDriveSize($user));
		$allowedSpace = $user->package->max_disk_space;
		$freeSpace = $allowedSpace - $allocatedDiskSpace;
		return view('profile.index')->with([
			'user'       => $user,
			'is_creator' => false,
			'freeSpace'  => round($freeSpace)]);
	}

	public function edit()
	{
		$user = Auth::user();
		$allocatedDiskSpace = floatval(\App\Classes\DirectoryCls::GetUserDriveSize($user));
		$allowedSpace = $user->package->max_disk_space;
		$freeSpace = $allowedSpace - $allocatedDiskSpace;
		return view('profile.edit')->with([
			'user'       => $user,
			'is_creator' => false,
			'freeSpace'  => round($freeSpace)]);
	}

	public function changePassword()
	{
		$user = Auth::user();
		$allocatedDiskSpace = floatval(\App\Classes\DirectoryCls::GetUserDriveSize($user));
		$allowedSpace = $user->package->max_disk_space;
		$freeSpace = $allowedSpace - $allocatedDiskSpace;
		return view('profile.change-password')->with([
			'user'       => $user,
			'is_creator' => false,
			'freeSpace'  => round($freeSpace)]);
	}

	/**
	 * @param Request $request
	 */
	public function changePasswordSubmit(Request $request)
	{

		$this->changePasswordValidator($request->all())->validate();

		$oldPassword = Auth::User()->password;
		if (!\Hash::check($request->password, $oldPassword))
		{
			$request->session()->flash('alert-error', 'Please enter correct old password!');
			return redirect()->back();
		}

		$user = User::find(Auth::user()->id);
		$user->password = \Hash::make($request->new_password);
		$user->save();

		$request->session()->flash('alert-success', 'Password has been changed!');
		return redirect()->route("profile");
	}

	/**
	 * @param Request $request
	 */
	public function store(Request $request)
	{
		$this->validator($request->all())->validate();
		$user = Auth::user();

		$profilePic = null;

		if ($request->file('profile_picture'))
		{
			$profilePic = $request->file('profile_picture');

			$valRes = FileCls::ImageValidator($profilePic);

			if ($valRes->fails())
			{
				$error = $valRes->errors()->getMessages();
				$request->session()->flash('alert-error', $error['image'][0]);
				return redirect()->route("profile_edit");
			}
			FileCls::ChangeProfilePicture($user, $profilePic);
		}

		$user->name = $request->name;
		$user->email = $request->email;
		$user->save();

		$request->session()->flash('alert-success', 'User was successfully edited!');
		return redirect()->route("profile");
	}

	/**
	 * @param array $data
	 */
	private function validator(array $data)
	{
		$user = Auth::user();
		return Validator::make($data, [
			'name'  => 'required|max:255',
			'email' => 'required|email|max:255|unique:users,email,' . $user->id,
		]);
	}

	/**
	 * Get a validator for an incoming change password request
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function changePasswordValidator(array $data)
	{
		$user = Auth::user();
		return Validator::make($data, [
			'password'              => 'required|min:6|confirmed',
			'password_confirmation' => 'required|min:6',
			'new_password'          => 'required|min:6',
		]);
	}

}
