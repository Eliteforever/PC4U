<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'Orders';

    protected $fillable = [
        'userID', 'uniqueOrderID'
    ];
}
