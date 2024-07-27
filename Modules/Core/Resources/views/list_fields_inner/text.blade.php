<a href="#"
   data-type="text"
   data-name="{{ $name }}"
   data-pk="{{ $model->id }}"
   data-url="{{ action($controller.'@ajaxUpdate', ['id' => $model->id, 'event' => $progress->project->id, 'item' => $progress->id]) }}"
   class="editable-name editable">{{ htmlentities($value) }}
</a>

<script>
	jQuery(document).ready(function() {
		$('.editable-name').editable();
	});
	$.ajaxSetup({
		headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}
	});
</script>
