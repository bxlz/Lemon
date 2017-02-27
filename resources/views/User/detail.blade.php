@extends('layouts.app')

@section('content')
    <form class="form-horizontal col-md-12" method="post" action="{{url('user/saveForm')}}">
        {{ csrf_field() }}
        <div class="form-group">
            <input type="hidden" name="form_id" value="{{$info->id}}">
            <label for="" class="control-label col-md-2"> {{$info->form_title}}</label>
        </div>
        @foreach($text as $t)
            <div class="form-group">
                <label for="" class="control-label col-md-2"> {{$t->element_title}}</label>
                <input type="text" name="{{$t->element_name}}" value="{{$t->element_value}}">
            </div>
        @endforeach
        @foreach($data as $r)
            <div class="form-group">
                <label for="" class="control-label col-md-2"> {{$r['element_title']}}</label>
                @foreach($r['type'] as $v)
                    @if($v['radio_value']==$r['element_value'])
                    <input name="{{$r['element_name']}}" type="radio" value="{{$v['radio_value']}}" checked="checked"/>{{$v['radio_text']}}
                    @else
                    <input name="{{$r['element_name']}}" type="radio" value="{{$v['radio_value']}}" />{{$v['radio_text']}}
                    @endif
                @endforeach
            </div>
        @endforeach
    </form>
@endsection