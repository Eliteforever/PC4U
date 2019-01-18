<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
	protected $table = 'Addresses';

    protected $fillable = [
        'streetName', 'houseNumber', 'postalCode', 'city',
    ];
}
