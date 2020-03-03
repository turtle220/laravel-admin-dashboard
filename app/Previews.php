<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Previews extends Model
{
    protected $table = 'previews';

    protected $fillable = [
        'amount', 'price', 'name' , 'email' , 'phone' , 'websiteMessage' , 'subscribe' , 
        'anonymous' , 'gift' , 'to' , 'from' , 'giftMessage' , 'currency' , 'icon' , 'orderID' , 'payerID' , 
        'facilitatorAccessToken' , 'paymentStatus' , 'fullPayment' , 'paymentMethod'
    ];

}
