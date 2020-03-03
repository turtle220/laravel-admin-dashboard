@extends('layouts.admin')

@section('content')
    <div class="container">
        <?php $currentRoute = Route::currentRouteName(); ?>

        <donates-dashboard
            :gw="{{isset($gw) ? $gw : []}}"
            :search="{{json_encode([
                "searchUrl" => route('donates') ,
                "searchPhrase" => $search
            ])}}"
            :urls="{{json_encode([
                'addUrl' => route('donate.store'),
                'exportUrl' => route('donates.export'),
                'importUrl' => route('donates.import'),
            ])}}"
            :pagination="{{json_encode([
                'total' => $total ,
                'perpage' => $perpage ,
                'offset'  => $offset,
                'url'    => route($currentRoute)
            ])}}"
        ></donates-dashboard>
    </div>

@endsection