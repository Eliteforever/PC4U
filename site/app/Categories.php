<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'Categories';

    protected $fillable = [
        'name', 'description', 'imageID',
    ];
}
