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
                'addUrl' => route('user.store'),
                'exportUrl' => route('users.export'),
                'importUrl' => route('users.import'),
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