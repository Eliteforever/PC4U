<?php
 
namespace App\Http\Controllers;
 
use App\Orders;
use App\Products;
use App\Addresses;
use App\OrderProducts;

use App\User;
use PDF;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\checkoutConfirmationMail;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
 
class CheckoutController extends Controller
{
    public function index(Request  $request){
        $arr = array();
        $hasRecents = false;
        if(isset($_COOKIE['cartItems'])) {
            $itemsCookie = json_decode($_COOKIE['cartItems'], true);

            
            for($i = 0; $i < count($itemsCookie); $i++){
                $product = Products::where('id', $itemsCookie[$i][0])->get();

                SalesController::parseProductsTroughSales(array($product[0]));

                $prod = array(
                    'item' => $product,
                    'amount' => $itemsCookie[$i][1]
                );
                array_push($arr, $prod);
            }
        }else{
            
        }


        if(isset($_COOKIE['recentItems'])) {
            $hasRecents = true;
            $recents = $_COOKIE['recentItems'];
            $recents = json_decode($recents);
            $recentsArr = array();
            foreach($recents as $recent) {
                $product = Products::where('id', $recent)->get(['id', 'name', 'description', 'price', 'btw', 'imageID']);
                SalesController::parseProductsTroughSales(array($product[0]));
                array_push($recentsArr, $product);
            }
        }

        $finalArr = array();
        $emptyArr = array();
        array_push($finalArr, $arr);
        if($hasRecents) {
            array_push($finalArr, $recentsArr);
        }else{
            array_push($finalArr, $emptyArr);
        }

        return view('checkout.cart', compact('finalArr'));
    }

    public function checkout(Request $request){
        if(isset($_COOKIE['cartItems']) && strpos($_COOKIE['cartItems'], '[[') === 0){
            $address = $this->getAdressInformation();

            return view('checkout.checkout',  compact('address'));
        }else{
            return redirect()->route('home');
        }
    }

    public function checkoutPost(Request $request) {
        app('debugbar')->disable();
        $token = uniqid();
        if(isset($request['terms'])) {
            if(isset($_COOKIE['cartItems'])) {
                $products = $_COOKIE['cartItems'];
                $products = json_decode($products);

                $order = Orders::create([
                    'userID' => Auth::user()->id,
                    'uniqueOrderID' => $token
                ]);

                foreach($products as $product){
                    OrderProducts::create([
                        'orderID' => $order->id,
                        'productID' => $product[0],
                        'amount' => $product[1]
                    ]);
                }
            }
            $result = "success";
            $message = "Order geplatst";
            \Cookie::queue( \Cookie::forget('cartItems'));
            $mailData = [
                'user' => Auth::user(),
                'orderID' => $token
            ];
            Mail::to(Auth::user()->email)->send(new checkoutConfirmationMail($mailData));
        }else {
            $address = $this->getAdressInformation();
            $result = "error";
            $message = "U moet akkoord gaan met de algemene voorwaarden";
        }
        return redirect()->route('home',  compact('address'))->with('message-' . $result, $message);
    }

    public function getAdressInformation() {
        $address = Addresses::where('id', Auth::user()->addressID)->get();

        $address = $address[0];
        return $address;
    }

    public function getPDF()
    {
        $data = OrderProducts::where('id', 1)->get();
        $final = array();
        foreach ($data as $data) {
            $prod = SalesController::parseProductsTroughSales(Products::where('id', $data['productID'])->get());
            $prod[$data['productID']]['amount'] = $data['amount'];
            array_push($final, $prod);
        }
        $user = Orders::where('id', $data['orderID'])->first(['userID']);
        $user = User::where('id', $user['userID'])->get();
        array_push($final, $user);

        //return $final;
        $pdf = PDF::loadView('pdf.invoice', compact('final'));
        return $pdf->stream('invoice.pdf');

    }
}
 
