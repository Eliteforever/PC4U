<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    protected $table = 'OrderProducts';

    protected $fillable = [
        'orderID', 'orderStatusID', 'statusDatetime',
    ];
}
