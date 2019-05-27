<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="">
    <table>
        <tr>
            手机号:<input type="text" name="tel"></br>
            验证码:<input type="text" name="code"><input type="button" id="btn" value="获取验证码"></br>
            <input type="button" id="btn1" value="登陆"></br>
        </tr>
    </table>
</form>
</body>
</html>
<script src="js/jquery.min.js"></script>
<script>
    $(function () {
        $('#btn').click(function(){
            //var _this=$(this);
            var tel=$('[name="tel"]').val();
            //console.log(tel);
            $.ajax({
                url:'getCode',
                data:{tel:tel},
                dataType:'json',
                type:'post',
                success:function(msg){
                    console.log(msg);
                }
            })
        })

        $('#btn1').click(function(){
            var tel=$('[name="tel"]').val();
            var code=$('[name="code"]').val();
            // console.log(tel);
            // console.log(code);
            $.ajax({
                url:'tel',
                data:{tel:tel,code:code},
                dataType:'json',
                type:'post',
                success:function(msg){
                    if(msg.error == 0){
                        alert(msg.msg);
                        location.href = 'index';
                    }
                }
            })
        })
    })
</script>