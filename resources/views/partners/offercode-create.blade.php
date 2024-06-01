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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Add Partner Offer</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('partner/offercode/manage')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Manage Partner Offer</a>
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

						<form action="{{url('/partner/offercode/create')}}" method="POST">
							@csrf
							<div class="row">

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Type</label>
										<select name="partner" id="partner" aria-label="Select" data-control="select2" data-placeholder="Select" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select</option>
												@foreach($partners as $par)
												<option data-type="{{$par->offer_type}}" value="{{$par->id}}" <?php if(old('partner') == $par->id){ echo 'selected'; } ?>>{{$par->partner_name}} ({{$par->offer_type=='bank'?'BIN':'Code'}})</option>
												@endforeach
										</select>
										@if($errors->has("partner"))
											<span id="partner-error" class="help-block">{!! $errors->first("partner") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6" id="singleCodeBox">
									<div class="form-group">
										<label class="required form-label">BIN/Code</label>
										<input type="text" name="offerCode" class="form-control mb-2" placeholder="Partner Name" value="{{old('offerCode')}}">
										@if($errors->has("offerCode"))
											<span id="name-error" class="help-block">{!! $errors->first("offerCode") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6" id="cardTypeBox" style="display:none;">
									<div class="form-group">
										<label class="required form-label">Card Type</label>
										<input type="text" name="cardType" class="form-control mb-2" placeholder="Card Type" value="{{old('cardType')}}">
										@if($errors->has("cardType"))
											<span id="name-error" class="help-block">{!! $errors->first("cardType") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6" id="isBulkCodeBox" style="display:none;">
									<div class="form-group">
										<label class="required form-label">Bulk count</label>
										<select id="bulkCount" name="bulkCount" class="form-control">
											@for($i=1; $i<=10; $i++)
												<option value="{{$i*50}}">{{$i*50}}</option>
											@endfor
										</select>
										@if($errors->has("bulkCount"))
											<span id="name-error" class="help-block">{!! $errors->first("bulkCount") !!}</span>
										@endif
									</div>
								</div>
								
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Type</label>
										<select id="status" name="status" class="form-control">
											<option value="1" <?php if(old('status') == '1'){ echo 'selected'; } ?>>Active</option>
											<option value="0" <?php if(old('status') == '0'){ echo 'selected'; } ?>>Inactive</option>
										</select>
										@if($errors->has("status"))
											<span id="status-error" class="help-block">{!! $errors->first("status") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label">Generate random code/bin</label>
										<input type="checkbox" id="isBulkCode" name="isBulkCode" value="yes">
										@if($errors->has("isBulkCode"))
											<span id="isBulkCode-error" class="help-block">{!! $errors->first("isBulkCode") !!}</span>
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
		$('#dob').datepicker({
			format: 'dd-mm-yyyy'
		});

		$('#isBulkCode').on('click', function(){
			$('#isBulkCodeBox').hide();
			$('#singleCodeBox').hide();
			if($(this).prop('checked') == true){
				$('#isBulkCodeBox').show();
				$('#offerCode').val('1');
			}else{
				$('#singleCodeBox').show();
				$('#offerCode').val('');
			}
		});

		checkifbankoption();
		function checkifbankoption(){
			$('#cardTypeBox').hide();
			var cv = $('#partner').find(':selected').attr('data-type');
			console.log(cv);
			if(cv == 'bank'){
				$('#cardTypeBox').show();
			}
		}
		$('#partner').on('change', function(){
			checkifbankoption();
		});
	});
</script>


@endsection