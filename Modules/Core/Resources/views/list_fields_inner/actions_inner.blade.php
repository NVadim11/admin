<a class="btn btn-icon-only blue" href="{{ action($controller.'@edit', ['id' => $model->id, 'event' => $progress->project->id, 'item' => $progress->id]) }}" title="{{__('Редактировать')}}"><i class="fa fa-pencil"></i></a>
<form id="del-form-{{ $model->id }}" action="{{ action($controller.'@destroy', ['id' => $model->id, 'event' => $progress->project->id, 'item' => $progress->id]) }}" method="POST" style="display: none;">
	{{ csrf_field() }}
	{{ method_field('DELETE') }}
</form>
<a href="javascript:del('del-form-{{ $model->id }}')" title="{{__('Удалить')}}" class="btn btn-icon-only red"><i class="fa fa-trash-o"></i></a>