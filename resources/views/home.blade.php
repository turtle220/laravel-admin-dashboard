@extends('layouts.admin')

@section('content')

    <home-dashboard 
        :user="{{auth()->user()}}" 
        :gw="{{isset($gw) ? $gw : json_encode([])}}"
    ></home-dashboard>

@endsection
