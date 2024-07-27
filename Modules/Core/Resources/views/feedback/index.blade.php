@extends('core::layouts.app')

@section('page-title', $title)

@section('content')
    <div class="portlet light">
        <div class="portlet-title">

            <div class="actions btn-set">
            </div>

            <div class="table-group-actions">
                <form action="#" name="page-filter" method="get" accept-charset="utf-8">	
		            <select name="size" class="bs-select form-control input-small" onchange="$(this).parents('form').submit()" >
			            <option value="">{{__('Отображать')}}...</option>
			            <option value="25" <?= (isset($_GET['size']) && $_GET['size'] == '25') ? 'selected' : '' ?> >25</option>
	                    <option value="50" <?= isset($_GET['size']) && $_GET['size'] == '50' ? 'selected' : '' ?> >50</option>
	                    <option value="100" <?= isset($_GET['size']) && $_GET['size'] == '100' ? 'selected' : '' ?> >100</option>
	                    <option value="200" <?= isset($_GET['size']) && $_GET['size'] == '200' ? 'selected' : '' ?> >200</option>
	                </select>
	                &nbsp;&nbsp;    
	                <select class="bs-select form-control input-medium " >
	                    <option value="">{{__('С отмеченными')}}...</option>
	                    <option value="delete">{{__('Удалить')}}</option>
	                </select>
	                <button class="btn yellow table-group-action-submit" id="deleteListItems" data-mod="#module"><i class="fa fa-check"></i> Выполнить</button>
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

                            @foreach($fields as $name=>$field)
                                <th>{{ $field['title'] }}</th>
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
                                        <a class="btn btn-icon-only blue" href="{{ action($controller.'@edit', $item->id) }}" title="{{__('Редактировать')}}"><i class="fa fa-pencil"></i></a>
                                        <form id="del-form-{{ $item->id }}" action="{{ action($controller.'@destroy', $item->id) }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                        <a href="javascript:del('del-form-{{ $item->id }}')" title="{{__('Удалить')}}" class="btn btn-icon-only red"><i class="fa fa-trash-o"></i></a>
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
