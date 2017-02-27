<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    public function index(){
        $allUserInfo = User::paginate(20);
        return view('user.user',['allUserInfo'=>$allUserInfo]);
    }

    //编辑新增用户
    public function editUser(Request $request)
    {
        $password = $request->input('password');
        $username = $request->input('username');
        $id = $request->input('id');
        $user = new User();
        $num = $user->where('username',$username)->count();
        $one = $user->where('id',$id)->where('username',$username)->count();

        if($id==0)
        {
            if($num>0){
                $data = array('result' => false);
                return json_encode($data);
            }else {
                $user->username = $username;
                $user->password = bcrypt($password);
                $user->save();
            }
        }
        else{
            //dd($num,$one);
            if($num > 0 && $one ==0) {
                $data = array('result' => false);
                return json_encode($data);
            }else{
                $user->where('id', $id)->update(['username' => $username, 'password' => bcrypt($password)]);
            }
        }

        $allUserInfo = $user->get();
        $data = array('result' => true,'allUserInfo' =>$allUserInfo);
        return json_encode($data);
    }

    //删除
    public function deleteUser()
    {
        $id = Input::get('id');
        $user= new User();
        $res = $user->where('id',$id)->delete();
        if($res){
            $data = array('result' => true);
            return json_encode($data);
        }else{
            $data = array('result' => false);
            return json_encode($data);
        }
    }
}
