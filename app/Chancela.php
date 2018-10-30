<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chancela extends Model
{
    protected $table = 'chancelas';

    protected $fillable = [
        'valor'
    ];
}
