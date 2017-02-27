<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Models\Finance;
use App\Models\Address;

use Illuminate\Http\Request;
use DB;

//引用对应的命名空间
use Validator,Session,Captcha,Mail,Excel,Response;

class ToolController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function captcha()
    {
        return Captcha::create('default');
    }

    public function captchaJudge(Request $request){
        $captcha = $request['captcha'];

        if (!Captcha::check($captcha)) {
           return response()->json(array('status' => 'false'));
        } else {
            return response()->json(array('status' => 'true'));
        }
        //return response()->json(array('status' => 'true'));
    }

}