@extends('core::layouts.themes.' . config('assets.metronic.theme_path') . '.app')

@section('content')
    {{--<div class="container">--}}
    {{--    <div class="row">--}}
    {{--        <div class="col-md-offset-2">--}}
    {{--            <div class="panel panel-default">--}}
    {{--                <div class="panel-heading">Control panel</div>--}}
    {{--                <div class="panel-body">--}}
    {{--                    You are logged in as {{ auth()->user()->name }}--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--</div>--}}

    @include('core::charts')
    <div class="card rounded-0 border-0">
        <div class="card-body pt-0">
            {!! form_start($form, ['class'=>'form-horizontal form-bordered form-label-stripped']) !!}
            @include('core::form_body')
            {!! form_end($form); !!}
        </div>
    </div>
@endsection