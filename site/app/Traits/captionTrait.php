<?php

namespace App\Traits;

use App\Commercials;

trait captionTrait
{
    public static function getComemrcialCaption($commercialID)
    {
        $commercialResult = Commercials::where('id', $commercialID)->first();

        if(count($commercialResult->caption) > 0) {
            return $commercialResult->caption;
        }
        return '';
    }
}