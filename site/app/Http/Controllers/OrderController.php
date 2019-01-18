<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SalesController;
use App\OrderProducts;
use App\Orders;
use App\Products;
use App\SaleProducts;
use App\ContactData;
use App\Addresses;
use App\User;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function viewOrder(Request $request, $orderID)
    {
        if(Orders::where('uniqueOrderID', $orderID)->first() != null){
            $orderedProducts = array();
            $order = Orders::where('uniqueOrderID', $orderID)->first();
            $products = OrderProducts::where('orderID', $order->id)->get();
            foreach ($products as $product) {
				$sale =  SaleProducts::where('productID', $product->productID)->first();
				$productQuery = Products::where('id', $product->productID)->first();
				
				if($sale !== null) {
					$sale['priceAfterDiscount']  = $productQuery['price'];
					if (!$sale['percent']){
						$sale['priceAfterDiscount'] -= $sale['saleAmount'];
					} else {
						$sale['priceAfterDiscount'] *= 1 - (($sale['saleAmount']) / 100);
					}
					$productQuery['price'] = $sale['priceAfterDiscount'];
				}
				
				
                $product = array(
                    'product' => $productQuery,
                    'amount' => $product->amount
                );
				
                array_push($orderedProducts, $product);
            }
            $orderInfo = array(
                'orderInfo' => array(
                    'uniqueOrderID' => $orderID
                ),
                'products' => $orderedProducts,
                'user' => User::where('id', $order->userID)->first()
            );
            return view('orders.viewOrder', compact('orderInfo'));
        }else {
            return redirect('home');
        }
    }
	
    public function allOrdersAdmin(Request $request)
    {
        $allOrders = Orders::get();
		foreach($allOrders as $index => $order) {
			$userdata = User::where('id', $order->userID)->first();
			$allOrders[$index]['email'] = $userdata->email;
		}
        return view('admin.orders', compact('allOrders'));
    }
	
    public function allOrders(Request $request)
    {
        $allOrders = Orders::where('userID', Auth::user()->id)->get();
        return view('orders.allOrders', compact('allOrders'));
    }

    public static function getOrderByUUID($uuid){
        $orderID = Orders::where('uniqueOrderID', $uuid)->first()['id'];

        $order = Orders::where('uniqueOrderID', $uuid)
                       ->join('users', 'users.id', '=', 'Orders.userID')
                       ->join('Addresses', 'users.addressID', '=', 'Addresses.id')
                       ->first();

        $orderProducts = OrderProducts::where('orderID', $orderID)
                                      ->join('Products', 'OrderProducts.productID', '=', 'Products.id')
                                      ->get();       

        $order->products = SalesController::parseProductsTroughSales($orderProducts);

        return collect($order->toArray())->except(['password']);
    }

    public function getFactuurPDF(Request $request, $uuid){

        $orderDetails = OrderController::getOrderByUUID($uuid);
        $orderDetails['name'] = $orderDetails['firstName'][0] . '. ';
        if (strlen($orderDetails['middleName']) > 0){
            $orderDetails['name'] .= $orderDetails['middleName'] . ' ';
        }
        $orderDetails['name'] .= $orderDetails['lastName'];

        $companyDetails = ContactData::join('Addresses', 'ContactData.addressID', '=', 'Addresses.id')
                                     ->first();

        $data = (object)    ['orderDetails' => $orderDetails
                            ,'companyDetails' => $companyDetails];

        //return $final;
        $pdf = PDF::loadView('pdf.factuur', compact('data'));
        return $pdf->stream('factuur.pdf');
    }
}
