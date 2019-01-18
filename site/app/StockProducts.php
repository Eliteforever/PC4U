<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockProducts extends Model
{
    protected $table = 'StockProducts';

    protected $fillable = [
        'productID', 'amount',
    ];
}
