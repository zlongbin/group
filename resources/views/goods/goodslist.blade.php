@extends('layout.header')
@section('title', '商品列表')

@section('header')
    @parent
	<!-- product -->
	<div class="section product product-list">
		<div class="container">
			<div class="pages-head">
				<h3>PRODUCT LIST</h3>
			</div>
			<div class="input-field">
				<select>
					<option value="">Popular</option>
					<option value="1">New Product</option>
					<option value="2">Best Sellers</option>
					<option value="3">Best Reviews</option>
					<option value="4">Low Price</option>
					<option value="5">High Price</option>
				</select>
			</div>
			<div class="row">
            @foreach($goods as $k=>$v)
				<div class="col s6">
					<div class="content">
						<img src="/goodsimg/{{$v->goods_img}}" alt="">
						<h6><a href="/goods/goodsDetail?goods_id={{$v->goods_id}}">{{$v->goods_name}}</a></h6>
						<div class="price">
							${{$v->goods_selfprice}}<span>${{$v->goods_marketprice}}</span>
						</div>
						<button class="btn button-default cart" id="{{$v->goods_id}}">ADD TO CART</button>
					</div>
				</div>
            @endforeach
			</div>	
			<div class="pagination-product">
				<!-- <ul>
					<li class="active">1</li>
					<li><a href="">2</a></li>
					<li><a href="">3</a></li>
					<li><a href="">4</a></li>
					<li><a href="">5</a></li>
				</ul> -->
                {{$goods->links()}}
			</div>
		</div>
	</div>
	<!-- end product -->
@endsection

<!-- 主体内容 -->
@section('content')
@endsection

@section('footer')
    @parent
	<script>
	$(document).on('click','.cart',function(){
		var goods_id = $(this).attr('id')
		$.ajax({
			type:"post",
			url:"/cartAdd",
			data:{goods_id:goods_id},
			dataType:'json',
			success:function(res){
				console.log(res)
				alert(res.msg)
			}
		})
	})
	</script>
@endsection