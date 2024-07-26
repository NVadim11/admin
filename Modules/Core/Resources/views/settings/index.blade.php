@extends('core::layouts.themes.' . config('assets.metronic.theme_path') . '.app')
@section('page-title', 'Settings')

@section('content')
    <div class="card rounded-0 border-0">
        <div class="card-body pt-0">
            {!! form_start($form, ['class'=>'form-horizontal form-bordered form-label-stripped']) !!}
            @include('core::settings.form_body')
            {!! form_end($form); !!}
        </div>
    </div>
@endsection