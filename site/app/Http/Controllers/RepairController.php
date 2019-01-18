<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Repairs;
use App\RepairProducts;
use App\Orders;
use App\OrderProducts;
use App\Products;

use App\Traits\uploadTrait;

class RepairController extends Controller
{

	use uploadTrait;

	public function index(Request $request)
	{
		if(Auth::guest()){
			return redirect('login');
		}else{
			$finalOrders = $this->getAllOrders();
			return view('repair.index', compact('finalOrders'));
		}
	}

	public function postRepair(Request $request)
	{

		if($request->file('fotoPad')) {
        	$image = $request->file('fotoPad')->getClientOriginalName();
            $filename = $image;
            if ($request->hasFile('fotoPad')) {
            	$uploadedFileResult = $this->uploadFile($request, 'fotoPad', 'garantiebewijzen');
            }
        }else{
        	$uploadedFileResult = 1;
            $filename = "";
        }

		$repair = Repairs::create([
			'userID' => Auth::user()->id,
			'description' => $request->description,
			'password' => $request->password,
			'fileUrl' => $filename,
			'requestedOn' => Carbon::now()->toDateTimeString()
		]);

		$repairProduct = RepairProducts::create([
			'repairID' => $repair['id'],
			'productID' => $request->get('orders')
		]);

		$finalOrders = $this->getAllOrders();

		if($uploadedFileResult != 1){
			$result = "error";
			$message = "An error occured while uploading your photo.";
		}else{
			$result = "success";
			$message = "Repair has been requested";
		}

		return redirect()->route('repair', compact('finalOrders'))->with('message-' . $result, $message);
	}

	public function getAllOrders()
	{
		$finalOrders = array();
		$orders = Orders::where('userID', Auth::user()->id)->get();
		foreach ($orders as $order_single) {
			$order = OrderProducts::where('orderID', $order_single['id'])->get();
			$product = Products::where('id', $order[0]['productID'])->get();
			$arr = array();
			array_push($arr, $product[0]['id']);
			array_push($arr, $product[0]['name']);
			array_push($finalOrders, $arr);
		}
		return $finalOrders;
	}

    public function adminIndex(Request $request) {
        return view('admin.repairs');
    }
}
