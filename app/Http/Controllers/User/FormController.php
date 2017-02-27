<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ToolController;
use Illuminate\Support\Facades\Input;
use DB;

class FormController extends Controller
{
    public function index(){
        return view('user/form');
    }

    public function editForm(Request $request)
    {
        //dd($request->all());
        $element_title = $request->input('element_title');
        $element_name = $request->input('element_name');
        $element_type = $request->input('element_type');
        $radio_text = $request->input('radio_text');
        $radio_value = $request->input('radio_value');
        $form_title= $request->input('form_title');
        $created_at =date('Y-m-d H:i:s');
        $form_id = DB::table('forms')->insertGetId(['form_title'=>$form_title,
        'user_id'=>session('user_id'),'created_at'=>$created_at]);
        //dd($form_id);
        if($element_type == 'text'){
            DB::table('form_elements')->insert(['element_title'=>$element_title,
                'element_name'=>$element_name,'element_type'=>1,'form_id'=>$form_id
                ,'created_at'=>$created_at]);
        }else{
            $element_id = DB::table('form_elements')->insert(['element_title'=>$element_title,
                'element_name'=>$element_name,'element_type'=>2,'form_id'=>$form_id,'created_at'=>$created_at]);
            DB::table('radios')->insert(['radio_text'=>$radio_text,'radio_value'=>$radio_value,
                'element_id'=>$element_id,'created_at'=>$created_at]);
        }
        $data = array('result' => true);
        return json_encode($data);
    }

    public function lists(){
        $allFormInfo = DB::table('forms')->where('user_id',session('user_id'))->paginate(5);
        return view('user.list',['allFormInfo'=>$allFormInfo]);
    }

    public function write($id){
        $info = DB::table('forms as f')
            ->where('f.id',$id)->first();
        //dd($info);
        //text
        $text = DB::table('form_elements')
            ->where('element_type',1)
            ->where('form_id',$id)->get();
        //radio
        $radio1 = DB::table('form_elements')
            ->where('element_type',2)
            ->where('form_id',$id)->get();
        $data = array();
        foreach($radio1->toArray() as $k=>$v){
            $data[$k] = json_decode(json_encode($v), true);
            $radio = DB::table('radios')
            ->where('element_id',$v->id)
            ->get();
            //dd($radio);
            foreach($radio->toArray() as $r) {
                //dd($r->radio_value);
                //dump($r->radio_text);
                $data[$k]['type'][] = ['radio_text'=>$r->radio_text,'radio_value'=>$r->radio_value];
            }
            //dd($data);
        }
//        if(count($radio->toArray()) == count($radio->toArray(),1)){
//            dd("是一维");
//        }else{
//            dd("不是一维");
//        }
        //dd($data);
        return view('user.write',['info'=>$info,'text'=>$text,'data'=>$data]);
    }

    public function saveForm(Request $request){
        //dd($request->all());
        $data = $request->except('form_id','_token');
        foreach ($data as $k=>$v){
            DB::table('form_elements')
                ->where('form_id',$request['form_id'])
                ->where('element_name',$k)
                ->update(['element_value'=>$v]);
        }
        return redirect('user/detail/'.$request['form_id']);
    }

    public function detail($id){
        $info = DB::table('forms as f')
            ->where('f.id',$id)->first();
        //dd($info);
        //text
        $text = DB::table('form_elements')
            ->where('element_type',1)
            ->where('form_id',$id)->get();
        //radio
        $radio1 = DB::table('form_elements')
            ->where('element_type',2)
            ->where('form_id',$id)->get();
        $data = array();
        foreach($radio1->toArray() as $k=>$v){
            $data[$k] = json_decode(json_encode($v), true);
            $radio = DB::table('radios')
                ->where('element_id',$v->id)
                ->get();
            //dd($radio);
            foreach($radio->toArray() as $r) {
                //dd($r->radio_value);
                //dump($r->radio_text);
                $data[$k]['type'][] = ['radio_text'=>$r->radio_text,'radio_value'=>$r->radio_value];
            }
            //dd($data);
        }
        //dd($radio);
        return view('user.detail',['info'=>$info,'text'=>$text,'data'=>$data]);
    }


}
