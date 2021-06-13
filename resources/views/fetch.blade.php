
@if(!empty($product_detail))
		@foreach($product_detail as $row)
			<div class="col-sm-4 col-lg-3 col-md-3">
				<div style="border:1px solid #ccc; border-radius:5px; padding:16px; margin-bottom:16px; height:450px;">
					<img src="ajax/image/{{$row['product_image']}}" alt="" class="img-responsive" >
					<p align="center"><strong><a href="#">{{$row['product_name']}}</a></strong></p>
					<h4 style="text-align:center;" class="text-danger" > {{$row['product_price']}} </h4>
					<p>Camera : {{ $row['product_camera']}} MP<br />
					Brand :  {{$row['product_brand']}}  <br />
					RAM :  {{$row['product_ram']}}  GB<br />
					Storage :  {{$row['product_storage']}}  GB </p>
				</div>

			</div>
		@endforeach	
    @else
	<h3>No Data Found</h3>
 @endif
    