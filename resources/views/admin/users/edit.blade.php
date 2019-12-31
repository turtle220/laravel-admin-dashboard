@extends('layouts.app')

@section('content')


<br><br>

<h1 class="text-center">
    Edit User
</h1>

<br>
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
@if (count($errors) > 0)

<div class="alert alert-danger">
    <ul class="list-unstyled">
        @foreach ($errors->all() as $error)
        <li class="alert alert-danger">{{ $error }}</li>
        @endforeach
    </ul>
</div>



@endif
<a href="{{route('user.delete' , ['id' => $user->id])}}" class="btn btn-danger">Delete User</a>
<br><br>
<form method="POST" action="{{route('user.update' , ['id' => $user->id])}}">
    @csrf

    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

        <div class="col-md-6">
            <input id="name" type="text" value="{{$user->name}}" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

        <div class="col-md-6">
            <input id="email" type="email" value="{{$user->email}}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }} (leave empty to not update)</label>

        <div class="col-md-6">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="admin" class="col-md-4 col-form-label text-md-right">Choose If Admin</label>
        <div class="col-md-6">
            <select name="role" id="admin" class='form-control'>
                <option value="0" @if($user->role > 1) selected @endif>User</option>
                <option value="1" @if($user->role == 1) selected @endif>Admin</option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="role" class="col-md-4 col-form-label text-md-right">Choose User Role</label>
        <div class="col-md-6">
            <select name="roleId" id="role" class='form-control'>
                <option value="2" @if(!$user->roleId == 2) selected @endif>Members</option>
                <option value="1" @if(!$user->roleId == 1) selected @endif>Administrator</option>
            </select>
        </div>

    </div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                Edit
            </button>
        </div>
    </div>

</form>


@endsection
