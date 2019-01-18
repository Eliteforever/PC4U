<?php

namespace App\Traits;
use Illuminate\Support\Facades\File;

trait uploadTrait 
{
	public static function uploadFile($req, $inputName, $folder)
	{
		$image = $req->file($inputName)->getClientOriginalName();
        $filename = $image;
		if (file_exists($filename)) {
        	return 1;
        } else {
            $file = $req->file($inputName);
            $file->move('imgs/' . $folder, $filename);
            return 0;
        }
	}

    public static function deleteFile($folder, $filename){

        $path = 'imgs' . $folder . $filename;

        if (file_exists($path)) {
            File::delete($path);
            return 0;
        } else {    
            return 1;
        }
    }
}

?>