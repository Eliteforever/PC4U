<?php

namespace App\Http\Controllers;

use App\Traits\uploadTrait;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\SaleProducts;
use Image;

class SalesController extends Controller
{
    use uploadTrait;
	public function __construct()
    {
		 $this->middleware('admin', ['except' => ['parseProductsTroughSales', 'BannerTest']]);
    }
	
    public static function parseProductsTroughSales($products){
    	$productsKeyed = array();
    	$productIDs = array();

    	foreach ($products as $product){
    		$productsKeyed[$product['id']] = $product;
    		array_push($productIDs, $product['id']);
    	}

    	$currDate = date('Y-m-d H:i:s');

		
    	$TEMPORARYQUERY = SaleProducts::whereIn('SaleProducts.productID', $productIDs)
    	 					 ->orderBy('SaleProducts.percent')
    	 					 ->orderBy('SaleProducts.productID')
    	 					 ->orderBy('SaleProducts.startDate')
    	 					 ->get();
		
		foreach($TEMPORARYQUERY as $TEMPsaleProduct) {
			$productsKeyed[$TEMPsaleProduct['productID']]['TEMPsaleAmount'] = $TEMPsaleProduct['saleAmount'];
			$productsKeyed[$TEMPsaleProduct['productID']]['TEMPpercent'] = $TEMPsaleProduct['percent'];
			$productsKeyed[$TEMPsaleProduct['productID']]['TEMPstartDate'] = $TEMPsaleProduct['startDate'];
			$productsKeyed[$TEMPsaleProduct['productID']]['TEMPendDate'] = $TEMPsaleProduct['endDate'];
		}
		
    	$query = SaleProducts::whereIn('SaleProducts.productID', $productIDs)
    	 					 ->where('SaleProducts.startDate', '<=', $currDate)
    	 					 ->where('SaleProducts.endDate', '>=', $currDate)
    	 					 ->orderBy('SaleProducts.percent')
    	 					 ->orderBy('SaleProducts.productID')
    	 					 ->orderBy('SaleProducts.startDate')
    	 					 ->get();
    	// Set priceAfterDiscount to price + btw
    	foreach ($query as $saleProduct){
			$productsKeyed[$saleProduct['productID']]['saleAmount'] = $saleProduct['saleAmount'];
			$productsKeyed[$saleProduct['productID']]['percent'] = $saleProduct['percent'];
			$productsKeyed[$saleProduct['productID']]['startDate'] = $saleProduct['startDate'];
			$productsKeyed[$saleProduct['productID']]['endDate'] = $saleProduct['endDate'];
    		$productsKeyed[$saleProduct['productID']]['priceAfterDiscount'] = 
    			$productsKeyed[$saleProduct['productID']]['price'] * (1 + (
    			$productsKeyed[$saleProduct['productID']]['btw'] / 100));
    	}

    	foreach ($query as $saleProduct){
    		if (!$saleProduct['percent']){
    			$productsKeyed[$saleProduct['productID']]['priceAfterDiscount'] -= $saleProduct['saleAmount'];
    		} else {
    			$productsKeyed[$saleProduct['productID']]['priceAfterDiscount'] *= 1 - (($saleProduct['saleAmount']) / 100);
    		}
    	}
		
    	return $productsKeyed;
    }

    public function BannerTest()
    {
        $img = Image::make(public_path() . '/imgs/banners/wit.png');

        $img->text('Bla', 335, 175, function ($font) {
            $font->file(public_path() . '/fonts/font.ttf');
            $font->size(34);
            $font->color("#ffffff");
            $font->align('center');
            $font->valign('top');
        });

        $img->response('png');
    }
	
	protected function removeSales(Request $request) {
		if($request['productIDs'] == null) {
				
			return redirect()->route('adminSales')->with('message-error', 'Er zijn geen producten geselecteerd.');
		} else {
			$request['productIDs'] = explode(',', $request['productIDs']);
			foreach($request['productIDs'] as $id) {
				SaleProducts::where('productID', $id)->delete();
			}
			
			return redirect()->route('adminSales')->with('message-succes', 'Aanbiedingen succesvol verwijderd.');
		}
	}
	
	protected function createEditSales(Request $request) {
		if($request['productIDs'] == null) {
			
			return redirect()->route('adminSales')->with('message-error', 'Er zijn geen producten geselecteerd.');
		} else if ($request['saleVal'] == null || $request['percent'] == null || $request['startDate'] == null 
				|| $request['endDate'] == null) {
				
			return redirect()->route('adminSales')->with('message-error', 'Zorg ervoor dat alle velden zijn ingevuld.');
		} else {
			$request['productIDs'] = explode(',', $request['productIDs']);
			
			$startDate = date_create();
			$request['startDate'] = date_timestamp_set($startDate, strtotime($request['startDate']));
			
			$endDate = date_create();
			$request['endDate'] = date_timestamp_set($endDate, strtotime($request['endDate']));
			
			if($request['percent'] == "true") {
				$request['percent'] =  1;
			} else {
				$request['percent'] = 0;
			}
			
			foreach($request['productIDs'] as $id) {
				SaleProducts::updateOrCreate(
					['productID' => $id],
					['saleAmount' => $request['saleVal'], 
					 'percent' => (intval($request['percent']) === 1),
					 'startDate' => $request['startDate'],
					 'endDate' => $request['endDate']]
				);
			}
			
			return redirect()->route('adminSales')->with('message-success', 'Aanbiedingen succesvol toegepast.');
		}
	}
	
	protected function adminSales() {
		return view('admin.sales', compact('productInfo'));
	}
}
