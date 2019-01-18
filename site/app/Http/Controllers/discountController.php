<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use App\Discounts;


class discountController extends Controller
{

	public function __construct()
	{
	    $this->middleware('admin', ['except' => ['getDiscounts']]);
	}

    public function index(Request $request)
    {
    	
    }

    public function getDiscounts()
    {
    	
    }
}
