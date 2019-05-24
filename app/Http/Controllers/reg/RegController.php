<?php

namespace App\Http\Controllers\reg;

use Illuminate\Http\Request;
use App\Model\RegModel;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class RegController extends Controller
{
    //注册跳转
    public function reg()
    {
        return view('reg.reg');
    }
    //注册
    public function regs(Request $request)
    {
//        echo 1111;
        $name=trim($_POST['name']);
        //var_dump($name);
        $email=$_POST['email'];
        $pass=trim($_POST['pass']);
        //var_dump($email);
        if(empty($name)){
            $response=[
                'error'=>10001,
                'msg'=>'姓名不存在'
            ];
            return(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        if(empty($email)){
            $response=[
                'error'=>10002,
                'msg'=>'邮箱不存在'
            ];
            return(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        if(empty($pass)){
            $response=[
                'error'=>10003,
                'msg'=>'密码不存在'
            ];
            return(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $regi=RegModel::where(['name'=>$name])->first();
        if($regi){
            $response=[
                'error'=>10004,
                'msg'=>'已有此用户'
            ];
            header("refresh:2;url=/reg");
            return(json_encode($response,JSON_UNESCAPED_UNICODE));
        }

        $data=[
            'name'=>$request->input('name'),
            'email'=>$email,
            'pass'=>password_hash($pass,PASSWORD_BCRYPT),
        ];
        //var_dump($data);
        $info=RegModel::insertGetId($data);
        if($info){
            $response=[
                'error'=>10005,
                'msg'=>'注册成功'
            ];
            header("refresh:3;url=/login");
            return(json_encode($response,JSON_UNESCAPED_UNICODE));
        }else{
            $response=[
                'error'=>10006,
                'msg'=>'注册失败'
            ];
            header("refresh:3;url=/reg");
            return(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        
    }


    public function login()
    {
        return view('login.login');
    }

    public function logins(Request $request)
    {
        $name=$request->input('name');
        $pass=$request->input('pass');
        $datain=RegModel::where(['name'=>$name])->first();
        if($datain){
            if(password_verify($pass,$datain->pass)){
                $token=$this->logintoken($datain->user_id);
                $redis_token_key='logintokens:user_id'.$datain->user_id;
                $rdd='user_id';
                Redis::set($rdd,$datain->user_id);
                Redis::expire($rdd,604800);
                Redis::set($redis_token_key,$token);
                Redis::expire($redis_token_key,604800);


                //生成touken
                $response=[
                    'error'=>0,
                    'msg'=>'登陆成功',
                    'data'=>[
                        'token'=>$token
                    ],
                ];
                header("refresh:3;url=/index");
                return (json_encode($response,JSON_UNESCAPED_UNICODE));
            }else{
                $response=[
                    'error'=>90001,
                    'msg'=>'密码不正确'
                ];
            }
            return (json_encode($response,JSON_UNESCAPED_UNICODE));
        }else{
            $response=[
                'error'=>90002,
                'msg'=>'用户不存在'
            ];
            return (json_encode($response,JSON_UNESCAPED_UNICODE));
        }


    }

    public function logintoken($user_id){
        return substr(sha1($user_id.time().Str::random(10)),5,15);
    }

}
