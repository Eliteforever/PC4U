<?php

namespace App\Traits;

use App\Addresses;

trait addressTrait
{
    public static function getAddressInfo($addressID)
    {
        $addressResult = Addresses::where('id', $addressID)->first();

        $address = "";
        $address .= $addressResult->streetName . " ";
        $address .= $addressResult->houseNumber . " ";
        $address .= $addressResult->postalCode . " ";
        $address .= $addressResult->city . " ";

        return $address;
    }
}