<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repairs extends Model
{
    protected $table = 'Repairs';

    protected $fillable = [
        'userID', 'requestedOn', 'description', 'password', 'fileUrl'
    ];
}
