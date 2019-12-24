@extends('site/layouts/siteLayout')

@section('header')
  <link rel="stylesheet" type="text/css" href="{{ url('slick/slick/slick.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('slick/slick/slick-theme.css') }}">

  <link rel="stylesheet" href="{{ url('css/flipclock.css') }}">
  <script src="{{ url('js/flipclock.js') }}"></script>
@endsection

@section('content')

<div class="container">
	<div class="row" style="margin-top:20px ; background:white ; height: 470px;">

		<div class="col-sm-4">
			<img src="{{ url('upload').'/'.$product->ProductImage[0]->url }}" 
				 data-zoom-image="{{ url('upload').'/'.$product->ProductImage[0]->url }}"
				 class="product_img"
				 id="product_img">

			<div>
				<?php $key; ?>
				@foreach($product->ProductImage as $key=>$item)

					@if($key < 3)
						<?php $imgLink = url('upload').'/'.$item->url ?>
						<div class="otherProductImages">
							<img src="{{ url('upload').'/'.$item->url }}"
								 onclick="imgToShow('{{ $imgLink }}')">
						</div>

					@else
						<div class="otherProductImages">
							<div onclick="imgToShow('{{ $imgLink }}')">
								...
							</div>
						</div>
						@break

					@endif

				@endforeach
			</div>
		</div>

		
		<div class="col-sm-8">
			<div id="imgZoom" class="imgZoom"></div>

			<div class="row product_title">
				<div class="col-sm-10">				
					<div class="">
						<h4> {{ $product->title }} </h4>
						<p> {{ $product->code }} </p>
					</div>
				</div>

				<div class="col-sm-2">				
					<div class="rating">
						<div class="gray">

							<!--
								rated stars should be 'width'ed within the inline 'style' 
								why? value is caluclated using php and changing value is 
									 possible.
							-->
							<div class="activate_stars" style="width: 70%">	
							</div>	

						</div>
					</div>

					<p class="vote"> از 10 رای </p>
				</div>

		    </div>

		    @if($product->product_status == 1)

			    <?php
			    	$color_count = $product->color_product_frontend;
			    ?>
			    @if(sizeof($color_count) > 0)

					<div class="">
					 	<div class="row product_colors_list">

					    	@foreach($product->color_product_frontend as $key=>$item)


					    		<div class="col-sm-2 color_area list-group panel">
									<a class="list-group-item color_a" style="cursor:pointer">

										<input type="text" id="color"
										class="jscolor {valueElement:null,value:'{{ $item->color_code }}'} colorStyle form-control"
										value="" disabled>

									</a>
								</div>

					    		<div class="col-sm-10">
								</div>


							@endforeach


						</div>
					</div>

				@endif
		    @endif

		</div>
	</div>
</div>


@endsection

@section('footer')

    <script type="text/javascript" src="{{ url('js/jscolor.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/jquery.elevateZoom-3.0.8.min.js') }}"></script>


    <script type="text/javascript">

    	// Changing 'background-color' of the selected product-color (29767380)
    	$('.list-group').on('click','> a', function(e) {
		   var $this = $(this);
		    $('.list-group').find('.active').removeClass('active');
		    $this.addClass('active');
		});

    	// Preventing href="#" Going to Top of Page (13003044)
		$('.color_a').click(function(e) {
		    e.preventDefault();
		});

		// Zoom on img
		$("#product_img").elevateZoom({
			zoomWindowPosition:'imgZoom',
			borderSize:1,
			scrollZoom:true,
			cursor:'zoom-in',
			/*zoomWindowWidth:100,
			zoomWindowHeight:100,
			zoomLevel:0.5*/
		});


		// Changing img+ZoomedImg when clicked on thumbnails
		imgToShow = function(img)
		{
			var imageElement = $('#product_img');
			imageElement.attr('src', img);

			// 19110330 - 31910882
			var prev_img = document.getElementById("product_img").src;
			var ez = $("#product_img").data("elevateZoom");
			ez.swaptheimage(prev_img, img);
		}

    </script>

@endsection