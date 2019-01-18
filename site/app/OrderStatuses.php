<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatuses extends Model
{
    protected $table = 'OrderStatuses';

    protected $fillable = [
        'description',
    ];
}
