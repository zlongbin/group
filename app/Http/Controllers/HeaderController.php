<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\OrderModel;
use App\Model\CartModel;
use App\Model\GoodsModel;
use Illuminate\Support\Facades\Redis;
class HeaderController extends Controller{
    public function header(){
        return view('layout.header');
    }
    public function client(){
        return view('layout.client');
    }
    public function footer(){
        echo "<pre>";print_r($_SERVER);echo "</pre>";
        return view('layout.footer');
        // [HTTP_USER_AGENT] => Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36
    }
    /**
     * 微信授权
     */
    public function wxWeb(){
        $redirect_uri = urlEncode('http://group.yxxmmm.com/wxWeb/getu');
        // var_dump($redirect_uri);echo "<hr>";
        $url =  'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WX_APP_ID').'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        // echo $url;
        if(strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')){
            header("location:$url");
        }
    }
    public function getU(){
        $code = $_GET['code'];
        // 获取授权access_token
        $access_token_url ='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WX_APP_ID').'&secret='.env('WX_APP_SECRET').'&code='.$code.'&grant_type=authorization_code';
        $response = json_decode(file_get_contents($access_token_url),true);
        // echo "<pre>";print_r($response);echo "</pre>";
        $access_token = $response['access_token'];
        $openid = $response['openid'];
        // 根据openid判断用户是否存在
        $wx_user = WebUserModel::where(['openid'=>$openid])->first();
        if(session('user_id')){
            $uid =session('user_id');
        }else{
            $uid='';
        }
        if($wx_user){
            if($wx_user['uid']){
                $is_uid = 0;
            }else{
                $is_uid = 1;
            }
            $response = [
                'error' => 0,
                'msg'   => '欢迎回来',
                'data'  => [
                    'is_uid'=> $is_uid,
                    'id'    =>$wx_user['id'],
                    'uid'   => $uid
                ]
            ];
        }else{
            // 获取用户信息
            $user_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
            $user_Info = json_decode(file_get_contents($user_url),true);
            // echo "<pre>";print_r($user_Info);echo "</pre>";
            // 用户信息入库
            $Info=[
                'openid'=>$user_Info['openid'],
                'nickname'=>$user_Info['nickname'],
                'sex'=>$user_Info['sex'],
                'headimgurl'=>$user_Info['headimgurl']
            ];
            $id = WebUserModel::insert($Info);
            $response = [
                'error' => 0,
                'msg'   => '欢迎访问此网页',
                'data'  => [
                    'is_uid'   => 1,
                    'id'    =>$id,
                    'uid'   => $uid
                ]
            ];
        }
        die(json_encode($response,JSON_UNESCAPED_UNICODE));
    }
    /**
     * 绑定用户
     */
    public function bind(Request $request){
        $uid = $request->input('uid');
        $id = $request->input('id');
        $userinfo = UserModel::where('user_id',$uid)->first();
        $data = [
            'uid'   => $userinfo['user_id'],
            'uname' => $userinfo['name'],
            'uemail'=> $userinfo['email']
        ];
        $res = WxWebModel::where(['id' => $id])->update($data); 
        if($res){
            $response = [
                'error' => 0,
                'msg'   => '绑定用户成功'
            ];
        }else{
            $response = [
                'error' => 50020,
                'msg'   => '绑定用户失败'
            ];
        }
        die(json_encode($response,JSON_UNESCAPED_UNICODE));
    }
}
// <script>
//     var ua = navigator.userAgent.toLowerCase();
//     var is_weixin = ua.indexOf('micromessenger') != -1
//     if(is_weixin){
//         $.ajax({
//             type:'post',
//             url:"/wxWeb",
//             dataType:'json',
//             success:function(res){
//                 alert(res.msg)
//                 if(res.data.is_uid == 1&&res.data.uid != ''){
//                     var con;
//                     con=confirm("是否绑定原有账号?"); //在页面上弹出对话框
//                     if(con==true){
//                         $.ajax({
//                             type:'post',
//                             url:"/wxWeb/bind",
//                             dataType:'json',
//                             data:{uid:res.data.uid,id:res.data.id},
//                             success:function(res){
//                                 if(res.error == 0){
//                                     alert(res.msg)
//                                     location.href="/"       
//                                 }
//                             }
//                         })
//                     }else{
//                         location.href="/"
//                     }
//                 }
//             }
//         })
//     }
// </script>