<?php
namespace App\Classes;

use App\Classes\DirectoryCls;
use App\Directory;
use App\File;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Storage;

class FileCls
{
    public static function GetFilePath(File $file, User $user)
    {
        $fileDir = ($file->directory == null) ? new Directory() : $file->directory;
        $path    = DirectoryCls::GetDirectoryFullPath($fileDir, $user);
        $path    = "{$path}{$file->private_name}";
        return $path;
    }
    public static function ImageValidator(UploadedFile $file)
    {

        // Build the input for validation
        $fileArray = array('image' => $file);

        // Tell the validator that this file should be an image
        $rules = array(
            'image' => 'mimes:jpeg,jpg,png,gif',
        );

        // Now pass the input and rules into the validator
        $validator = Validator::make($fileArray, $rules);

        return $validator;
    }

    public static function GetUniqueFileName(UploadedFile $file)
    {
        $fileHash = sha1_file($file->path());
        $uniqueId = uniqid();
        return md5($fileHash . $uniqueId);
    }

    public static function ChangeProfilePicture(User $user, UploadedFile $profilePicture)
    {
        if (!self::ImageValidator($profilePicture)->fails()) {

            $oldPicture = File::find($user->profile_picture_id);

            $fileName  = self::GetUniqueFileName($profilePicture);
            $extension = pathinfo($profilePicture->getClientOriginalName(), PATHINFO_EXTENSION);
            $path      = "public/{$user->id}";
            Storage::putFileAs($path, $profilePicture, $fileName . '.' . $extension);

            $file               = new File();
            $file->name         = pathinfo($profilePicture->getClientOriginalName(), PATHINFO_FILENAME);
            $file->private_name = pathinfo($fileName, PATHINFO_FILENAME);
            $file->extension    = $extension;
            $file->description  = 'Profile picture from ' . date('d-m-Y');
            $file->is_crypted   = 0;
            $file->save();

            $user->profile_picture_id = $file->id;
            $user->save();

            if ($oldPicture->id != 1) {
                $oldPicture->delete();
                $path = "public/{$user->id}/{$oldPicture->private_name}.{$oldPicture->extension}";
                Storage::delete($path);
            }

        }
    }

    public static function SaveFile(User $user, UploadedFile $file, Directory $directory = null)
    {

        if ($directory == null) {
            $directory = new Directory();
        }

        $fileName = self::GetUniqueFileName($file);

        $path = DirectoryCls::GetDirectoryFullPath($directory, $user);

        Storage::putFileAs($path, $file, $fileName);

        $newFile               = new File();
        $newFile->name         = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $newFile->private_name = pathinfo($fileName, PATHINFO_FILENAME);
        $newFile->extension    = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $newFile->description  = 'TODO' . date('d-m-Y');
        $newFile->is_crypted   = 0;
        $newFile->directory_id = $directory->id;
        $newFile->save();

        $user->files()->attach($newFile->id, ['is_creator' => true]);

    }

    public static function DeleteFile(File $file, User $user)
    {

        if (!$file->users()->find($user->id)->pivot->is_creator) {
            $file->users()->detach($user->id);
            return;
        }
        foreach ($file->users as $v) {
            $file->users()->detach($v->id);
        }

        $path = FileCls::GetFilePath($file, $user);
        Storage::delete($path);

        $file->delete();

    }
}
