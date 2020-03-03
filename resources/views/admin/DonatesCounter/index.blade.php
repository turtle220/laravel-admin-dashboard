@extends('layouts.admin')

@section('content')
    <div class="container">
        <?php $currentRoute = Route::currentRouteName(); ?>

        <donatescounter-dashboard
            :gw="{{isset($gw) ? $gw : []}}"
            :search="{{json_encode([
                "searchUrl" => route('DonatesCounter') ,
                "searchPhrase" => $search
            ])}}"
            :urls="{{json_encode([
                'addUrl' => route('DonateCounter.store'),
                'exportUrl' => route('DonatesCounter.export'),
                'importUrl' => route('DonatesCounter.import'),
            ])}}"
            :pagination="{{json_encode([
                'total' => $total ,
                'perpage' => $perpage ,
                'offset'  => $offset,
                'url'    => route($currentRoute)
            ])}}"
        ></donatescounter-dashboard>
    </div>

@endsection