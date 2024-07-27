<input class="inp" id="{{ $model->id }}" style="width:40px; display:none; font-size:11px; text-align:center;" type="text" value="{{ $model->pos }}" rel="{{ $table }}" cat="" cat_val="" />
<a href="#"
   data-type="text"
   data-name="{{ $name }}"
   data-pk="{{ $model->id }}"
   data-url="{{ action($controller.'@ajaxUpdate', ['id' => $model->id]) }}"
   class="editable-name editable">{{ htmlentities($value) }}
</a>
<script>
	jQuery(document).ready(function() {
		$('.editable-name').editable();
		$('table.table tbody').addClass("ui-sortable");
		$('table.table').find("tr").addClass("ui-sortable-handle");
	});
	$.ajaxSetup({
		headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}
	});
</script>
