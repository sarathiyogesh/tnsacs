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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Add FAQ</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('faqs')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Manage FAQ</a>
				</div>
				<!--end::Actions-->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<div id="kt_content_container" class="container-xxl">
				{!! Helpers::displaymsg() !!}
				<div class="card card-flush">
					<div class="card-body">

						<form action="{{route('faq.save')}}" method="POST">
							@csrf
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Question</label>
										<input type="text" name="question" class="form-control mb-2" placeholder="Question" value="{{old('question')}}">
										@if($errors->has("question"))
											<span id="name-error" class="help-block">{!! $errors->first("question") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Answer</label>
										<textarea class="form-control mb-2"  name="answer">{{old('answer')}}</textarea>
										@if($errors->has("answer"))
											<span id="answer-error" class="help-block">{!! $errors->first("answer") !!}</span>
										@endif
									</div>
									<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Status</label>
										<select class="form-control mb-2"  name="status">
											<option value="">select</option>
											<option value="active" @if(old('status', 'active') == 'active') selected @endif>Active</option>
											<option value="inactive" @if(old('status') == 'inactive') selected @endif >Inactive</option>
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

@if(old('status', 'active') == 'active') selected @endif


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
	});
</script>


@endsection