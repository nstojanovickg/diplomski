@extends('app')

@section('title', Lang::get('general.'.$title) . ' ')

@section('content')
@if($back)
    <a class="btn btn-link back-button" href="{{ url ('/'.$back) }}"><span class="glyphicon glyphicon-chevron-left"></span>{{ Lang::get('general.BACK') }}</a>
@endif
<div class="panel panel-default">
    <div class="panel-heading">
        <b class="panel-title">{{ Lang::get('general.'.$title) }}</b>
    </div>
    
    @if($additional_info)
        <div class="add-info clearfix">
            <div class="pull-left">{{ $additional_info }}</div>
        </div>
    @endif
    @if($filter)
        <div class="add-info form-filter clearfix">
            {!! form_start($filter) !!}
                {!! form_rest($filter) !!}
                <div class="form-group">
                    <input class="btn btn-success" name="search" type="submit" value="{{ Lang::get('general.SEARCH') }}">
                    <input class="btn btn-link" name="reset" type="submit" value="{{ Lang::get('general.RESET') }}">
                </div>
            {!! form_end($filter) !!}
        </div>
    @endif
    <div class="clearfix" style="padding: 0 5px 5px 5px;">
        @if(isset($pagination))
            <div class="list-pagination pull-left">
                {!! $pagination !!}
            </div>
        @endif
        @if($add)
            @if(session('myPermissions')[$perm_path]['write'] == 1)
                <div class="pull-right">
                    <a href="{{ url("/$path/create") }}" title="{{ Lang::get('general.ADD_OBJ', ['attribute' => Session::get('attribute')]) }}"><span class="btn btn-sm btn-success glyphicon glyphicon-plus"></span></a>
                </div>
            @endif
        @endif
    </div>
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
                    <td><a href="{{ url("/$path/$key/edit") }}" title="{{ Lang::get('general.EDIT_OBJ', ['attribute' => Session::get('attribute')]) }}"><span class="btn btn-xs btn-success glyphicon glyphicon-edit"></span></a></td>
                    @endif
                    @if(!isset($delete) || (isset($delete) && $delete))
                    <td>
                        @if($parent_table_id)
                        {!! Form::open(['method' => 'DELETE', 'action' => [$controller.'@destroy', $parent_table_id, $key], 'onsubmit' => 'return confirm("Are you sure?")']) !!}
                        @else
                        {!! Form::open(['method' => 'DELETE', 'action' => [$controller.'@destroy', $key], 'onsubmit' => 'return confirm("Are you sure?")']) !!}
                        @endif
                            {!! Form::button('', array('type' => 'submit', 'class' => 'btn btn-xs btn-danger glyphicon glyphicon-remove', 'title' => Lang::get('general.DELETE_OBJ', ['attribute' => Session::get('attribute')]) )) !!}
                        {!! Form::close() !!}
                    </td>
                    @endif
                @endif
            </tr>
            @endforeach
        </table>
    </div>
</div>
@if(isset($modal) && $modal)
<script>
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
function showApplicationModal(subject_id, school_year_id, course_id) {
    $.post(
        "/additional_info/application_by_subject/"+subject_id+"/"+school_year_id+"/"+course_id,
    {
        _token: CSRF_TOKEN,
        subject_id: subject_id,
        school_year_id: school_year_id,
        course_id: course_id
    },
    function(data, status){
        var professors = data.data;
        var subject = data.subject;
        var school_year = data.school_year;
        var course = data.course;
        var subject = data.subject;
        var div;
        var li;
        var active = 'active';
        for (var prof in professors) {
            $('#professor_name').append(prof);
            $('#additional_info').append(subject+", "+school_year+" - "+course);
            
            //div table
            var table_str = '<table class="table table-hover table-condensed"><tr><th>Student</th><th>Period</th><th>Application Date</th><th>Exam time</th><th>Exam Score</th></tr>';
            var applications = professors[prof];
            for (var app in applications){
                table_str +="<tr><td>"+ applications[app]['student'] + "</td>";
                table_str +="<td>"+ applications[app]['period'] + "</td>";
                table_str +="<td>"+ applications[app]['application_date'] + "</td>";
                table_str +="<td>"+ applications[app]['exam_datetime'] + "</td>";
                table_str +="<td>"+ applications[app]['exam_score'] + "</td>";
                table_str +="</tr>";
            }
            table_str +='</table>';
            $('#div_table_modal').append(table_str);
        }
    },
    'JSON');
}

function modalCancel() {
    $("#div_table_modal").empty();
    $("#professor_name").empty();
    $("#additional_info").empty();
}

</script>
<div class="modal fade" id="application_modal" tabindex="-1" role="dialog" aria-labelledby="applicationModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="modalCancel()"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Report</h4>
            </div>
            
            <div class="modal-body">
                <h2 id="professor_name"></h2>
                <h3 id="additional_info"></h3>
            </div>
            <div class="table-responsive" id="div_table_modal">
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="modalCancel()">Close</button>
            </div>
        </div>
    </div>
</div>
@endif
@stop