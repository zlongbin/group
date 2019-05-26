<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <title>Mstore - Online Shop Mobile Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1  maximum-scale=1 user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="HandheldFriendly" content="True">

    <link rel="stylesheet" href="css/materialize.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/owl.theme.css">
    <link rel="stylesheet" href="css/owl.transitions.css">
    <link rel="stylesheet" href="css/fakeLoader.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="shortcut icon" href="img/favicon.png">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
    <script src="/js/jquery-1.12.4.min.js"></script>
    <script src="/bootstrap/js/bootstrap.js"></script>

</head>
<body>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <table class="table">
                {{ csrf_field() }}
                <input type="hidden" class="add" value="{{$user_id}}" name="user_id">
            <tr>
                <td class="active">订单号</td>
                <td class="warning">总价</td>
                <td class="danger">下单时间</td>
                <td class="info">操作</td>
            </tr>
                <tbody id="show">
                <tr>
                    <td class="active"></td>
                    <td class="warning"></td>
                    <td class="danger"></td>
                    <td class="info"></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-2"></div>
    </div>
</body>
</html>
<script>
    $(function() {
        // alert(111);
        var user_id=$(".add").val();
        $.ajax({
            url: '/ordershow',
            dataType: 'json',
            type: 'post',
            data: {user_id:user_id},
            success: function (result) {
                // alert(result)
                var _tr = "";
                for(var i in result){
                    _tr+="<tr>"
                        +"<td class='active'>"+result[i]['order_sn']+"</td>"
                        +"<td class='warning'>￥"+result[i]['add_price']+"</td>"
                        +"<td class='danger'>"+result[i]['addtime']+"</td>"
                        +"<td class='info'><a href='/pay/alipay/pay?oid="+result[i]['oid']+"'>去结算</a></td>"
                        +"<tr>"
                }
                $("#show").html(_tr)
            }
        })
    })
</script>
