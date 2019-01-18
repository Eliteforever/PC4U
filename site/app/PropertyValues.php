<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyValues extends Model
{
    protected $table = 'PropertyValues';

    protected $fillable = [
        'propertyID', 'productID', 'value',
    ];
}
