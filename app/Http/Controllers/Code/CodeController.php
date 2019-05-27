<?php

namespace App\Http\Controllers\Code;

use App\Http\Controllers\Weixin\JssdkController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CodeController extends Controller
{
    /**手机号授权登陆*/
    public function telChat(){
        return view('code.code');
    }
    /**验证码*/
    public function getCode(Request $request){
        $tel=$request->input('tel');
        // $num='1234';
        $num = rand(1000,9999);
        $tel = "$tel";
        $bol = $this->show($tel,$num);

        if($bol == 100){
            $res = DB::table('code')->where('tel',$tel)->first();
            if(empty($res)){
                $time=time()+240;
                $arr = array(
                    'code'=>$num,
                    'tel'=>$tel,
                    'timeout'=>$time,
                );

                $data = DB::table('code')->insert($arr);
                if($data){
                    // session($where);
                    die(json_encode(['error'=>0,'msg'=>'发送成功'],JSON_UNESCAPED_UNICODE));
                }else{
                    die(json_encode(['error'=>50018,'msg'=>'发送失败'],JSON_UNESCAPED_UNICODE));
                }
            }else{
                $time=time()+240;
                $update = [
                    'code'=>$num,
                    'timeout'=>$time
                ];
                $info = DB::table('code')->where('tel',$tel)->update($update);
                if($info){
                    die(json_encode(['error'=>0,'msg'=>'发送成功'],JSON_UNESCAPED_UNICODE));
                }else{
                    die(json_encode(['error'=>50018,'msg'=>'发送失败'],JSON_UNESCAPED_UNICODE));
                }
            }
        }else{
            die(json_encode(['error'=>50018,'msg'=>'发送失败'],JSON_UNESCAPED_UNICODE));
        }
    }
    public function show($tel,$num){
        $content = "您的验证码是：【{$num}】。如需帮助请联系客服。";//
        $ch = curl_init();//初始化
        $arr= config('app.send');
        $str="{$arr['url']}?account={$arr['username']}&password={$arr['pwd']}&mobile={$tel}&content={$content}";
        curl_setopt($ch,CURLOPT_URL, $str);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $info = curl_exec($ch);
        var_dump($info);
        return $info;
    }

    /**授权*/
    public function tel(Request $request){
        $tel = $request->input('tel');
        $code = $request->input('code');
        if(empty($tel)){
            $response = [
                'error'=>50020,
                'msg'=>'手机号不能为空'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        if(empty($code)){
            $response = [
                'error'=>50021,
                'msg'=>'请先获取验证码'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $res = DB::table('code')->where('tel',$tel)->first();
        if($res){
            $code1 = $res->code;
            //var_dump($code1);exit;
            if($code != $code1){
                $response = [
                    'error'=>50019,
                    'msg'=>'验证码有误'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }else{
                $id = $res->id;
                session(['user_id' => $id]);
                $response = [
                    'error'=>0,
                    'msg'=>'授权成功'
                ];
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }
        }else{
            $response = [
                'error'=>50022,
                'msg'=>'未经过授权'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }


    }
}
