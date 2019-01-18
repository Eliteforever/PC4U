<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleProducts extends Model
{
    protected $table = 'SaleProducts';

    protected $fillable = [
        'productID', 'saleAmount', 'percent', 'startDate', 'endDate',
    ];
}
