<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminPackagesController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('admin.packages.index')->with('packages', $packages);
    }

    /**
     * @param integer $id
     */
    public function edit(int $id)
    {

        $package = Package::find($id);
        if ($package == null)
        {
            $request->session()->flash('alert-error', 'Package not found');
            return redirect()->back();
        }

        return view('admin.packages.edit')->with('package', $package);
    }

    public function create()
    {
        return view('admin.packages.edit')->with('package', new Package());
    }
    /**
     * @param int $id
     * @param Request $request
     */
    public function save(int $id, Request $request)
    {

        $package = Package::find($id);
        $errors  = $this->validator($request->all(), $package)->errors();
        if (!$errors->isEmpty())
        {
            foreach ($errors->all() as $error)
            {
                $request->session()->flash('alert-error', $error);
            }
            return redirect()->back();
        }

        $package->name           = $request->name;
        $package->code           = strtoupper(preg_replace('/\s+/', '', trim($request->code)));
        $package->max_inodes     = $request->max_inodes;
        $package->max_file_size  = $request->max_file_size;
        $package->max_disk_space = $request->max_disk_space;
        $package->save();
        $request->session()->flash('alert-success', 'The package has been saved');
        return redirect()->route('packages');
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $package = new Package();
        $errors  = $this->validator($request->all(), $package)->errors();
        if (!$errors->isEmpty())
        {
            foreach ($errors->all() as $error)
            {
                $request->session()->flash('alert-error', $error);
            }
            return redirect()->back();
        }

        $package->name           = $request->name;
        $package->code           = strtoupper(preg_replace('/\s+/', '', trim($request->code)));
        $package->max_inodes     = $request->max_inodes;
        $package->max_file_size  = $request->max_file_size;
        $package->max_disk_space = $request->max_disk_space;
        $package->save();

        $request->session()->flash('alert-success', 'The package has been saved');
        return redirect()->route('packages');
    }

    /**
     * Get a validator for an incoming save package request
     *
     * @param  array  $data
     * @param  Package $package
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, Package $package)
    {
        return Validator::make($data, [
            'name'           => 'required|min:6|max:255|unique:packages,name,' . $package->id,
            'code'           => 'required|min:4|max:14|unique:packages,code,' . $package->id,
            'max_inodes'     => 'required|integer',
            'max_file_size'  => 'required|integer',
            'max_disk_space' => 'required|integer',
        ]);
    }

}
