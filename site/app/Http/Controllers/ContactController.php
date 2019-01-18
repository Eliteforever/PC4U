<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContactData;
use App\Addresses;

class ContactController extends Controller
{
    public function index()
    {
    	$contact = ContactData::where('id', '1')->get();

    	$address = Addresses::where('id', $contact[0]['addressID'])->get();

    	$combined = array();
    	array_push($combined, $contact);
    	array_push($combined, $address);

    	return view('contact.index', compact('combined'));
    }

    public function about(Request $request)
    {
        return view('contact.about');
    }
}
