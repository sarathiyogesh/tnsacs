@extends("master")

@section('maincontent')
	<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<!--begin::Toolbar-->
		<div class="toolbar" id="kt_toolbar">
			<!--begin::Container-->
			<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
				<!--begin::Page title-->
				<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
					<!--begin::Title-->
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Edit Coupon</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('coupons')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Manage Coupons</a>
				</div>
				<!--end::Actions-->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		<div class="alert alert-success showSuccess" style="display:none;"></div>
		<div class="alert alert-danger errorMsg-show" style="display:none;" ></div>
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<div id="kt_content_container" class="container-xxl">
				<div class="card card-flush">
					<div class="card-body">

						<form id="couponForm" >
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">All Activity</label>
										<select name="applied_to" aria-label="Select " data-control="select2" data-placeholder="Select " class="form-select form-select-solid form-select-lg fw-bold" id="applied_to">
											<option value="single" @if($record->applied_to == 'single') selected="selected" @endif >No</option>
											<option value="all" @if($record->applied_to == 'all') selected="selected" @endif>Yes</option>
										</select>
										@if($errors->has("applied_to"))
											<span id="applied_to-error" class="help-block">{!! $errors->first("applied_to") !!}</span>
										@endif
									</div>
								</div>
								<br>
								    <?php $i = 1; ?>
								    @foreach($items as $it)
									    <div class="row d-flex align-items-center CouponDiv">
											<div class="col-md-4 selectActivity">
												<div class="form-group">
													<label class="required form-label">Activities</label>
													<select name="activity" aria-label="Select Activity"  data-placeholder="Select Activity" class="form-select form-select-solid form-select-lg fw-bold activities" id="activity">
														<option value="" selected>Select Activity</option>
														@foreach($activities as $act)
															<option value="{{$act->activity_id}}" @if($it['activity'] == $act->activity_id) selected="selected" @endif >{{$act->activity_name}}</option>
														@endforeach
													</select>
													@if($errors->has("activity"))
														<span id="activity-error" class="help-block">{!! $errors->first("activity") !!}</span>
													@endif
												</div>
											</div>

											<div class="col-md-3">
												<div class="form-group">
													<label class="required form-label">Coupon Type</label>
													<select name="coupon_type" aria-label="Select "  data-placeholder="Select " class="form-select form-select-solid form-select-lg fw-bold coupontype" id="coupon_type">
														<option value="">Select</option>
														<option value="amount" @if($it['coupon_type'] == "amount") selected="selected" @endif>Amount</option>
														<option value="percentage"@if($it['coupon_type'] == "percentage") selected="selected" @endif >Percentage</option>
														<option value="special" @if($it['coupon_type'] == "special") selected="selected" @endif>Second Price</option>
													</select>
													@if($errors->has("coupontype"))
														<span id="coupontype-error" class="help-block">{!! $errors->first("coupontype") !!}</span>
													@endif
												</div>
											</div>

											<div class="col-md-3 couponTypeTextDiv">
												<div class="form-group">
													<label class="required form-label couponTypeText" id="coupon_valuelabel">{{ucfirst($it['coupon_type'])}}</label>
													<input type="text" name="coupon_value" class="form-control mb-2 couponvalue" placeholder="" id="coupon_value" value="{{$it['coupon_value']}}" >
													@if($errors->has("coupon_value"))
														<span id="coupon_value-error" class="help-block">{!! $errors->first("coupon_value") !!}</span>
													@endif
												</div>
											</div>
											<div class="col-sm-2">
												<a href="javascript:;" class="btn btn-primary btn-xs addActivitiesBtn"><i class="las la-plus"></i> Add</a>&nbsp;
												<a href="javascript:;" style="display:none;" class="btn btn-primary btn-xs deleteService"><i class="las la-minus"></i> Delete</a>&nbsp;
												
											</div>

										</div>
									@endforeach
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Coupon Name</label>
										<input type="text" name="couponname" class="form-control mb-2" placeholder="Coupon Name" value="{{$record['couponname']}}" id="couponname">
										@if($errors->has("couponname"))
											<span id="couponname-error" class="help-block">{!! $errors->first("couponname") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Coupon Code</label>
										<input type="text" name="couponcode" class="form-control mb-2" placeholder="Coupon Code" value="{{$record['couponcode']}}" id="couponcode">
										@if($errors->has("couponcode"))
											<span id="couponcode-error" class="help-block">{!! $errors->first("couponcode") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Start Date</label>
										<input type="text" name="startdate" id="startdate" class="form-control mb-2" placeholder="Start Date" value="{{date('Y-m-d', strtotime($record['startdate']))}}" autocomplete="off">
										@if($errors->has("startdate"))
											<span id="startdate-error" class="help-block">{!! $errors->first("startdate") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">End Date</label>
										<input type="text" name="enddate" id="enddate" class="form-control mb-2" placeholder="End Date" value="{{date('Y-m-d', strtotime($record['enddate']))}}" autocomplete="off">
										@if($errors->has("enddate"))
											<span id="enddate-error" class="help-block">{!! $errors->first("enddate") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Minimum Order Amount</label>
										<input type="text" name="minimumamount" class="form-control mb-2" placeholder="Minimum Order Amount" value="{{$record['minimumamount']}}" id="minimumamount">
										@if($errors->has("minimumamount"))
											<span id="minimumamount-error" class="help-block">{!! $errors->first("minimumamount") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class=" form-label">Total Coupon</label>
										<input type="text" name="totalcoupon" class="form-control mb-2" placeholder="Total Coupon" value="{{$record['totalcoupon']}}" id="totalcoupon">
										@if($errors->has("totalcoupon"))
											<span id="totalcoupon-error" class="help-block">{!! $errors->first("totalcoupon") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class=" form-label">Uses Per Customer</label>
										<input type="text" name="usespercustomer" class="form-control mb-2" placeholder="Uses Per Customer" value="{{$record['usespercustomer']}}" id="usespercustomer">
										@if($errors->has("usespercustomer"))
											<span id="usespercustomer-error" class="help-block">{!! $errors->first("usespercustomer") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Status</label>
										<select name="status" aria-label="Select Status" data-control="select2" data-placeholder="Select Status" class="form-select form-select-solid form-select-lg fw-bold" id="status">
											<option value="">Select Status</option>
											<option value="active" @if($record['status'] == 'active') selected="selected" @endif>Active</option>
											<option value="inactive" @if($record['status'] == 'inactive') selected="selected" @endif>Inactive</option>
										</select>
										@if($errors->has("status"))
											<span id="status-error" class="help-block">{!! $errors->first("status") !!}</span>
										@endif
									</div>
								</div>

								
							</div>
							<div class="d-flex justify-content-end py-6">
								<button type="reset" class="btn btn-light btn-active-light-primary me-2">Reset</button>
								<button type="button" class="btn btn-primary saveBtn" id="kt_account_profile_details_submit">Save </button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!--end::Post-->
	</div>
	<!--end::Content-->
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#startdate').datepicker({
			format: 'dd-mm-yyyy'
		});

		$('#enddate').datepicker({
			format: 'dd-mm-yyyy'
		});
		activityChange();

		function activityChange(){
			if($('#applied_to').val() == 'all'){
				$('.selectActivity').hide();
				$('.addActivitiesBtn').hide();
				$("div.CouponDiv:not(:first)").hide();
				var value = $('#coupon_valuelabel').text().toLowerCase();
				// alert(value);
				$('#coupon_type').val(value).change();
			}else{
				$('.selectActivity').show();
				$('.addActivitiesBtn').show();
				$("div.CouponDiv").show();
			}

		}

		$(document).on('change', '.coupontype', function(){
			var coupontype = $(this).closest(".coupontype").val()
			if( coupontype == 'amount'){
				$(this).closest('.CouponDiv').find('.couponTypeTextDiv').show();
				$(this).closest('.CouponDiv').find('.couponTypeText').text('Amount');
			}else if(coupontype == 'percentage'){
				$(this).closest('.CouponDiv').find('.couponTypeTextDiv').show();
				$(this).closest('.CouponDiv').find('.couponTypeText').text('Percentage');
			}else{
				$(this).closest('.CouponDiv').find('.couponTypeTextDiv').hide();
			}
		});
		

		$(document).on('change', '#applied_to', function(){
			activityChange();
		});

		function clonecoupon(){
			$(".addActivitiesBtn").hide();
			$(".deleteService").hide();
			var length = $('.CouponDiv').length;
			if(length > 1)  {
				$(".deleteService").show();
			}
			$(".addActivitiesBtn:last").show();

		}


		$(document).on('click', '.addActivitiesBtn', function(){
			$('.CouponDiv:first').clone().insertAfter('.CouponDiv:last');
			$('.CouponDiv:last').find("input[type='text']").val('');
			clonecoupon();
			return false;
		});

		$(document).on('click', '.deleteService', function(){
	       $(this).closest(".CouponDiv").remove();
	       clonecoupon();
	       return false;
	    });

	    $(document).on('click', '.saveBtn', function(){
	    	var applied_to = $('#applied_to').val();
	    	$('.validationError').remove();
	    	
		    
		    var coupon_type = [];
		    var activity = [];
		    var coupon_value = [];
		    if(applied_to == 'single'){
			    $('.coupontype').each(function(){
			        var type = $(this).val();
			        coupon_type.push(type);
			    });

			    $('.activities').each(function(){
			        var data = $(this).val();
			        activity.push(data);
			    });

			    $('.couponvalue').each(function(){
			        var type = $(this).val();
			        coupon_value.push(type);
			    });
			}else{
				var type = $('#coupon_type').val();
				coupon_type.push(type);

				var activity_type = $('#activity').val();
				activity.push(activity_type);

				var coup_value = $('#coupon_value').val();
				coupon_value.push(coup_value);
			}

			// alert(coupon_type+' '+activity+' '+coupon_value);
			// return false;
 
			var couponname = $('#couponname').val();
			var couponcode = $('#couponcode').val();
			var startdate = $('#startdate').val();
			var enddate = $('#enddate').val();
			var minimumamount = $('#minimumamount').val();
			var totalcoupon = $('#totalcoupon').val();
			var usespercustomer = $('#usespercustomer').val();
			var status = $('#status').val();

			var id = "{{ $record->couponcode }}";
			var t_id = '{{ $record->id }}';
			var url = "coupons/"+couponcode+'/edit';

			$.ajax({
                url: "{{url('coupons/'.$record->couponcode)}}",
                data: {activity:activity, coupon_type: coupon_type, coupon_value:coupon_value, applied_to:applied_to, couponname:couponname, couponcode:couponcode,startdate : startdate, enddate:enddate, minimumamount:minimumamount, totalcoupon:totalcoupon, usespercustomer:usespercustomer, status : status, id:id, t_id:t_id},
                type: 'PATCH',
                headers: {'X-CSRF-Token': $('meta[name="_token"]').attr('content'),},
                dataType: 'json',
                success: function(res){
                    if(res.status == 'success'){
                    	if(applied_to == 'all'){
                    		window.location.href = res.url;
                    		return false;
                    	}
                    	$('.showSuccess').html(res.message).show();
                    }else if(res.status == 'validation'){
			        	var array = res.message;
			        	$.each(array, function(k,v){
			        		$('#'+k).after('<span class="text-danger validationError" >'+v[0]+'</span>');
			        	});
			        }else if(res.status == 'error'){
                        $('.errorMsg-show').html(res.message).show();
                        
                    }
                    return false;
                },error: function(e){
                    console.log(e.responseText);
                    return false;
                }
            });
            return false;


	    });


	});
</script>


@endsection