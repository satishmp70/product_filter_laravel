<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="/ajax/css/bootstrap.min.css">
    <link href = "/ajax/css/jquery-ui.css" rel = "stylesheet">
    <!-- Custom CSS -->
    <link href="/ajax/css/style.css" rel="stylesheet">
    <title>Ajax</title>
    <style>
        #loading
        {
            text-align:center; 
            background: url('/ajax/loader.gif') no-repeat center; 
            height: 150px;
        }
        </style>
</head>
<body>
    
    <div class="container">
        <div class="row">
        	<br />
        	<h2 align="center">Advance Ajax Product Filters in PHP</h2>
        	<br />
            <div class="col-md-3">                				
				<div class="list-group">
					<h3>Price</h3>
					<input type="hidden" id="hidden_minimum_price" value="0" />
                    <input type="hidden" id="hidden_maximum_price" value="65000" />
                    <p id="price_show">1000 - 65000</p>
                    <div id="price_range"></div>
                </div>				
                <div class="list-group">
					<h3>Brand</h3>
                    <div style="height: 180px; overflow-y: auto; overflow-x: hidden;">

                    @foreach($brands as $brand)
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector brand" value="{{$brand['product_brand'] }}"  > {{$brand['product_brand'] }}</label>
                    </div>
                   @endforeach
                    </div>
                </div>

				<div class="list-group">
					<h3>RAM</h3>
                   
                    @foreach($ram as $mram)
                  
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector ram" value="{{$mram['product_ram']}}" > {{$mram['product_ram']}} GB</label>
                    </div>
                  @endforeach
                </div>
				
				<div class="list-group">
					<h3>Internal Storage</h3>
					
                    @foreach($storage as $mstorage)
                   
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector storage" value="{{ $mstorage['product_storage']}}"  > {{ $mstorage['product_storage']}} GB</label>
                    </div>
                   @endforeach
                </div>
            </div>

            <div class="col-md-9">
            	<br />
                <div class="row filter_data">
                    @include('fetch');
                </div>
            </div>
        </div>

    </div>
    
    <script src="/ajax/js/jquery-1.10.2.min.js"></script>
    <script src="/ajax/js/jquery-ui.js"></script>
    <script src="/ajax/js/bootstrap.min.js"></script>   
    <script>
        $(document).ready(function(){
        
            filter_data();
        
            function filter_data()
            {
                $('.filter_data').html('<div id="loading" style="" ></div>');
                var action = 'fetch_data';
                var minimum_price = $('#hidden_minimum_price').val();
                var maximum_price = $('#hidden_maximum_price').val();
                var brand = get_filter('brand');
                var ram = get_filter('ram');
                var storage = get_filter('storage');
                $.ajax({
                    headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                    url:"/fetch_data",
                    dataType: 'html',
                    method:"POST",
                    data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, brand:brand, ram:ram, storage:storage},
                    success:function(data){
                        $('.filter_data').html(data);
                    }
                });
            }
        
            function get_filter(class_name)
            {
                var filter = [];
                $('.'+class_name+':checked').each(function(){
                    filter.push($(this).val());
                });
                return filter;
            }
        
            $('.common_selector').click(function(){
                filter_data();
            });
        
            $('#price_range').slider({
                range:true,
                min:1000,
                max:65000,
                values:[1000, 65000],
                step:500,
                stop:function(event, ui)
                {
                    $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
                    $('#hidden_minimum_price').val(ui.values[0]);
                    $('#hidden_maximum_price').val(ui.values[1]);
                    filter_data();
                }
            });
        
        });
        </script> 
</body>
</html>