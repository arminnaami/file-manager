<?php
namespace App\Classes;

use App\Directory;
use App\User;
use Storage;
use ZipArchive;

class DirectoryCls
{
    /**
     * @param Directory $directory
     * @param User $user
     * @return mixed
     */
    public static function GetDirectoryFullPath(Directory $directory, User $user)
    {

        $parents = $directory->getParentsTree();

        $path = '/' . $user->id;

        if (!$parents)
        {
            if ($directory->name == '')
            {
                return $path . '/';
            }
            return $path . '/' . $directory->name . '/';
        }

        if (count($parents) > 0)
        {
            $path = $parents[0]->users()->where('is_creator', true)->get()[0]->id;
        }
        $path .= '/';
        foreach ($parents as $parent)
        {
            $path .= "{$parent->name}/";
        }
        $path = $path . $directory->name . '/';
        return $path;
    }
    /**
     * @param Directory $directory
     * @param User $user
     */
    public static function CreateDirectory(Directory $directory, User $user)
    {

        $path = self::GetDirectoryFullPath($directory, $user);
        Storage::makeDirectory($path);

        $directory->save();
        $user->directories()->attach($directory->id, ['is_creator' => true]);
    }

    /**
     * @param Directory $directory
     * @param User $user
     * @return null
     */
    public static function DeleteDirectory(Directory $directory, User $user)
    {
        if (!$directory->users()->find($user->id)->pivot->is_creator)
        {
            $user->removeDirectory($directory);
            return;
        }

        $path = self::GetDirectoryFullPath($directory, $user);
        Storage::deleteDirectory($path);
        $directory->delete();
    }

    /**
     * @param Directory $directory
     */
    public static function Zip(Directory $directory)
    {

        $creator = $directory->users()->where('is_creator', true)->get()[0];

        $dirPath       = DirectoryCls::GetDirectoryFullPath($directory, $creator);
        $storagePrefix = \Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $dirSep = DIRECTORY_SEPARATOR;

        $tmpPath = "{$creator->id}{$dirSep}tmp{$dirSep}";
        \Storage::makeDirectory($tmpPath);

        $zipPath = "{$storagePrefix}{$tmpPath}{$directory->original_name}.zip";

        $dirName = str_replace($dirSep . $dirSep, $dirSep, $storagePrefix . $dirPath);

        /////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////

        $zip = new ZipArchive();
        $zip->open($zipPath, ZipArchive::CREATE);

        if (!is_dir($dirName))
        {
            throw new Exception('Directory ' . $dirName . ' does not exist');
        }

        $dirName = realpath($dirName);
        if (substr($dirName, -1) != '/')
        {
            $dirName .= '/';
        }

        $dirStack = array($dirName);
        //Find the index where the last dir starts
        $cutFrom = strrpos(substr($dirName, 0, -1), '/') + 1;

        while (!empty($dirStack))
        {
            $currentDir = array_pop($dirStack);
            $filesToAdd = array();

            $dir = dir($currentDir);
            while (false !== ($node = $dir->read()))
            {
                if (($node == '..') || ($node == '.'))
                {
                    continue;
                }
                if (is_dir($currentDir . $node))
                {
                    array_push($dirStack, $currentDir . $node . '/');
                }
                if (is_file($currentDir . $node))
                {
                    $filesToAdd[] = $node;
                }
            }

            $localDir = substr($currentDir, $cutFrom);
            $localDir = self::replacePrivateNameWithPublic($localDir, $creator);
            $zip->addEmptyDir($localDir);

            foreach ($filesToAdd as $file)
            {
                $fileObj = $creator->files()->where('private_name', $file)->get()[0];
                if ($fileObj)
                {

                    $zip->addFile($currentDir . $file, $localDir . $fileObj->name . '.' . $fileObj->extension);
                }
            }
        }
        $zip->close();
        return $zipPath;
    }

    /**
     * @param $dirPath
     * @param User $user
     */
    private static function replacePrivateNameWithPublic($dirPath, User $user)
    {
        $arrDirPaths = explode(DIRECTORY_SEPARATOR, trim($dirPath, DIRECTORY_SEPARATOR));
        foreach ($arrDirPaths as $key => $dirPath)
        {
            if ($dirPath != '')
            {
                $dir = $user->directories()->where('name', $dirPath)->get()[0];
                if ($dir)
                {
                    $arrDirPaths[$key] = $dir->original_name;
                }
            }
        }
        $dirPath = implode(DIRECTORY_SEPARATOR, $arrDirPaths);
        return trim($dirPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    /**
     * @param Directory $directory
     * @param User $user
     */
    public static function GetDirectorySize(Directory $directory, User $user)
    {

        $path        = DirectoryCls::GetDirectoryFullPath($directory, $user);
        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $path        = str_replace('//', '/', $storagePath . $path);
        $path        = rtrim(str_replace('\\', '/', $path), '/');
        if (is_dir($path) === true)
        {
            $totalSize = 0;
            $os        = strtoupper(substr(PHP_OS, 0, 3));
            // If on a Unix Host (Linux, Mac OS)
            if ($os !== 'WIN')
            {
                $io = popen('/usr/bin/du -sb ' . $path, 'r');
                if ($io !== false)
                {
                    $totalSize = intval(fgets($io, 80));
                    pclose($io);
                    return number_format($totalSize / (1024 * 1024), 2);
                }
            }
            // If on a Windows Host (WIN32, WINNT, Windows)
            if ($os === 'WIN' && extension_loaded('com_dotnet'))
            {
                $obj = new \COM('scripting.filesystemobject');
                if (is_object($obj))
                {
                    $ref       = $obj->getfolder($path);
                    $totalSize = $ref->size;
                    $obj       = null;
                    return floatval($totalSize / (1024 * 1024));
                }
            }
            // If System calls did't work, use slower PHP 5
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
            foreach ($files as $file)
            {
                $totalSize += $file->getSize();
            }
            return floatval($totalSize / (1024 * 1024));
        }
        else if (is_file($path) === true)
        {
            return floatval(filesize($path) / (1024 * 1024));
        }

    }

    /**
     * @param User $user
     */
    public static function GetUserDriveSize(User $user)
    {
        return self::GetDirectorySize(new Directory, $user);
    }

}
