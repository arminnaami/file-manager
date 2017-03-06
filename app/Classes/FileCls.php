<?php
namespace App\Classes;

use App\Directory;
use Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class FileCls {

	public static function ValidateImage($file){

	    // Build the input for validation
	    $fileArray = array('image' => $file);

	    // Tell the validator that this file should be an image
	    $rules = array(
	      'image' => 'mimes:jpeg,jpg,png,gif'
	    );

	    // Now pass the input and rules into the validator
	    $validator = Validator::make($fileArray, $rules);

		return $validator;
	}
}