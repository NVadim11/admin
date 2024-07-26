<a href="#"
   id="{{ $name }}-{{ $value . '-' . $model->id }}"
   data-name="{{ $name }}"
   data-type="select"
   data-pk="{{ $model->id }}"
   data-url="{{ action($controller.'@ajaxUpdate', ['id' => $model->id]) }}"
   data-title="{{ $field['name'] }}">{{ $field['choises'][$value] ?? '' }}
</a>
@push('scripts')
	<script>
		jQuery(document).ready(function() {
			$('#{{ $name }}-{{ $value . '-' . $model->id }}').editable({
				value: {{ $value }},
				source: [
					@foreach($field['choises'] as $val => $title)
						{value: '{{ $val }}', text: '{{ $title }}'},
					@endforeach
				]
			});
		});
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>
@endpush
@stack('scripts')
