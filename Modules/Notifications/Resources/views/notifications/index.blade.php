@extends('core::layouts.themes.' . config('assets.metronic.theme_path') . '.app')

@section('page-title', $title)

@section('actions')
	<a href="{{ action($controller.'@create') }}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"> {{ __('core::app.btn_create') }}</a>
@endsection

@section('content')
	<!--begin::Card-->
	<div class="card rounded-0 border-0">
		<!--begin::Card header-->
		<div class="card-header border-1 pt-0">
			<!--begin::Card title-->
			<div class="card-title">
				<!--begin::Search-->
				<div class="d-flex align-items-center position-relative my-1">
					<i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
					<form action="{{ action($controller.'@index') }}" method="get">
						<input type="text" name="search" value="{{ request()->get('search') ?? '' }}" data-kt-customer-table-filter="search" class="form-control ps-13 rounded-0 h-40px" placeholder="{{ __('core::app.placeholder_search') }}" />
					</form>
				</div>
				<!--end::Search-->
			</div>
			<!--begin::Card title-->
			<!--begin::Card toolbar-->
			<div class="card-toolbar">
				<!--begin::Toolbar-->
				<div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
					<!--begin::Add customer-->
					<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_customer">{{ __('core::app.btn_add') }}</button>
					<!--end::Add customer-->
				</div>
				<!--end::Toolbar-->
				<!--begin::Group actions-->
				<div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
					<div class="fw-bold me-5">
						<span class="me-2" data-kt-customer-table-select="selected_count"></span>{{ __('core::app.btn_selected') }}</div>
					<button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected">{{ __('core::app.btn_delete_selected') }}</button>
				</div>
				<!--end::Group actions-->
			</div>
			<!--end::Card toolbar-->
		</div>
		<!--end::Card header-->
		<!--begin::Card body-->
		<div class="card-body pt-0">
			@include('notifications::common.table.' . $outlist)
		</div>
		<!--end::Card body-->
	</div>
	<!--end::Card-->

	@include('core::common.modal.create')
@endsection