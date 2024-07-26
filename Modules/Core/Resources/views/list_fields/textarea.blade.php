<a href="#"
   data-type="textarea"
   data-name="{{ $name }}"
   data-pk="{{ $model->id }}"
   data-url="{{ action($controller.'@ajaxUpdate', ['id' => $model->id]) }}"
   class="editable-name editable">{{ $value }}
</a>
@push('scripts')
	<script>
		$(document).ready(function() {
			$('.editable-name').editable();
		});
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>
@endpush
@stack('scripts')