<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trees extends Model
{
    protected $table = 'trees';

    protected $fillable = [
        'trees' , 'paid_usd' , 'paid_inr'
    ];
}
