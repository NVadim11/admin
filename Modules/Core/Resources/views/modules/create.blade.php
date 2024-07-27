@extends('core::layouts.themes.' . config('assets.metronic.theme_path') . '.app')

@section('page-title', 'Создание модуля')

@section('content')
    @section('actions')
        <a href="{{ route('modules.index') }}" class="btn btn-flex btn-outline btn-color-gray-700 btn-active-color-primary bg-body h-40px fs-7 fw-bold">{{ __('core::app.btn_to_list') }}</a>
        <a href="{{ route('modules.create') }}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold">{{ __('core::app.btn_create') }}</a>
    @endsection

    {!! form_start($form, ['class'=>'form-horizontal form-bordered form-label-stripped', 'id' => 'kt_ecommerce_add_product_form']) !!}
    @include('core::modules.form_body')
    {!! form_end($form) !!}
@endsection
@push('scripts')
    <script src="{{ config('assets.metronic.assets_path', '') }}/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    <script src="{{ config('assets.base.scripts', '') }}/form/save.js"></script>
@endpush