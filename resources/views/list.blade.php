@extends('app')

@section('title', Lang::get('general.'.$title."S") . ' ')

@section('content')
@if($back)
    <a class="btn btn-link back-button" href="{{ url ('/'.$back) }}"><span class="glyphicon glyphicon-chevron-left"></span>{{ Lang::get('general.BACK') }}</a>
@endif
<div class="panel panel-default">
    <div class="panel-heading">
        <b class="panel-title">{{ Lang::get('general.'.$title."S") }}</b>
    </div>
    
    @if($additional_info)
        <div class="add-info clearfix">
            <div class="pull-left">{{ $additional_info }}</div>
        </div>
    @endif
    @if($filter || $add)
        <div class="add-info clearfix form-inline">
            @if($filter)
                <div class="pull-left">
                {!! form_start($filter) !!}
                    {!! form_rest($filter) !!}
                    <input class="btn btn-success" name="search" type="submit" value="{{ Lang::get('general.SEARCH') }}">
                    <input class="btn btn-link" name="reset" type="submit" value="{{ Lang::get('general.RESET') }}">
                {!! form_end($filter) !!}
                </div>
            @endif
            @if($add)
                @if(session('myPermissions')[$perm_path]['write'] == 1)
                    <div class="pull-right">
                        <a href="{{ url("/$path/create") }}" title="{{ Lang::get('general.ADD', ['attribute' => Session::get('attribute')]) }}"><span class="btn btn-sm btn-success glyphicon glyphicon-plus"></span></a>
                    </div>
                @endif
            @endif
        </div>
    @endif
    @if(isset($pagination))
        <div class="list-pagination">
            {!! $pagination !!}
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-hover table-condensed">
            <tr>
                @foreach($keys as $key)
                <th class="text-capitalize">{{ str_replace('_', ' ',$key) }}</th>
                @endforeach
                @if(session('myPermissions')[$perm_path]['write'] == 1)
                    @if(!isset($edit) || (isset($edit) && $edit))
                        <th>Edit</th>
                    @endif
                    @if(!isset($delete) || (isset($delete) && $delete))
                        <th>Delete</th>
                    @endif
                @endif
            </tr>
            @foreach($data_arr as $key => $data)
            <tr>
                @foreach($data as $value)
                <td>{!! $value !!}</td>
                @endforeach
                @if(session('myPermissions')[$perm_path]['write'] == 1)
                    @if(!isset($edit) || (isset($edit) && $edit))
                    <td><a href="{{ url("/$path/$key/edit") }}" title="{{ Lang::get('general.EDIT', ['attribute' => Session::get('attribute')]) }}"><span class="btn btn-xs btn-success glyphicon glyphicon-edit"></span></a></td>
                    @endif
                    @if(!isset($delete) || (isset($delete) && $delete))
                    <td>
                        @if($parent_table_id)
                        {!! Form::open(['method' => 'DELETE', 'action' => [$controller.'@destroy', $parent_table_id, $key], 'onsubmit' => 'return confirm("Are you sure?")']) !!}
                        @else
                        {!! Form::open(['method' => 'DELETE', 'action' => [$controller.'@destroy', $key], 'onsubmit' => 'return confirm("Are you sure?")']) !!}
                        @endif
                            {!! Form::button('', array('type' => 'submit', 'class' => 'btn btn-xs btn-danger glyphicon glyphicon-remove', 'title' => Lang::get('general.DELETE', ['attribute' => Session::get('attribute')]) )) !!}
                        {!! Form::close() !!}
                    </td>
                    @endif
                @endif
            </tr>
            @endforeach
        </table>
    </div>
</div>
@stop