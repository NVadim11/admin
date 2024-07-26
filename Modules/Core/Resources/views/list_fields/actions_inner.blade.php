<a class="btn btn-sm btn-icon btn-primary mt-3 mb-3" href="{{ action($controller.'@edit', ['hotels_rooms_image' => $model->id, 'event' => $model->hotel_room->hotel->id, 'room' => $model->hotel_room->id]) }}" title="{{__('Редактировать')}}"><i class="ki-outline ki-pencil fs-5 m-0"></i></a>
<form id="del-form-{{ $model->id }}" action="{{ action($controller.'@destroy', ['hotels_rooms_image' => $model->id, 'event' => $model->hotel_room->hotel->id, 'item' => $model->hotel_room->id]) }}" method="POST" style="display: none;">
	{{ csrf_field() }}
	{{ method_field('DELETE') }}
</form>
<a href="javascript:del('del-form-{{ $model->id }}')" title="{{__('Удалить')}}" class="btn btn-sm btn-icon btn-danger mt-3 mb-3"><i class="ki-outline ki-trash fs-5 m-0"></i></a>