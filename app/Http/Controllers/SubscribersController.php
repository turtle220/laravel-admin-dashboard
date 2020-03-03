<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscribe;
use Illuminate\Support\Facades\Validator;

class SubscribersController extends Controller
{
    /**
     * add user for subscribe system
     */
    public function subscribe(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:subscribers|max:255',
            'firstName' => 'required|max:255',
            'lastName' => 'max:255',
            'phone' => 'max:255',
            'zipCode' => 'max:255',
            'countryName' => 'max:255',
            'countryCode' => 'max:255',
            'subscribeType' => 'max:255',
        ]);
        
        if ($validator->fails()){
            return response()->json($validator->errors() , 400);
        }

        $data = [];
        $data['firstName'] = !empty($request->name) ? $request->name : $request->firstName;
        $data['lastName'] = !empty($request->name) ? $request->name : $request->lastName;
        $data['email'] = $request->email;
        $data['phoneNumber'] = $request->phone;
        $data['zipCode'] = $request->zipCode;
        $data['countryName'] = $request->countryName;
        $data['countryCode'] = $request->countryCode;
        if(!empty($request->subscribeType)){
            $data['subscribeType'] = $request->subscribeType;
        }

        $created = Subscribe::create($data);

        return response()->json($created , 200);
    }
}
