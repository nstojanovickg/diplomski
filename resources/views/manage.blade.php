@extends('app')

@section('title', Lang::get('general.'.$action, ['attribute' => Session::get('attribute')])." ")

@section('content')
<h1>{{ Lang::get('general.'.$action, ['attribute' => Session::get('attribute')]) }}</h1>
{!! form_start($form) !!}
    {!! form_rest($form) !!}
    <a class="btn btn-link" href="{{ url ('/'.$path) }}">{{ Lang::get('general.CANCEL') }}</a>
    <input class="btn btn-success" type="submit" value="{{ Lang::get('general.'.$action, ['attribute' => Session::get('attribute')]) }}">
{!! form_end($form) !!}
@stop