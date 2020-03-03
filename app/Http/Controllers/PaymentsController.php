<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Razorpay\Api\Api;

class PaymentsController extends Controller
{   
    private $razorpayKeys = [
        'key' => 'rzp_test_hXihND4vzfLzvi' , 
        'secret' => '8ju7KALuY65bn4g0Z8T7AL02',
    ];

    private $paypalKeys = [
        'key' => 'AdYAdQlvzPoekOGw0mK2jD_JH_j-20G7XcSgEwywb5JgF3ibgad8D575XxoS29lOZam3LtncUxG6YtXp' , 
        'secret' => 'EI1LjVX1dFCXOIbeO0-S3a1_iLs8I80k_Rvh7lBG0l0y3aEqUCHFNFHkP2SzpM3J3_ZyN8EpkxvGqY0K',
    ];


    private $razorpay;

    public function __construct(){
        $this->razorpay = new Api($this->razorpayKeys['key'], $this->razorpayKeys['secret']);
    }

    public function GenerateRazorpayOrderId(Request $request){
        $order  = $this->razorpay->order->create($request->only(['amount' , 'currency' , 'receipt' , 'payment_capture'])); // Creates order
        return response()->json($order);
    }
}
