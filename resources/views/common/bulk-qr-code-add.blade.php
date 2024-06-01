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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Add Bulk QR Code</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('bulk-qr-codes')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Manage Bulk QR Codes</a>
				</div>
				<!--end::Actions-->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		{!! Helpers::displaymsg() !!}
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<div id="kt_content_container" class="container-xxl">
				<div class="card card-flush">
					<div class="card-body">

						<form action="{{url('/bulk-qr-codes/save')}}" method="POST">
							@csrf
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">QR Code</label>
										<input type="text" name="qr_code" class="form-control mb-2" placeholder="QR Code" value="{{old('qr_code')}}">
										@if($errors->has("qr_code"))
											<span id="qr_code-error" class="help-block">{!! $errors->first("qr_code") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Activities</label>
										<select name="activity_id" aria-label="Select Activity" data-control="select2" data-placeholder="Select an Option" id="activity_id" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select Activity</option>
											@foreach($activities as $activity)
												<option  value="{{ $activity->activity_id }}" @if(old('activity_id') == $activity->activity_id) selected="selected" @endif>{{$activity->activity_name}}</option>
											@endforeach
										</select>
										@if($errors->has("activity_id"))
											<span id="activity_id-error" class="help-block">{!! $errors->first("activity_id") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Activity Item</label>
										<select name="item_id" id="item_id" aria-label="Select Activity Item" data-placeholder="Select an Option" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select</option>
										</select>
										@if($errors->has("item_id"))
											<span id="item_id-error" class="help-block">{!! $errors->first("item_id") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Option ID</label>
										<select name="option_id" id="option_id" aria-label="Select Activity Item" data-placeholder="Select an Option" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select</option>
										</select>
										@if($errors->has("option_id"))
											<span id="option_id-error" class="help-block">{!! $errors->first("option_id") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Expiry Date</label>
										<input type="text" id="expiry_date" name="expiry_date" class="form-control mb-2" placeholder="Expiry Date" autocomplete="off" value="{{old('expiry_date')}}">
										@if($errors->has("expiry_date"))
											<span id="expiry_date-error" class="help-block">{!! $errors->first("expiry_date") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Status</label>
										<select name="status" aria-label="Select Status" data-placeholder="Select Status" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select Status</option>
											<option value="active">Active</option>
											<option value="inactive">Inactive</option>
										</select>
										@if($errors->has("status"))
											<span id="status-error" class="help-block">{!! $errors->first("status") !!}</span>
										@endif
									</div>
								</div>
							</div>
							<div class="d-flex justify-content-end py-6">
								<button type="reset" class="btn btn-light btn-active-light-primary me-2">Reset</button>
								<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save </button>
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
		$('#expiry_date').datepicker({
			format: 'dd-mm-yyyy'
		});

		$(document).on('change', '#activity_id', function(){
				getactivityitems();
				return false;
			});

			function getactivityitems(){
				var activity_id = $('#activity_id').val();
				$('#item_id').html('').html('<option value="">Select</option>');
				$('#option_id').html('').html('<option value="">Select</option>');
				$.ajax({
                    type: "GET",
                    url: "/bulk-qr-codes/items",
                    data: {id:activity_id},
                    dataType: "json",
                    success: function(data){
                        if(data.status=="success"){
                        	if(data.html != ''){
                        		$('#item_id').append(data.html);
                        	}
                        }else{
                        	alert(data.msg);
                        }
                        return false;
                    },
                    error: function(e){
                        console.log(e.responseText);
                        return false;
                    }
                });/* end of ajax */
			}

			function getitemoptions(){
				var item_id = $('#item_id').val();
				$('#option_id').html('').html('<option value="">Select</option>');
				$.ajax({
                    type: "GET",
                    url: "/bulk-qr-codes/items/options",
                    data: {id:item_id},
                    dataType: "json",
                    success: function(data){
                        if(data.status=="success"){
                        	if(data.html != ''){
                        		$('#option_id').append(data.html);
                        	}
                        }else{
                        	alert(data.msg);
                        }
                        return false;
                    },
                    error: function(e){
                        console.log(e.responseText);
                        return false;
                    }
                });/* end of ajax */
			}


			$(document).on('change', '#item_id', function(){
				getitemoptions();
				return false;
			});
	});
</script>


@endsection