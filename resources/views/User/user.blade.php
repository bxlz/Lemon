@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div id="datatable_wrapper"
                 class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-12  data-list">
                        <table id="datatable"
                               class="table table-striped table-bordered dataTable no-footer"
                               role="grid" aria-describedby="datatable_info" style="overflow-X:scroll">
                            <thead>
                            <tr role="row">
                                <th>ID</th>
                                <th class="sorting" tabindex="0" aria-controls="datatable"
                                    rowspan="1" colspan="1"
                                    aria-label="Office: activate to sort column ascending">用户名
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="datatable"
                                    rowspan="1" colspan="1"
                                    aria-label="Salary: activate to sort column ascending">创建时间
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="datatable"
                                    rowspan="1" colspan="1"
                                    aria-label="Salary: activate to sort column ascending">操作
                                </th>
                            </tr>
                            </thead>
                            <tbody id="data-list">
                            @foreach($allUserInfo as $tmp)
                                <tr role="row" class="odd">
                                    <td>{{$tmp->id}}</td>
                                    <td>{{$tmp->username}}</td>
                                    <td>{{$tmp->created_at}}</td>
                                    <td><a class="btn btn-info btn-xs" onclick="editUser(1,'{{$tmp->id}}','{{$tmp->username}}')">编辑</a>
                                    <a class="btn btn-info btn-xs" onclick="deleteUser('{{$tmp->id}}')">删除</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="dataTables_info" id="datatable_info" role="status"
                                 aria-live="polite">显示 {{ $allUserInfo->firstItem() }} 到 {{ $allUserInfo->lastItem() }} 共 {{ $allUserInfo->total() }} 条
                            </div>
                        </div>
                        <div class="col-sm-6 text-right">
                            <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                                {!! $allUserInfo->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <a class="btn btn-white" onclick="editUser(0)">新增</a>
            </div>
        </div>
    </div>

    <!-- modal -->
    <div id="update-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-1" class="control-label">用户名：</label>
                                <input type="text" id="modal_id" hidden="true">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" class="form-control" id="modal_username">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-2" class="control-label">密码：</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="password" class="form-control" id="modal_password">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="field-2" class="control-label">确认密码：</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="password" class="form-control" id="modal_password_again">
                            </div>
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

    <div id="tips" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">提示</h4>
                </div>
                <div class="modal-body">
                    <p class="modal_p"></p>
                </div>
                <div class="modal-footer">
                    <button id="jump" type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection
@yield('jquery')
<script>
    function editUser(flag,id,username){
        if(flag!=0){
        $('#modal-title').html('修改用户信息');
        $('#modal_username').val(username);
        $('#modal_id').val(id);
        }else{
            $('#modal-title').html('新增用户信息');
            $('#modal_id').val(flag);
        }
        $('#update-modal').modal('show');
    }

    function save(){
        var password = $('#modal_password').val();
        var password_again = $('#modal_password_again').val();
        var username = $('#modal_username').val();
        var id = $('#modal_id').val();
        if(password!=password_again){
            alert("两次输入密码不一致");
            return false;
        }
        else{
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/user/editUser',
                data: {'password' : password,
                    'username' :username,
                    'id': id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    console.log(data);
                    if (data.result) {
                        var html = ``;
                        $.each(data.allUserInfo, function (i, arr) {
                            html += `<tr role="row" class="odd">
                         <td>${arr.id}</td>
                         <td>${arr.username}</td>
                         <td>${arr.created_at}</td>
                         <td><a class="btn btn-info btn-xs" onclick="editUser(1,'${arr.id}','${arr.username}')">编辑</button>
                         <td><a class="btn btn-info btn-xs" onclick="deleteUser('${arr.id}')">删除</button>
                                                                    </td>
                                                                </tr>`;
                        });
                        //console.log(html);
                        $('#data-list').html(html);
                        $('#update-modal').modal('hide');
                        $('#tips').modal('show');
                        $('.modal_p').html('成功');
                    }else{
                        $('#update-modal').modal('hide');
                        $('.modal_p').html('该用户名已存在');
                        $('#tips').modal('show');
                    }
                }
            });
        }
    }

    function deleteUser(id){
        var r = confirm("您确定要删除吗?");
        if(r==true){
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '/user/deleteUser',
                data: {'id' : id},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.result) {
                        $('.modal_p').html('删除成功');
                        $('#tips').modal('show');
                        $('#jump').attr('onclick', 'window.location.reload();');

                    } else {
                        $('.modal_p').html('删除失败');
                        $('#tips').modal('show');
                        return false;
                    }
                },

                error: function(xhr, data) {
                }
            });
        }
    }
</script>