@extends('layouts.app')

@section('content')


<br>

<h1 class="text-center">
    <a class="text-dark" href="{{route('user.edit' , ['id' => $user->id])}}">
        Edit The User
    </a>
</h1>

<br>
<h2 class="text-center">Order Information</h2>
<div class="row order_info">

    <ul class="list-unstyled col-md-6">
        <li>
            <div class="row">
                <div class="name col-md-4">Name :</div>
                <div class="value col-md-8">{{$user->name}}</div>
            </div>
        </li>

        <li>
            <div class="row">
                <div class="name col-md-4">Email :</div>
                <div class="value col-md-8">{{$user->email}}</div>
            </div>
        </li>

        <li>
            <div class="row">
                <div class="name col-md-4">Registeration Date :</div>
                <div class="value col-md-8">{{$user->created_at->format('Y-M-d h:i:s A')}}</div>
            </div>
        </li>

    </ul>

    <ul class="list-unstyled col-md-6">
        <li>
            <div class="row">
                <div class="name col-md-4">Admin :</div>
                <div class="value col-md-8">
                    @if($user->role > 1) No @endif
                    @if($user->role == 1) Yes @endif
                </div>
            </div>
        </li>

        <li>
            <div class="row">
                <div class="name col-md-4">Role :</div>
                <div class="value col-md-8">
                    @if($user->role == 1) Administerator @endif
                    @if($user->roleId == 2 || empty($user->roleId)) Member @endif
                </div>
            </div>
        </li>

        <li>
            <div class="row">
                <div class="name col-md-4">Email Verified :</div>
                <div class="value col-md-8">{{!empty($user->email_verified_at) ? $user->email_verified_at->format('Y-M-d h:i:s A') : 'No'}}</div>
            </div>
        </li>

        <li>
            <div class="row">
                <div class="name col-md-4">Last Update :</div>
                <div class="value col-md-8">{{$user->updated_at->format('Y-M-d h:i:s A')}}</div>
            </div>
        </li>
    </ul>

</div>


<div class="orders_page_edit">
    @if(Session::has('success'))
        <div class="alert alert-success">
            {{Session::get('success')}}
            {{Session::forget('success')}}
        </div>
    @endif

    @if(Session::has('error'))
        <div class="alert alert-danger">
            {{Session::get('error')}}
            {{Session::forget('error')}}
        </div>
    @endif

</div>


@endsection
