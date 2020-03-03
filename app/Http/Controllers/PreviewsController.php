<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Previews;

// subscribes controller
use App\Http\Controllers\SubscribersController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\GiftEmail;
use App\Trees;
class PreviewsController extends Controller
{
    private $sandbox = 'sandbox.';


    /**
     * get previews
     */
    public function previews($limit){
        $normal = Previews::select('name' , 'gift' , 'amount' , 'websiteMessage' , 'anonymous' , 'id')->limit($limit)->orderBy('id' , 'DESC')->get();
        $top = Previews::select('name' , 'gift' , 'amount' , 'websiteMessage' , 'anonymous' , 'id')->limit($limit)->orderBy('amount' , 'DESC')->get();

        $data = [
            'normal' => $normal,
            'top'    => $top,
        ];
        return response()->json($data);
    }


    /**
     * store paypal payments
     */
    public function storePaypal(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255',
            'amount' => 'required|max:255|numeric',
            'price' => 'required|max:255|numeric',
            'name' => 'max:255',
            'phone' => 'max:255',
            'websiteMessage' => 'max:255',
            'subscribe' => 'max:255',
            'anonymous' => 'max:255',
            'gift' => 'max:255',
            'to' => 'max:255',
            'from' => 'max:255',
            'giftMessage' => 'max:255',
            'currency' => 'required|max:255',
            'icon' => 'max:255',
            'data' => 'required',
        ]);
        
        if ($validator->fails()){
            return response()->json($validator->errors() , 400);
        }


        $data = [];
        $data['price'] = $request->price;
        $data['amount'] = $request->amount;
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['websiteMessage'] = $request->websiteMessage;
        $data['subscribe'] = $request->subscribe;
        $data['anonymous'] = $request->anonymous;
        $data['gift'] = $request->gift;
        $data['to'] = $request->to;
        $data['from'] = $request->from;
        $data['giftMessage'] = $request->giftMessage;
        $data['currency'] = $request->currency;
        $data['icon'] = $request->icon;
        $data['orderID'] = $request->data['data']['orderID'];
        $data['payerID'] = $request->data['data']['payerID'];
        $data['facilitatorAccessToken'] = $request->data['data']['facilitatorAccessToken'];
        $data['paymentStatus'] = $request->data['details']['status'];
        $data['fullPayment'] = json_encode($request->data);
        $data['paymentMethod'] = 'paypal';

        $isExist = Previews::where('orderID' , '=' , $data['orderID'])->where('paymentMethod' , '=' , 'paypal')->count();

        /**
         * store user for subscribe system
         */
        if($data['subscribe']){
            $sub = new SubscribersController();
            $confirmSubscribe = $sub->subscribe($request);
        }


        if($isExist > 0){
            return response()->json(['error' => [
                'Payment Already Exist In Our Servers'
            ]] , 400);
        }

        $preview = Previews::create($data);

        /**
         * update the amount
         */
        $this->updateTreesAmount($preview);

        /**
         * send the gift if exist
         */
        if($data['gift']){
            $this->sendGift($data);
        }

        return response()->json($preview);
    }


    /**
     * store razorpay payments
     */
    public function storeRazorpay(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255',
            'amount' => 'required|max:255|numeric',
            'price' => 'required|max:255|numeric',
            'name' => 'max:255',
            'phone' => 'max:255',
            'websiteMessage' => 'max:255',
            'subscribe' => 'max:255',
            'anonymous' => 'max:255',
            'gift' => 'max:255',
            'to' => 'max:255',
            'from' => 'max:255',
            'giftMessage' => 'max:255',
            'currency' => 'required|max:255',
            'icon' => 'max:255',
            'paymentID' => 'required|max:255',
        ]);
        
        if ($validator->fails()){
            return response()->json($validator->errors() , 400);
        }

        $data = [];
        $data['price'] = $request->price;
        $data['amount'] = $request->amount;
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['websiteMessage'] = $request->websiteMessage;
        $data['subscribe'] = $request->subscribe;
        $data['anonymous'] = $request->anonymous;
        $data['gift'] = $request->gift;
        $data['to'] = $request->to;
        $data['from'] = $request->from;
        $data['giftMessage'] = $request->giftMessage;
        $data['currency'] = $request->currency;
        $data['icon'] = $request->icon;
        $data['orderID'] = $request->paymentID;
        $data['payerID'] = $request->paymentID;
        $data['facilitatorAccessToken'] = $request->paymentID;
        $data['paymentStatus'] = 'paid';
        $data['fullPayment'] = json_encode($request->paymentID);
        $data['paymentMethod'] = 'razorpay';

        $isExist = Previews::where('orderID' , '=' , $data['orderID'])->where('paymentMethod' , '=' , 'razorpay')->count();

        /**
         * store user for subscribe system
         */
        if($data['subscribe']){
            $sub = new SubscribersController();
            $confirmSubscribe = $sub->subscribe($request);
        }


        if($isExist > 0){
            return response()->json(['Payment Already Exist In Our Servers'] , 400);
        }

        $preview = Previews::create($data);

        /**
         * update the amount
         */
        $this->updateTreesAmount($preview);

        /**
         * send the gift if exist
         */
        if($data['gift']){
            $this->sendGift($data);
        }

        return response()->json($preview);
    }

    
    /**
     * send a gift payment
     */
    public function sendGift($data){
        $validator = Validator::make($data, [
            'to' => 'required|max:255',
            'from' => 'required|max:255',
        ]);
        
        if ($validator->fails()){
            return response()->json($validator->errors() , 400);
        }

        $emailData = [
            'from' => $data['from'],
            'giftMessage' => $data['giftMessage'],
        ];

        $configMail = [
            'address' => $data['to'],
            'name'  => 'A Gift For You From '.$data['from']
        ];

        Mail::send('email.giftTemplate', $emailData, function($message) use ($configMail) {
            $message->to($configMail['address'])->subject($configMail['name']);
        });
    }

    
    /**
     * save the last amount
     */
    public function updateTreesAmount($data){
        $lastAmount = Trees::orderBy('id' , 'DESC')->limit(1)->get();
        if(!$lastAmount->isEmpty()){
            $lastAmount = $lastAmount[0]->toArray();
        }else{
            $lastAmount = [
                'trees' => 0,
                'paid_usd' => 0,
                'paid_inr' => 0,
            ];
        }

        $newAmount = [];

        $paid = $data->price * $data->amount;

        if($data->currency == 'USD'){
            $newAmount['paid_usd'] = $lastAmount['paid_usd'] + $paid; 
            $newAmount['paid_inr'] = $lastAmount['paid_inr']; 
        }elseif($data->currency == 'INR'){
            $newAmount['paid_inr'] = $lastAmount['paid_inr'] + $paid; 
            $newAmount['paid_usd'] = $lastAmount['paid_usd']; 
        }

        $newAmount['trees'] = $lastAmount['trees'] + $data->amount;
        
        return Trees::create($newAmount);
    }


    /**
     * get amounts
     */
    public function treesAmount(){
        $lastAmount = Trees::orderBy('id' , 'DESC')->limit(1)->get();
        if(!$lastAmount->isEmpty()){
            return response()->json($lastAmount[0] , 200);
        }else{
            $lastAmount = [
                'trees' => 0,
                'paid_usd' => 0,
                'paid_inr' => 0,
            ];

            return response()->json($lastAmount , 200);
        }
    }

}
