@extends('layouts.admin')

@section('content')
    <div class="container">
        <?php $currentRoute = Route::currentRouteName(); ?>

        <users-dashboard
            :gw="{{isset($gw) ? $gw : []}}"
            :search="{{json_encode([
                "searchUrl" => route('users') ,
                "searchPhrase" => $search
            ])}}"
            :urls="{{json_encode([
                'addUrl' => route('user.store')
            ])}}"
            :pagination="{{json_encode([
                'total' => $total ,
                'perpage' => $perpage ,
                'offset'  => $offset,
                'url'    => route($currentRoute)
            ])}}"
        ></users-dashboard>
    </div>

@endsection