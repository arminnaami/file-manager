<?php

namespace App\Http\Controllers;

use App\Extension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminExtensionsController extends Controller
{
    public function index(Request $request)
    {
        $extensions    = array();
        $blocked       = array();
        $getDefault    = false;
        $searchEnabled = ($request->search_enabled != '') ? $request->search_enabled : '';
        $searchBlocked = ($request->search_blocked != '') ? $request->search_blocked : '';
        if ($request->do_search)
        {
            if ($request->is_blocked && $searchBlocked != '')
            {
                $searchBlocked = strtolower(preg_replace('/\s+/', '', trim($searchBlocked, '.')));
                $extensions    = Extension::where('is_blocked', false)->get()->sortBy("id");
                $blocked       = Extension::where('is_blocked', true)->where('id', 'like', "%{$searchBlocked}%")->get()->sortBy("id");
            }
            elseif ($searchEnabled != '')
            {
                $searchEnabled = strtolower(preg_replace('/\s+/', '', trim($searchEnabled, '.')));
                $extensions    = Extension::where('is_blocked', false)->where('id', 'like', "%{$searchEnabled}%")->get()->sortBy("id");
                $blocked       = Extension::where('is_blocked', true)->get()->sortBy("id");
            }
            else
            {
                $getDefault = true;
            }
        }
        else
        {
            $getDefault = true;
        }
        if ($getDefault)
        {
            $extensions = Extension::where('is_blocked', false)->get()->sortBy("id");
            $blocked    = Extension::where('is_blocked', true)->get()->sortBy("id");
        }
        return view('admin.extensions.index')
            ->with('extensions', $extensions)
            ->with('blocked', $blocked)
            ->with('searchEnabled', $searchEnabled)
            ->with('searchBlocked', $searchBlocked);
    }

    public function blockExtension($id, Request $request)
    {
        $extension = Extension::find($id);
        if ($extension == null)
        {
            $request->session()->flash('alert-error', 'Extension not found');
            return redirect()->back();
        }

        $extension->is_blocked = true;
        $extension->save();

        $request->session()->flash('alert-success', 'Extension blocked');
        return redirect()->back();
    }

    public function unblockExtension($id, Request $request)
    {
        $extension = Extension::find($id);
        if ($extension == null)
        {
            $request->session()->flash('alert-error', 'Extension not found');
            return redirect()->back();
        }

        $extension->is_blocked = false;
        $extension->save();

        $request->session()->flash('alert-success', 'Extension unblocked');
        return redirect()->back();
    }

    public function store(Request $request)
    {
        $errors  =$this->validator($request->all())->errors();
        if (!$errors->isEmpty())
        {
            foreach ($errors->all() as $error)
            {
                $request->session()->flash('alert-error', $error);
            }
            return redirect()->back();
        }

        
        $extension = strtolower(preg_replace('/\s+/', '', trim($request->extension, '.')));
        if ($extension == '')
        {

            $request->session()->flash('alert-error', 'Extension not found');
            return redirect()->back();
        }

        $extensionObj = Extension::find($extension);
        if ($extensionObj != null)
        {
            $request->session()->flash('alert-error', 'Extension already exists');
            return redirect()->back();
        }

        $extensionObj             = new Extension();
        $extensionObj->id         = $extension;
        $extensionObj->icon_id    = '#file';
        $extensionObj->is_blocked = false;
        $extensionObj->save();

        $request->session()->flash('alert-success', 'Extension created');
        return redirect()->back();
    }

      private function validator(array $data)
    {
        return Validator::make($data, [
            'extension' => 'required|max:255',
        ]);
    }
}
