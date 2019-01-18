<?php

namespace App\Http\Controllers;

use App\SaleProducts;
use Illuminate\Http\Request;
use App\Commercials;
use App\Images;
use App\Products;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hasRecents = false;
        $hasBanner = false;
        $hasSales = false;

        //Recent items

        if(isset($_COOKIE['recentItems'])) {
            $hasRecents = true;
            $recents = $_COOKIE['recentItems'];
            $recents = json_decode($recents);
            $recentsArr = array();
            foreach($recents as $recent) {
                $product = SalesController::parseProductsTroughSales(Products::where('id', $recent)->get(['id', 'name', 'description', 'price', 'btw', 'imageID']));
                array_push($recentsArr, $product);
            }
        }

        //Banners
		$bannerImageID = Commercials::where('isBanner', '1')->get();

        if(!count($bannerImageID) == 0) {
            $hasBanner = true;
            $bannerImageID = $bannerImageID[0]['imageID'];
            $bannerImageObject = Images::where('id', $bannerImageID)->get();
        }

		$other = Commercials::where('isBanner', '0')->get();

        //Sale products
        $currDate = date('Y-m-d H:i:s');
        $salesArr = array();
        $productsInSale = SaleProducts::select('productID','saleAmount', 'percent')->where('startDate', '<', $currDate)->where('endDate', '>', $currDate)->get();

        if(!count($productsInSale) == 0) {
            $hasSales = true;
            foreach($productsInSale as $product) {
                $product['productID'] = Products::select('id', 'name', 'description', 'imageID','price', 'btw')->where('id', $product['productID'])->first();
                array_push($salesArr, $product);
            }
        }

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

        if($hasRecents) {
            array_push($arr, $recentsArr);
        }else{
            array_push($arr, $emptyArr);
        }

        if($hasSales) {
		    array_push($arr, $salesArr);
        }else{
		    array_push($arr, $emptyArr);
        }

        return view('home', compact('arr'));
    }
    
}
