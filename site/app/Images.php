<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
	protected $table = 'Images';

    protected $fillable = [
        'folder', 'filename',
    ];
}