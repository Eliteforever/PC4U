<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepairProducts extends Model
{
    protected $table = 'RepairProducts';

    protected $fillable = [
        'repairID', 'productID',
    ];
}
