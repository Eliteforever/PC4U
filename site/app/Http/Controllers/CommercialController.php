<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commercials;
use App\Images;
use App\Traits\uploadTrait;

class CommercialController extends Controller
{

	use uploadTrait;

    public function __construct()
	{
	    $this->middleware('admin', ['except' => ['getDiscounts']]);
	}

	public function index()
	{

        $hasBanner = false;

		$bannerImageID = Commercials::where('isBanner', '1')->get();

        if(!count($bannerImageID) == 0) {
            $hasBanner = true;
            $bannerImageID = $bannerImageID[0]['imageID'];
            $bannerImageObject = Images::where('id', $bannerImageID)->get();
        }

		$other = Commercials::where('isBanner', '0')->get();

        $temparr = array();
        foreach($other as $oth) {
            $imageObject = Images::where('id', $oth['imageID'])->get();
            array_push($temparr, $imageObject);
        }

		$arr = array();
        $emptyArr = array();
		if($hasBanner) {
            array_push($arr, $bannerImageObject);
            array_push($arr, $temparr);
        }else{
            array_push($arr, $emptyArr);
            array_push($arr, $temparr);
        }
	    
		return view('admin.commercial', compact('arr'));
	}

	public function post(Request $request)
	{

        $canInsert = 1;

        $imageData = json_decode($request['imageSelect'], true);

        $imageX = ImageController::getImageOrCreate($imageData['folder'], $imageData['filename']);
        $imageID = 0;

        if ($imageX != null){
            $imageID = $imageX['id'];
        }

       

		if($request['isBanner']) {
			$isBanner = 1;
			Commercials::where('isBanner', '1')->update([
				'isBanner' => '0'
			]);
		}else{
			$isBanner = 0;
		}

		if($canInsert == 1){


			Commercials::create([
				'isBanner' => $isBanner,
                'imageID' => $imageID
			]);

            $result = "succes";
			$message = "New commercial created";
		}else{

		}

		return redirect()->route('commercial')->with('message-' . $result, $message);
	}

	public function delete(Request $request, $id)
	{
		Commercials::where('imageID', $id)->delete();
		return redirect()->route('commercial')->with('message-success', "Image removed");
	}

	public function makeBanner(Request $request, $id)
	{
		Commercials::where('isBanner', '1')->update(['isBanner' => '0']);

		Commercials::where('imageID', $id)->update(['isBanner' => '1']);

		return redirect()->route('commercial')->with('message-success', "Image changed to banner");
	}
}
