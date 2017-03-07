<?php
namespace App\Classes;

use App\Directory;
use Storage;
use App\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;
class FileCls {

	public static function ImageValidator(UploadedFile $file){

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

	public static function GetUniqueFileName(UploadedFile $file){
		$fileHash = sha1_file($file->path());
		$uniqueId = uniqid();
		return md5($fileHash.$uniqueId);
	}

	public static function ChangeProfilePicture(\App\User $user, UploadedFile $profilePicture){
		if(!self::ImageValidator($profilePicture)->fails()){

			$oldPicture = File::find($user->profile_picture_id);

			$fileName = self::GetUniqueFileName($profilePicture);

			$path = "public/{$user->id}";
			Storage::putFileAs($path, $profilePicture, $fileName);

			$file = new File();
			$file->name = pathinfo($profilePicture->getClientOriginalName(), PATHINFO_FILENAME);
			$file->private_name = pathinfo($fileName, PATHINFO_FILENAME);
			$file->extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
			$file->description = 'Profile picture from '. date('d-m-Y');
			$file->is_crypted = 0;
			$file->save();

			$user->profile_picture_id = $file->id;
			$user->save();

			if($oldPicture->id != 1){
				$oldPicture->delete();
				$path = "public/{$user->id}/{$oldPicture->private_name}.{$oldPicture->extension}";
				Storage::delete($path);
			}

		}
	}

	public static function SaveFile(\App\User $user, UploadedFile $file, \App\Directory $directory = null){

			if($directory == null){
				$directory = new Directory();
			}

			$fileName = self::GetUniqueFileName($file);

			$path = DirectoryCls::GetDirectoryFullPath($directory, $user);

			Storage::putFileAs($path, $file, $fileName);

			$newFile = new File();
			$newFile->name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
			$newFile->private_name = pathinfo($fileName, PATHINFO_FILENAME);
			$newFile->extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
			$newFile->description = 'TODO'. date('d-m-Y');
			$newFile->is_crypted = 0;
			$newFile->save();


       		$user->files()->attach($newFile->id, ['is_creator' => true]);

	}
}