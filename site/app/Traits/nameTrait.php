<?php

namespace App\Traits;

use App\User;
use Illuminate\Support\Facades\Auth;

trait nameTrait
{
    public static function getName()
    {
        $name = "";
        $name .= Auth::user()->firstName;
        if(count(Auth::user()->middleName) > 0) {
            $name .= " " . Auth::user()->middleName;
        }
        $name .= " " . Auth::user()->lastName;

        return $name;
    }

    public static function getSpecificName($userID)
    {
        $user = User::where('id', $userID)->first();
        $name = "";
        $name .= $user->firstName;
        if(count($user->middleName) > 0) {
            $name .= " " . $user->middleName;
        }
        $name .= " " . $user->lastName;

        return $name;
    }
}