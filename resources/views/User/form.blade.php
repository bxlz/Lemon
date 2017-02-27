@extends('layouts.app')

@section('content')
    <form class="form-horizontal col-md-12" method="post" action="">
        <div class="form-group">
            <label for="" class="control-label col-md-2">标题：</label>
            <div class="col-md-3">
                <input id="form_title" name="form_title" type="text" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <button onclick="add()" type="button" class="btn btn-info w-lg">添加元素</button>
        </div>
    </form>

    <!-- modal -->
    <div id="form-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-1" class="control-label">选择类型：</label>
                                <button type="button" class="btn btn-info" onclick="checktype(1)">input</button>
                                <button type="button" class="btn btn-info" onclick="checktype(2)">radio</button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            元素标题<input type="text" id="element_title">
                            元素name<input type="text" id="element_name">
                            元素type<input type="text" id="element_type">
                            单选text<input type="text" id="radio_text">
                            单选value<input type="text" id="radio_value">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-white" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-info" onclick="save()">保存</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@yield('jquery')
<script>
    function add(){
        $('#form-modal').modal('show');
    }
    function checktype(flag){
        if(flag==1){
            $('#element_type').val('text');
        }else{
            $('#element_type').val('radio');
        }
    }

    function save(){
        var element_title = $('#element_title').val();
        var element_name = $('#element_name').val();
        var element_type = $('#element_type').val();
        var radio_text = $('#radio_text').val();
        var radio_value = $('#radio_value').val();
        var form_title= $('#form_title').val();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/user/editForm',
                data: {'element_title' : element_title,
                    'element_name' :element_name,
                    'element_type' :element_type,
                    'radio_text' :radio_text,
                    'radio_value' :radio_value,
                    'form_title': form_title
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    alert('成功');
                }
            });
    }
</script>

