<span style="display: none;">{{ $value }}</span>
<a href="#"
   data-type="text"
   data-name="{{ $name }}"
   data-pk="{{ $model->id }}"
   data-url="{{ action($controller.'@ajaxUpdate', ['id' => $model->id]) }}"
   class="editable-name editable">{{ $value }}
</a>

<script>
	jQuery(document).ready(function() {
		$('.editable-name').editable();
	});
	$.ajaxSetup({
		headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}
	});
</script>
