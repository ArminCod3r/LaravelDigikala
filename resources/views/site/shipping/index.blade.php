@extends('site/layouts/siteLayout')

@section('header')
	<meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

@endsection

@section('content')

<div class="shipping-steps">

	<div class="shipping-steps-dash">
		<div style="margin-right: 25px"></div>
		<div></div>
		<div></div>
		<div></div>
	</div>

	<div class="bullet green tick">
		<span>ورود به دیجی کالا</span>
	</div>

	<div class="shipping-line green-line"></div>


	<div class="bullet green">
		<span>بررسی سفارش</span>
	</div>

	<div class="shipping-line gray-line"></div>

	<div class="bullet grey">
		<span>اطلاعات ارسال</span>
	</div>

	<div class="shipping-line gray-line"></div>

	<div class="bullet grey">
		<span>اطلاعات پرداخت</span>
	</div>

	<div class="shipping-steps-dash-gray">
		<div style="margin-right: 10px"></div>
		<div></div>
		<div></div>
		<div></div>
	</div>
	
</div>

<div style="position: absolute;">
	<br/>
	<br/>
</div>

<div class="shipping-address">

	<div class="add-address">
		<span>آدرس: </span>

		<a href="#" class="btn btn-primary" onclick="add_address()" data-target="#myAddress">
			<i class="fa fa-plus"></i> 
            <span style="font-size: 16px">افزودن آدرس </span>
        </a>
	</div>


</div>



<div class="container">

  <!-- Modal -->
  <div class="modal fade" id="myAddress" role="dialog" style="background-color:transparent !important">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">

        <div class="modal-header"  style="direction: ltr">
          <button type="button" class="close" data-dismiss="modal"></button>
          <h5 class="modal-title" >آدرس</h5>
        </div>

        <div class="modal-body">


          	<form action="#" onsubmit="address_submit() ; return false;" method="POST" accept-charset="utf-8" enctype="multipart/form-data" id="address_form" >
					{{ csrf_field() }}

	        	<label>نام و نام خانوادگی</label>
	        	<input type="text" class="form-control" name="username" id="username" value="{{ old('username') }}" />
	        	<span style="color: red;" id="username_error"></span>


	        	<div class="newAddressModal">
	        		<div>
	        			<div> انتخاب استان و شهر:</div>
		        	<select onchange="state_changed()" name="state" id="state_list" class="form-control newAddressInputs">
					 	<option value="">استان</option>

					 	@if(sizeof($states) > 0)
							@foreach($states as $key_state=>$value_state)
								<option value="{{$value_state->id}}">{{$value_state->name}}</option>
							@endforeach
						@else
							nothing in here
						@endif
					</select>
	        		</div>

					<div>
					<select id="cities_list" class="form-control newAddressInputs" name="city">
					 	<option value="">شهر</option>
					</select>
					</div>

					<span style="color: red;" id="state_error"></span>

					<span style="color:red; margin-right:28%;" id="city_error"></span>

	        	</div>

	        	<br/>

				<div class="newAddressInputs">
					<div> تلفن ثابت</div>
	        		<input type="text" class="form-control" name="telephone" id="telephone" value="{{ old('telephone') }}" />
	        		<span style="color: red;" id="telephone_error"></span>
				</div>

	        	<div class="newAddressInputs">
	        		<div> کد شهر </div>
	        		<input type="text" class="form-control" name="city_code" id="city_code" value="{{ old('city_code') }}" />
	        		<span style="color: red;" id="city_code_error"></span>
	        	</div>

				<div class="newAddressInputs">
					<div> شماره موبایل</div>
	        		<input type="text" class="form-control" name="mobile" id="mobile" value="{{ old('mobile') }}" />
	        		<span style="color: red;" id="mobile_error"></span>
				</div>

	        	<div class="newAddressInputs">
	        		<div> کد پستی </div>
	        		<input type="text" class="form-control" name="postalCode" id="postalCode" value="{{ old('postalCode') }}" />
	        		<span style="color: red;" id="postalCode_error"></span>
	        	</div>

	        	<div style="margin: 10px 0px 10px 0px"></div>

	        	<div class="newAddressTextArea">
	        		<div> آدرس </div>
	        		<textarea class="form-control" name="address" id="address" value="{{ old('address') }}" > </textarea>
	        		<span style="color: red;" id="address_error"></span>
	        	</div>

	        	<input type="submit" class="btn btn-success newAddrSubmit" value="ثبت" />
			</form>

    	</div>

      </div>      
    </div>
  </div>
  
</div>



@endsection

@section('footer')

<script type="text/javascript">

	add_address = function()
	{
		$('#myAddress').modal('show');
	}

	<?php $url= url('shipping/ajax_view_cities'); ?>
	state_changed = function()
	{
		state = document.getElementById("state_list").value;
		
		$.ajaxSetup(
		    			{
		    				'headers':
		    				{
		    					'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		    				}
		    			}
					);
		
		$.ajax(
	    		{

	    		'url': '{{ $url }}',
	    		'type': 'post',
	    		'data': 'state='+state,
	    		success:function(data){

	    			data = JSON.parse(data);

	    			var generat_options = "";

	    			for (var i = 0; i < data.length; i++)
	    			{
	    				generat_options = '<option value="'+data[i]["id"]+'">'+
	    							  	  data[i]["name"]+
	    							  	  '</option>';

	    				$("#cities_list").html(generat_options);
	    			}

	    			if(data.length == 0)
	    			{
	    				generat_options = '<option value="">شهر</option>';
	    				$("#cities_list").html(generat_options);
	    			}
	    		}

	    		}
		  );
	}

	<?php $url= url('shipping/storeAddress'); ?>
	address_submit = function()
	{
		var form_data = $("#address_form").serialize();

		$.ajaxSetup(
		    			{
		    				'headers':
		    				{
		    					'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		    				}
		    			}
					);
		
		$.ajax(
	    		{

	    		'url': '{{ $url }}',
	    		'type': 'post',
	    		'data': 'form_data='+form_data,
	    		success:function(data){

	    			clear_errors();

	    			var data = Object.entries(data);

	    			data.forEach(([key, value]) => {
					  $("#"+key+"_error").html(value);
					});
	    		}

	    		}
		  );
	}



	function clear_errors()
	{
		var error_fields = ['username','state','city','telephone','city_code','mobile','postalCode','address'];

		for (var i = 0; i < error_fields.length; i++)
		{
			$("#"+error_fields[i]+"_error").html(" ");
		}
	}

</script>

@endsection