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

//        if (!Captcha::check($captcha)) {
//           return response()->json(array('status' => 'false'));
//        } else {
//            return response()->json(array('status' => 'true'));
//        }
        return response()->json(array('status' => 'true'));
    }

    public static function encrypt($lenght)
    {
        $chars = array( 
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",  
        "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",  
        "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",  
        "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",  
        "S", "T", "U", "V", "W", "X", "Y", "Z"
        ); 
        $charsLen = count($chars) - 1; 
        shuffle($chars);   
        $output = ""; 
        for ($i=0; $i<$lenght; $i++) 
        { 
            $output .= $chars[mt_rand(0, $charsLen)]; 
        }  
        return $output;
    }

}