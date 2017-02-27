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
                            @foreach($allFormInfo as $tmp)
                                <tr role="row" class="odd">
                                    <td>{{$tmp->id}}</td>
                                    <td>{{$tmp->form_title}}</td>
                                    <td>{{$tmp->created_at}}</td>
                                    <td><a class="btn btn-info btn-xs" href="/user/write/{{$tmp->id}}">填写</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="dataTables_info" id="datatable_info" role="status"
                                 aria-live="polite">显示 {{ $allFormInfo->firstItem() }} 到 {{ $allFormInfo->lastItem() }} 共 {{ $allFormInfo->total() }} 条
                            </div>
                        </div>
                        <div class="col-sm-6 text-right">
                            <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                                {!! $allFormInfo->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection