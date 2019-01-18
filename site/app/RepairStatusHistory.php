<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepairStatusHistory extends Model
{
    protected $table = 'RepairStatusHistory';

    protected $fillable = [
        'repairID', 'repairStatusID', 'statusDatetime',
    ];
}
