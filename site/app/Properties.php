<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Properties extends Model
{
    protected $table = 'Properties';

    protected $fillable = [
        'name', 'description', 'categoryID', 'datatype', 'postfix', 'prefix',
    ];
}
