@extends('core::layouts.themes.' . config('assets.metronic.theme_path') . '.app')

@section('page-title', 'User')

@section('breadcrumb')
    @include('core::common.breadcrumb')
@endsection

@section('content')
    {!! form_start($form, ['class'=>'form-horizontal form-bordered form-label-stripped', 'id' => 'kt_ecommerce_add_product_form']) !!}
    @include('core::users.form_body')
    {!! form_rest($form) !!}
    {!! form_end($form) !!}
@endsection
@push('scripts')
    <script src="{{ config('assets.metronic.assets_path', '') }}/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    <script src="{{ config('assets.metronic.assets_path', '') }}/js/custom/apps/ecommerce/catalog/save-product.js"></script>
@endpush
