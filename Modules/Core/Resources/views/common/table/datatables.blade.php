<!--begin::Table-->
<table class="table align-middle table-row-dashed gy-0" id="kt_customers_table">
	<thead>
		<tr class="text-start text-gray-400 text-nowrap fw-bold fs-8 text-uppercase gs-0">
			<th class="w-10px pe-2 ps-5">
				<div class="form-check form-check-sm form-check-custom me-3 mt-7 mb-7">
					<input class="form-check-input rounded-0 w-15px h-15px" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_customers_table .form-check-input" value="0" />
				</div>
			</th>
			<th class="min-w-30px mw-sm-30px align-middle">{{__('ID')}}</th>
			@if($sortable)
				<th class="min-w-70px mw-sm-70px align-middle">{{ __('core::app.th_pos') }}</th>
			@endif
			@foreach($fields as $name => $field)
				<th class="min-w-125px align-middle">{{ $field['name'] }}</th>
			@endforeach
			<th class="text-end min-w-75px mw-sm-70px align-middle">{{ __('core::app.th_actions') }}</th>
		</tr>
	</thead>
</table>
<!--end::Table-->

@php
	$data = collect($fields)->keys()->toArray();

	$columns[] = array('data' => 'group', 'orderable' => false);
	$columns[] = array('data' => 'id');
	if($sortable){
		$columns[] = array('data' => 'pos');
	}
	foreach($data as $d){
		$columns[]['data'] = $d;
	}
	$columns[] = array('data' => 'action', 'orderable' => false);
@endphp

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

			// Private functions
			var initItemList = function () {
				// Set date data order
				const tableRows = table.querySelectorAll('tbody tr');

				tableRows.forEach(row => {
					const dateRow = row.querySelectorAll('td');
					const realDate = moment(dateRow[5].innerHTML, "DD MMM YYYY, LT").format(); // select date from 5th column in table
					dateRow[5].setAttribute('data-order', realDate);
				});

				// Init datatable --- more info on datatables: https://datatables.net/manual/
				datatable = $(table).DataTable({
					processing: true,
					serverSide: true,
					"sServerMethod": "POST",
					"language": { "url": "/admin_assets/js/datatables/{{ app()->getLocale() }}.js" },
					"order": [[{{ $sortValue ?? 1 }}, '{{ $sortOrder ?? "asc" }}']], // if sortable
					ajax: "{{ action($controller . '@dataTable') }}",
					stateSave: true,
					columns: {!! json_encode($columns) !!}
				});

				// Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
				datatable.on('draw', function () {
					initToggleToolbar();
					handleDeleteRows();
					toggleToolbars();
				});
			}

			// Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
			var handleSearchDatatable = () => {
				const filterSearch = document.querySelector('[data-kt-customer-table-filter="search"]');
				filterSearch.addEventListener('keyup', function (e) {
					datatable.search(e.target.value).draw();
				});
			}

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
										datatable.row($(d.closest('tbody tr'))).remove().draw();
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
										datatable.row($(c.closest('tbody tr'))).remove().draw();
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

					initItemList();
					initToggleToolbar();
					handleSearchDatatable();
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

	@if($sortable)
		<script src="/admin_assets/js/sort.js" type="text/javascript"></script>
	@endif
@endpush