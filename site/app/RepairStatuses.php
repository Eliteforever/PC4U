<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepairStatuses extends Model
{
    protected $table = 'RepairStatuses';

    protected $fillable = [
        'description',
    ];
}
