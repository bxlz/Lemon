@extends('layouts.app')

@section('content')
    <form class="form-horizontal col-md-12" method="post" action="{{url('user/saveForm')}}">
        {{ csrf_field() }}
        <div class="form-group">
            <input type="hidden" name="form_id" value="{{$info->id}}">
            <label for="" class="control-label col-md-2"> {{$info->form_title}}</label>
        </div>
        <div class="form-group">
            @foreach($text as $t)
                <label for="" class="control-label col-md-2"> {{$t->element_title}}</label>
                <input type="text" name="{{$t->element_name}}" value="{{$t->element_value}}">
            @endforeach
        </div>
        <div class="form-group">
            @foreach($radio as $r)
                <label for="" class="control-label col-md-2"> {{$r->element_title}}</label>
                <input name="{{$r->element_name}}" type="radio" value="{{$r->radio_value}}" />{{$r->radio_text}}
            @endforeach
        </div>
    </form>
@endsection