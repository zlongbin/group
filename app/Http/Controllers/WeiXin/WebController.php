<?php

namespace App\Http\Controllers\WeiXin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\RegModel;
use App\Model\WebModel;

class WebController extends Controller
{
    /**
     * 微信授权
     */
    public function wxWeb(){
        $redirect_uri = urlEncode('http://group.yxxmmm.com/wxWeb/getu');
        // var_dump($redirect_uri);echo "<hr>";
        $url =  'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WX_APP_ID').'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        // echo $url;
        header("location:$url");
        // echo "<pre>";print_r($_SERVER);echo "</pre>";   
        // if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')){
        //     header("location:$url");
        // }
    }
    public function getU(){
        $code = $_GET['code'];
        // echo $code;
        // 获取授权access_token
        $access_token_url ='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WX_APP_ID').'&secret='.env('WX_APP_SECRET').'&code='.$code.'&grant_type=authorization_code';
        $response = json_decode(file_get_contents($access_token_url),true);
        // echo "<pre>";print_r($response);echo "</pre>";die;
        $access_token = $response['access_token'];
        $openid = $response['openid'];
        // 根据openid判断用户是否存在
        $wx_user = WebModel::where(['openid'=>$openid])->first();
        if($wx_user){
            $user_id=$wx_user->user_id;
            $response = '欢迎回来';
        }else{
            // 获取用户信息
            $user_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
            $user_Info = json_decode(file_get_contents($user_url),true);
            // echo "<pre>";print_r($user_Info);echo "</pre>";
            $user_data = [
                'nickname'=>$user_Info['nickname']                
            ];
            $user_id = RegModel::insertGetId($user_data);
            // 用户信息入库
            $web_data=[
                'openid'=>$user_Info['openid'],
                'nickname'=>$user_Info['nickname'],
                'sex'=>$user_Info['sex'],
                'headimgurl'=>$user_Info['headimgurl'],
                'user_id'   => $user_id
            ];
            $web_id = WebModel::insert($web_data);
            $response = '欢迎访问';
        }
        session('user_id',$user_id);
        header('refresh:3.url=/');
        die($response);
    }
}
