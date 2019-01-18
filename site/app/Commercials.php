<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commercials extends Model
{

	protected $table = 'Commercials';

    protected $fillable = [
    	'isBanner', 'imageID'
    ];
}
