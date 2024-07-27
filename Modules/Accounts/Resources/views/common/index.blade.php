@extends('core::layouts.app')

@section('page-title', $title)

@section('breadcrumb')
    {{--@include('sanatoriums::particles.breadcrumb-parent')--}}
@endsection

@section('content')
    <div class="portlet light">
        <div class="portlet-title">
            <div class="actions btn-set">
                <a href="{{ action($controller.'@create', ['club_event' => $clubEvent->id]) }}" class="btn btn-default"> Create</a>
                <a href="{{ route('club-events.edit', $clubEvent->id) }}" class="btn btn-default"> К санаторию</a>
            </div>

            <div class="table-group-actions">
                <form action="#" name="page-filter" method="get" accept-charset="utf-8">
		            <select name="size" class="bs-select form-control input-small" onchange="$(this).parents('form').submit()" >
			            <option value="">{{__('View')}}...</option>
			            <option value="25" <?= (isset($_GET['size']) && $_GET['size'] == '25') ? 'selected' : '' ?> >25</option>
	                    <option value="50" <?= isset($_GET['size']) && $_GET['size'] == '50' ? 'selected' : '' ?> >50</option>
	                    <option value="100" <?= isset($_GET['size']) && $_GET['size'] == '100' ? 'selected' : '' ?> >100</option>
	                    <option value="200" <?= isset($_GET['size']) && $_GET['size'] == '200' ? 'selected' : '' ?> >200</option>
	                </select>
	                &nbsp;&nbsp;
	                <select class="bs-select form-control input-medium " >
	                    <option value="">{{__('With selected')}}...</option>
	                    <option value="delete">{{__('Remove')}}</option>
	                </select>
	                <button class="btn yellow table-group-action-submit" id="deleteListItems" data-mod="#module"><i class="fa fa-check"></i> Run</button>
	             </form>
            </div>
        </div>

        <div class="portlet-body">
            <div class="table-container">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover" >
                        <thead>
                        <tr role="row" class="heading">
                            <th width="1%">
                                <input type="checkbox" class="group-checkable" />
                            </th>
                            <th width="1%">
                                ID
                            </th>

                            @if($sortable)
                            <th width="3%">{{__('Pos')}}.</th>
                            @endif

                            @foreach($fields as $name=>$field)
                                <th>{{ $field['name'] }}</th>
                            @endforeach

                            <th width="1%">
                                {{__('Actions')}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                            @foreach($items as $item)
                                <tr align="center" class="odd">
                                    <td><input type="checkbox" value="{{ $item->id }}" name="id[]"></td>
                                    <td style="font-size:11px;color:#999;">{{ $item->id }}</td>

                                    @if($sortable)
                                    <td class="item" id="{{ $item->pos }}" style="font-size:11px;color:#999;">
                                        <input class="inp" id="{{ $item->id }}" style="width:40px; display:none; font-size:11px; text-align:center;" type="text" value="{{ $item->pos }}" rel="{{ $item->getTable() }}" cat="" cat_val="" />
                                        <span style="display:block; width:40px;">{{ $item->pos }}</span></td>
                                    @endif

                                    @foreach($fields as $name=>$field)
                                        <td align="left">
                                            @isset($field['route'])
                                                <a href="{{ route($field['route'], $item->id) }}">
                                            @endisset
                                                {{ $item->$name }}
                                            @isset($field['route'])
                                                </a>
                                            @endisset
                                        </td>
                                    @endforeach

                                    <td nowrap="nowrap">
                                        <a class="btn btn-icon-only blue" href="{{ action($controller.'@edit', ['id' => $item->id, 'club_event' => $clubEvent->id]) }}" title="{{__('Edit')}}"><i class="fa fa-pencil"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                {{ $items->links() }}
            </div>
        </div>


    </div>

@endsection

@push('scripts')
    @if($sortable)
        <script src="/admin/js/sort.js" type="text/javascript"></script>
    @endif
@endpush