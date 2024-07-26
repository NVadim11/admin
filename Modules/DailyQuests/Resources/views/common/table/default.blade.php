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

		@if($sortable)
			<th width="3%" class="min-w-70px mw-sm-70px align-middle">{{__('Pos')}}.</th>
		@endif

		@foreach($fields as $name => $field)
			<th class="min-w-125px align-middle">{{ $field['name'] }}</th>
		@endforeach

		<th width="1%" class="min-w-75px align-middle">
			{{__('Actions')}}
		</th>
	</tr>
	</thead>
	<tbody>
	@foreach($items as $item)
		<tr align="center" class="odd">
			<td>
				<div class="form-check form-check-sm form-check-custom">
					<input class="form-check-input rounded-0 w-15px h-15px" type="checkbox" value="{{ $item->id }}" name="id[]">
				</div>
			</td>
			<td style="font-size:11px;color:#999;">{{ $item->id }}</td>

			@if($sortable)
				<td class="item" id="{{ $item->pos }}" style="font-size:11px;color:#999;">
					<input class="inp" id="{{ $item->id }}" style="width:40px; display:none; font-size:11px; text-align:center;" type="text" value="{{ $item->pos }}" rel="{{ $item->getTable() }}" cat="" cat_val="" />
					<span style="display:block; width:40px;">{{ $item->pos }}</span></td>
			@endif

			@foreach($fields as $name => $field)
				@php
					$model = $item;
					$value = $item->$name;
				@endphp
				<td align="left">
					@include('core::list_fields.'.$field['type'])
				</td>
			@endforeach

			<td nowrap="nowrap">
				<a class="btn btn-sm btn-icon btn-primary mt-3 mb-3" href="{{ action($controller.'@edit', $item->id) }}" title="{{__('Редактировать')}}"><i class="ki-outline ki-pencil fs-5 m-0"></i></a>
				<a href="#" title="{{ __('core::users.title_delete') }}" class="btn btn-sm btn-icon btn-danger mt-3 mb-3" data-kt-customer-table-filter="delete_row" data-item-id="{{ $item->id }}"><i class="ki-outline ki-trash fs-5 m-0"></i></a>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>
{{ $items->links() }}

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
						var item = [];
						item.push(d.getAttribute('data-item-id'));

						// SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
						Swal.fire({
							text: "{{ __('core::app.message_delete_item') }}",
							icon: "warning",
							showCancelButton: true,
							buttonsStyling: false,
							confirmButtonText: "{{ __('core::app.message_yes') }}",
							cancelButtonText: "{{ __('core::app.message_no') }}",
							customClass: {
								confirmButton: "btn fw-bold btn-danger",
								cancelButton: "btn fw-bold btn-active-light-primary"
							}
						}).then(function (result) {
							if (result.value) {
								Swal.fire({
									text: "{{ __('core::app.message_deleted') }}",
									icon: "success",
									buttonsStyling: false,
									confirmButtonText: "{{ __('core::app.message_got_it') }}",
									customClass: {
										confirmButton: "btn fw-bold btn-primary",
									}
								}).then(function () {
									$.ajax({
										method: 'post',
										url: "{{ action($controller . '@actionWithGroup') }}",
										dataType: 'json',
										data: {
											_token: $('meta[name="csrf-token"]').attr('content'),
											action: "delete",
											items: item
										}
									});
									setTimeout(function(){
										// datatable.row($(d.closest('tbody tr'))).remove().draw();
										location.reload();
									}, 500);
								});
							} else if (result.dismiss === 'cancel') {
								Swal.fire({
									text: "{{ __('core::app.message_not_deleted') }}",
									icon: "error",
									buttonsStyling: false,
									confirmButtonText: "{{ __('core::app.message_got_it') }}",
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
				// Deleted selected rows
				deleteSelected.addEventListener('click', function () {
					// SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
					Swal.fire({
						text: "{{ __('core::app.message_delete_selected') }}",
						icon: "warning",
						showCancelButton: true,
						buttonsStyling: false,
						confirmButtonText: "{{ __('core::app.message_yes') }}",
						cancelButtonText: "{{ __('core::app.message_no') }}",
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

							$.ajax({
								method: 'post',
								url: "{{ action($controller . '@actionWithGroup') }}",
								dataType: 'json',
								data: {
									_token: $('meta[name="csrf-token"]').attr('content'),
									action: "delete",
									items: items
								}
							});

							Swal.fire({
								text: "{{ __('core::app.message_deleted_selected') }}",
								icon: "success",
								buttonsStyling: false,
								confirmButtonText: "{{ __('core::app.message_got_it') }}",
								customClass: {
									confirmButton: "btn fw-bold btn-primary",
								}
							}).then(function () {
								checkboxes.forEach(c => {
									if (c.checked) {
										location.reload();
									}
								});

								// Remove header checked box
								const headerCheckbox = table.querySelectorAll('[type="checkbox"]')[0];
								headerCheckbox.checked = false;
							});
						} else if (result.dismiss === 'cancel') {
							Swal.fire({
								text: "{{ __('core::app.message_not_deleted_selected') }}",
								icon: "error",
								buttonsStyling: false,
								confirmButtonText: "{{ __('core::app.message_got_it') }}",
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