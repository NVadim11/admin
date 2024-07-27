@extends('core::layouts.themes.' . config('assets.metronic.theme_path') . '.app')

@section('page-title', 'Users')

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
					<input type="text" data-kt-customer-table-filter="search" class="form-control w-250px ps-13 rounded-0 h-40px" placeholder="Search" />
				</div>
				<!--end::Search-->
			</div>
			<!--begin::Card title-->
			<!--begin::Card toolbar-->
			<div class="card-toolbar">
				<!--begin::Toolbar-->
				<div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
					<!--begin::Add customer-->
					{{--					<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_customer">Add item</button>--}}
					<!--end::Add customer-->
				</div>
				<!--end::Toolbar-->
				<!--begin::Group actions-->
				<div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
					<div class="fw-bold me-5">
						<span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected</div>
					<button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected">Delete Selected</button>
				</div>
				<!--end::Group actions-->
			</div>
			<!--end::Card toolbar-->
		</div>
		<!--end::Card header-->
		<!--begin::Card body-->
		<div class="card-body pt-0">
			<table class="table align-middle table-row-dashed gy-0" id="kt_customers_table">
				<thead>
				<tr role="row" class="heading text-start text-gray-400 text-nowrap fw-bold fs-8 text-uppercase gs-0">
					<th width="1%">
						<div class="form-check form-check-sm form-check-custom me-3 mt-7 mb-7">
							<input class="form-check-input rounded-0 w-15px h-15px" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_customers_table .form-check-input" value="0" />
						</div>
					</th>
					<th width="1%" class="min-w-30px mw-sm-30px align-middle">
						ID
					</th>

					<th width="10%" class="min-w-30px mw-sm-30px align-middle">Name</th>
					<th width="10%" class="min-w-30px mw-sm-30px align-middle">Login</th>
					<th class="min-w-30px mw-sm-30px align-middle">E-mail</th>
					<th width="1%" class="min-w-75px align-middle">
						{{__('Actions')}}
					</th>
				</tr>
				</thead>
				<tbody>
				@foreach($users as $user)
					<tr align="center" class="odd">
						<td>
							<div class="form-check form-check-sm form-check-custom">
								<input class="form-check-input rounded-0 w-15px h-15px" type="checkbox" value="{{ $user->id }}" name="id[]">
							</div>
						</td>
						<td style="font-size:11px;color:#999;">{{ $user->id }}</td>
						<td align="left">
							{{ $user->name }}
						</td>
						<td align="left">
							{{ $user->login }}
						</td>
						<td align="left">
							{{ $user->email }}
						</td>
						<td nowrap="nowrap">
							<a class="btn btn-sm btn-icon btn-primary mt-3 mb-3" href="{{ action($controller.'@edit', $user->id) }}" title="{{__('Редактировать')}}"><i class="ki-outline ki-pencil fs-5 m-0"></i></a>
							<form id="del-form-{{ $user->id }}" action="{{ action($controller.'@destroy', $user->id) }}" method="POST" style="display: none;">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}
							</form>
							<a href="javascript:del('del-form-{{ $user->id }}')" title="{{__('Удалить')}}" class="btn btn-sm btn-icon btn-light btn-danger mt-3 mb-3"><i class="ki-outline ki-trash fs-5 m-0"></i></a>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>

			@push('scripts')
				<script>
					$.ajaxSetup({
						headers: {
							'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
						}
					});

					"use strict";

					// Class definition
					var KTItemsList = function () {
						// Define shared variables
						var datatable;
						var filterMonth;
						var filterPayment;
						var table

						// Delete customer
						var handleDeleteRows = () => {
							// Select all delete buttons
							const deleteButtons = table.querySelectorAll('[data-kt-customer-table-filter="delete_row"]');

							deleteButtons.forEach(d => {
								// Delete button on click
								d.addEventListener('click', function (e) {
									e.preventDefault();

									// Select parent row
									const parent = e.target.closest('tr');

									// Get customer name
									const customerName = parent.querySelectorAll('td')[1].innerText;

									// SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
									Swal.fire({
										text: "Are you sure you want to delete " + customerName + "?",
										icon: "warning",
										showCancelButton: true,
										buttonsStyling: false,
										confirmButtonText: "Yes, delete!",
										cancelButtonText: "No, cancel",
										customClass: {
											confirmButton: "btn fw-bold btn-danger",
											cancelButton: "btn fw-bold btn-active-light-primary"
										}
									}).then(function (result) {
										if (result.value) {
											Swal.fire({
												text: "You have deleted " + customerName + "!.",
												icon: "success",
												buttonsStyling: false,
												confirmButtonText: "Ok, got it!",
												customClass: {
													confirmButton: "btn fw-bold btn-primary",
												}
											}).then(function () {
												// Remove current row
												datatable.row($(parent)).remove().draw();
											});
										} else if (result.dismiss === 'cancel') {
											Swal.fire({
												text: customerName + " was not deleted.",
												icon: "error",
												buttonsStyling: false,
												confirmButtonText: "Ok, got it!",
												customClass: {
													confirmButton: "btn fw-bold btn-primary",
												}
											});
										}
									});
								})
							});
						}

						// Handle status filter dropdown
						var handleStatusFilter = () => {
							const filterStatus = document.querySelector('[data-kt-ecommerce-order-filter="status"]');
							$(filterStatus).on('change', e => {
								let value = e.target.value;
								if (value === 'all') {
									value = '';
								}
								datatable.column(3).search(value).draw();
							});
						}

						// Init toggle toolbar
						var initToggleToolbar = () => {
							// Toggle selected action toolbar
							// Select all checkboxes
							const checkboxes = table.querySelectorAll('[type="checkbox"]');

							// Select elements
							const deleteSelected = document.querySelector('[data-kt-customer-table-select="delete_selected"]');

							// Toggle delete selected toolbar
							checkboxes.forEach(c => {
								// Checkbox on click event
								c.addEventListener('click', function () {
									setTimeout(function () {
										toggleToolbars();
									}, 50);
								});
							});

							// Deleted selected rows
							deleteSelected.addEventListener('click', function () {
								// SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
								Swal.fire({
									text: "Are you sure you want to delete selected customers?",
									icon: "warning",
									showCancelButton: true,
									buttonsStyling: false,
									confirmButtonText: "Yes, delete!",
									cancelButtonText: "No, cancel",
									customClass: {
										confirmButton: "btn fw-bold btn-danger",
										cancelButton: "btn fw-bold btn-active-light-primary"
									}
								}).then(function (result) {
									if (result.value) {

										// Remove all selected customers
										var items = [];
										checkboxes.forEach(c => {
											if (c.checked) {
												items.push(c.value);
											}
										});

										{{--$.ajax({--}}
										{{--	method: 'post',--}}
										{{--	url: "{{ action($controller . '@actionWithGroup') }}",--}}
										{{--	dataType: 'json',--}}
										{{--	data: {--}}
										{{--		_token: $('meta[name="csrf-token"]').attr('content'),--}}
										{{--		action: "delete",--}}
										{{--		items: items--}}
										{{--	}--}}
										{{--});--}}

										Swal.fire({
											text: "You have deleted all selected!.",
											icon: "success",
											buttonsStyling: false,
											confirmButtonText: "Ok, got it!",
											customClass: {
												confirmButton: "btn fw-bold btn-primary",
											}
										}).then(function () {
											checkboxes.forEach(c => {
												if (c.checked) {
													datatable.row($(c.closest('tbody tr'))).remove().draw();
												}
											});

											// Remove header checked box
											const headerCheckbox = table.querySelectorAll('[type="checkbox"]')[0];
											headerCheckbox.checked = false;
										});
									} else if (result.dismiss === 'cancel') {
										Swal.fire({
											text: "Selected customers was not deleted.",
											icon: "error",
											buttonsStyling: false,
											confirmButtonText: "Ok, got it!",
											customClass: {
												confirmButton: "btn fw-bold btn-primary",
											}
										});
									}
								});
							});
						}

						// Toggle toolbars
						const toggleToolbars = () => {
							// Define variables
							const toolbarBase = document.querySelector('[data-kt-customer-table-toolbar="base"]');
							const toolbarSelected = document.querySelector('[data-kt-customer-table-toolbar="selected"]');
							const selectedCount = document.querySelector('[data-kt-customer-table-select="selected_count"]');

							// Select refreshed checkbox DOM elements
							const allCheckboxes = table.querySelectorAll('tbody [type="checkbox"]');

							// Detect checkboxes state & count
							let checkedState = false;
							let count = 0;

							// Count checked boxes
							allCheckboxes.forEach(c => {
								if (c.checked) {
									checkedState = true;
									count++;
								}
							});

							// Toggle toolbars
							if (checkedState) {
								selectedCount.innerHTML = count;
								toolbarBase.classList.add('d-none');
								toolbarSelected.classList.remove('d-none');
							} else {
								toolbarBase.classList.remove('d-none');
								toolbarSelected.classList.add('d-none');
							}
						}

						// Public methods
						return {
							init: function () {
								table = document.querySelector('#kt_customers_table');

								if (!table) {
									return;
								}

								initToggleToolbar();
								handleDeleteRows();
								handleStatusFilter();
							}
						}
					}();

					// On document ready
					KTUtil.onDOMContentLoaded(function () {
						KTItemsList.init();
					});
				</script>
			@endpush
		</div>
		<!--end::Card body-->
	</div>
	<!--end::Card-->
@endsection
