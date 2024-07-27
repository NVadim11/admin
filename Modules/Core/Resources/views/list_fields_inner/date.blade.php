<span data-type="date" data-name="{{ $name }}" data-pk="{{ $item->id }}" data-url="{{ action($controller.'@ajaxUpdate', ['id' => $item->id]) }}" class="editable-date editable">{{ date('d.m.Y', $value) }}</span>
@push('scripts')
	<script>
		jQuery(document).ready(function() {
			$('.editable-date').editable({
				type: 'date',
				date: {
					language: 'ru',
					format: 'dd.mm.yyyy',
					viewformat: 'dd.mm.yyyy',
					weekStart: 1
				}
			});
		});
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>
@endpush