<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProducts extends Model
{
    protected $table = 'OrderProducts';

    protected $fillable = [
        'orderID', 'productID', 'amount',
    ];
}
