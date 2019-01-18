<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'Products';

    protected $fillable = [
        'name', 'description', 'price', 'btw', 'imageID',
    ];
}
