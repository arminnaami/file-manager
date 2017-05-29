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
    /**
     * @param File $file
     * @param User $user
     */
    public static function GetFilePath(File $file, User $user)
    {
        $fileDir = ($file->directory == null) ? new Directory() : $file->directory;
        $path    = DirectoryCls::GetDirectoryFullPath($fileDir, $user);
        $path    = "{$path}{$file->private_name}";
        return $path;
    }
    /**
     * @param UploadedFile $file
     * @return mixed
     */
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

    /**
     * @param UploadedFile $file
     */
    public static function GetUniqueFileName(UploadedFile $file)
    {
        $fileHash = sha1_file($file->path());
        $uniqueId = uniqid();
        return md5($fileHash . $uniqueId);
    }

    /**
     * @param User $user
     * @param UploadedFile $profilePicture
     */
    public static function ChangeProfilePicture(User $user, UploadedFile $profilePicture)
    {
        if (!self::ImageValidator($profilePicture)->fails())
        {

            $oldPicture = $user->profile_picture;

            $fileName  = self::GetUniqueFileName($profilePicture);
            $extension = pathinfo($profilePicture->getClientOriginalName(), PATHINFO_EXTENSION);
            $path      = "public/{$user->id}";
            Storage::putFileAs($path, $profilePicture, $fileName . '.' . $extension);

            $user->profile_picture = $fileName . '.' . $extension;
            $user->save();

            if ($oldPicture != '')
            {
                $path = "{$path}/{$oldPicture}";
                Storage::delete($path);
            }

        }
    }

    /**
     * @param User $user
     * @param UploadedFile $file
     * @param Directory $directory
     */
    public static function SaveFile(User $user, UploadedFile $file, Directory $directory = null)
    {

        if ($directory == null)
        {
            $directory = new Directory();
        }

        $fileName = self::GetUniqueFileName($file);

        $path = DirectoryCls::GetDirectoryFullPath($directory, $user);

        Storage::putFileAs($path, $file, $fileName);

        $newFile               = new File();
        $newFile->name         = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $newFile->private_name = pathinfo($fileName, PATHINFO_FILENAME);
        $newFile->extension    = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $newFile->directory_id = $directory->id;
        $newFile->save();
        $user->addFile($newFile, true);

    }

    /**
     * @param File $file
     * @param User $user
     * @return null
     */
    public static function DeleteFile(File $file, User $user)
    {

        if (!$file->users()->find($user->id)->pivot->is_creator)
        {
            $user->removeFile($file);
            return;
        }
        foreach ($file->users as $v)
        {
            $v->removeFile($file);
        }

        $path = FileCls::GetFilePath($file, $user);
        Storage::delete($path);

        $file->delete();

    }
}
