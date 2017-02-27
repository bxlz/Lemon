@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">登录页面</div>
                    <div class="panel-body">
                        <form id="form" class="form-horizontal" role="form" method="POST" action="{{ url('user/login') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="username" class="col-md-4 control-label">用户名</label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" name="username">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label">密码</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label">验证码</label>

                                <div class="col-md-6">
                                    <input type="text" id="code" class="code" name="code" class="form-control" >
                                    <span><i class="fa fa-check-square-o"></i></span>
                                    <!-- 2.要点，src引入的是获取验证码的路由，做一个点击刷新的JS，并且后面带一个随机参数 -->
                                    <img id="code_img" src="{{url('tool/code')}}" alt="" onclick="this.src='{{url('tool/code')}}?'+Math.random()">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="alert alert-warning"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button id="login_button" type="button" class="btn btn-primary" onclick="checkForm()">
                                        <i class="fa fa-btn fa-sign-in"></i> 登录
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@yield('jquery')
<script>
    function checkForm(){
        var data={
            "formName":$("#username"),
            "formPwd":$("#password")
        }
        var showTips=$(".alert");
        var targetPage=$("form").attr("action");
        var pwdReg="^[0-9A-Za-z]{6,12}$";
        var captcha = $("#code").val();
        //alert(captcha);
        if(captcha==""){
            $("#code_img").attr('src','../tool/code?r=' + Math.random() );
            showTips.css("visibility","visible").removeClass("alert-warning").addClass("alert-danger").html("验证码必须填写");
            return false;
        }
        function checkCap(captcha,data){
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '../tool/captchaJudge',
                data: {'captcha' : captcha},
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(result) {
                    if (result.status == 'false') {
                        $("#code_img").attr('src','../tool/code?r=' + Math.random() );
                        showTips.css("visibility","visible").removeClass("alert-warning").addClass("alert-danger").html("验证码错误");
                        return false;
                    } else {
                        check(data);
                        checkExist(data["formName"].val(),data["formPwd"].val());
                    }
                },

                error: function(xhr, data) {

                }
            });
        }

        function check(data){
            console.log(data);
            for(var keys in data){
                if(data[keys][0] != undefined){
                    if(data[keys].val() == null || data[keys].val()==""){
                        showTips.removeClass().addClass("col-xs-12 m-t-15 alert alert-warning");
                        showTips.css("visibility","visible");
                        showTips.html("请"+data[keys].attr("placeholder"));
                        data[keys].focus();
                        return false;
                    }else if(keys=="formPwd" && !data[keys].val().match(pwdReg)){
                        showTips.css("visibility","visible").removeClass("alert-warning").addClass("alert-danger").html("格式错误，密码为6-12位数字加字母");
                        return false;
                    }
                }
            }
            $('#form').submit();
        }
        function checkExist(username,password){
            console.log(username,password);
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: 'checkIfExist',
                data: {'username' : username, 'password':password},
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(result) {
                    if (result.status == 'false') {
                        $("#captcha_img").attr('src','../tool/code?r=' + Math.random() );
                        showTips.css("visibility","visible").removeClass("alert-warning").addClass("alert-danger").html("用户名或密码错误");
                        return false;
                    } else {
                        $('#login_button').val('正在登陆中...');
                        $('#form').submit();
                    }
                },

                error: function(xhr, data) {

                }
            });
        }
        checkCap(captcha,data);
    }
</script>