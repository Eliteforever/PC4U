<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Images;
use App\Categories;
use App\Products;
use Image;
use Illuminate\Support\Facades\File;
use App\Traits\uploadTrait;


class ImageController extends Controller
{
	// Example
	// http://localhost:8000/resizeImage/banners/981.jpg/300x300
	// 300 = width
	// 300 = height
	public function resizeImage(Request $request, $imageFolder, $imageName, $width, $height)
	{
		$img = Image::make(file_get_contents(public_path() . '/imgs/' . $imageFolder . '/' . $imageName));
		$img->resize($width, $height);

		return $img->response('png');
	}

	protected function test(Request $request){
		return view('test.image');
	}

	protected function submit(Request $request){
		if (strpos($request['folder'], "../") === false) {
			uploadTrait::uploadFile($request, 'postImage', $request['folder']);
		}
	}

	protected function delete(Request $request){
		if (strpos($request['folder'], "../") === false) {

			if ($this->getImageUsedCount($request['folder'], $request['filename']) == 0){
				uploadTrait::deleteFile($request['folder'], $request['filename']);		
			} else {
				echo "Image is still in use";
			}		
		}
	}

	protected function getAllImagesInFolder(Request $request){

		app('debugbar')->disable();

		if (strpos($request['folder'], "../") === false) {

			$givenFolder = '/imgs' . $request['folder'];
			$storedFiles = File::files(public_path() . $givenFolder);
			$storedImages = array();

			$images = array();

			foreach ($storedFiles as $storedFile){
				$fileExtension = File::extension($storedFile);

				if ($fileExtension == "jpg" ||
					$fileExtension == "png" || 
					$fileExtension == "jpeg" ||
					$fileExtension == "gif" ||
					$fileExtension == "svg" ||
					$fileExtension == "bmp"){
					array_push($storedImages, $storedFile);
				}
			}

			foreach ($storedImages as $storedImage){

				$image = array(
					'folder' => $givenFolder,
					'basename' => basename((string)$storedImage),
					'usedCount' => $this->getImageUsedCount($request['folder'], basename($storedImage)),
				);

				array_push($images, $image);
			}

			return json_encode($images);
		}
	}

	protected function getAllFoldersInFolder(Request $request){

		app('debugbar')->disable();

		if (strpos($request['folder'], "../") === false) {

			$givenFolder = $request['folder'];
			$fullFolder = '/imgs' . $request['folder'];
			$storedFolders = File::directories(public_path() . $fullFolder);

			$folders = array();

			foreach ($storedFolders as $storedFolder){
				$basename = basename((string)$storedFolder);

				$folder = array(
					'basename' => $basename,
					'folder' => $givenFolder . $basename . '/'
				);

			    array_push($folders, $folder);
			}

			return json_encode($folders);
		}
	}

	protected function getImageUsedCount($folder, $filename){

		$image = Images::where('folder', $folder)->where('filename', $filename)->first();

		$categoryCount = Categories::where('imageID', $image['id'])->count();
		$productCount = Products::where('imageID', $image['id'])->count();

		return $categoryCount + $productCount;
	}

	public static function getImageOrCreate($folder, $filename){
		$image = Images::where('folder', $folder)->where('filename', $filename)->first();

        if ($image != null){
			return $image;
		} else {
			if (File::exists('imgs/' . $folder . $filename)){

				$image = Images::create(['folder' => $folder,
	    								 'filename' => $filename]);

				return $image;
			}
		}

		return null;
	}

    protected function getImage(Request $request, $imageID) {
        $image = Images::where('id', $imageID)->first();
        $img = Image::make(file_get_contents(public_path() . '/imgs' . $image['folder'] . $image['filename']));

        $img->resize(350, 350);

		return $img->response('png');
    }
}
