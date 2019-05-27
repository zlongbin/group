<script>
    var ua = navigator.userAgent.toLowerCase();
    var is_weixin = ua.indexOf('micromessenger') != -1
    if(is_weixin){
        $.ajax({
            type:'post',
            url:"/wxWeb",
            dataType:'json',
            success:function(res){
                alert(res.msg)
                if(res.data.is_uid == 1&&res.data.uid != ''){
                    var con;
                    con=confirm("你喜欢玫瑰花么?"); //在页面上弹出对话框
                    if(con==true){
                        $.ajax({
                            type:'post',
                            url:"/wxWeb/bind",
                            dataType:'json',
                            data:{uid:res.data.uid,id:res.data.id},
                            success:function(res){
                                if(res.error == 0){
                                    alert(res.msg)
                                    location.href="/"       
                                }
                            }
                        })
                    }else{
                        location.href="/"
                    }
                }
            }
        })
    }
</script>