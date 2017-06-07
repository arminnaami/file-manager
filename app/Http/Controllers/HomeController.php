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
        $directories = $user->getOwnedDirectories();
        $files       = $user->getOwnedFiles();

        $allocatedDiskSpace = floatval(\App\Classes\DirectoryCls::GetUserDriveSize($user));
        $allowedSpace       = $user->package->max_disk_space;
        $freeSpace          = $allowedSpace - $allocatedDiskSpace;

        return view('client.home')->with([
            'directories' => $directories,
            'files'       => $files,
            'mainDir'     => null,
            'is_creator'  => true,
            'freeSpace'   => round($freeSpace)]);
    }

    public function sharedWithMe()
    {

        $user        = Auth::user();
        $directories = $user->getSharedWithMeDirectories();
        $files       = $user->getSharedWIthMeFiles();

        $allocatedDiskSpace = floatval(\App\Classes\DirectoryCls::GetUserDriveSize($user));
        $allowedSpace       = $user->package->max_disk_space;
        $freeSpace          = $allowedSpace - $allocatedDiskSpace;

        return view('client.home')->with([
            'directories' => $directories,
            'files'       => $files,
            'is_creator'  => false,
            'freeSpace'   => round($freeSpace)]);
    }
}
