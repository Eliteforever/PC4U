<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactData extends Model
{
    protected $table = 'ContactData';

    protected $fillable = [
        'email', 'phoneNumber', 'addressID',
    ];
}
