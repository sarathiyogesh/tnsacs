@extends("master")

@section('maincontent')

	<style type="text/css">
		.separatePageBox {
			display: none;
		}
	</style>
	<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<!--begin::Toolbar-->
		<div class="toolbar" id="kt_toolbar">
			<!--begin::Container-->
			<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
				<!--begin::Page title-->
				<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
					<!--begin::Title-->
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Add Note</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('/notes/manage')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Manage Notes</a>
				</div>
				<!--end::Actions-->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<div id="kt_content_container" class="container-xxl">
				
				<div class="card" id="kt_chat_messenger">
					<!--begin::Card header-->
					<div class="card-header pt-3" id="kt_chat_messenger_header">
						<!--begin::Title-->
						<div class="card-title">
							<!--begin::User-->
							<div class="d-flex justify-content-center flex-column me-3">
								<a href="#" class="fs-2 fw-bolder text-gray-900 text-hover-primary me-1 mb-1 lh-1">John Doe</a>
								<!--begin::Info-->
								<div class="mb-0 lh-1">
									<span class="fs-7 fw-bold text-muted">ABC Institution</span>
								</div>
								<!--end::Info-->
							</div>
							<!--end::User-->
						</div>
						<!--end::Title-->
					</div>
					<!--end::Card header-->
					<!--begin::Card body-->
					<div class="card-body" id="kt_chat_messenger_body">
						<!--begin::Messages-->
						<div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer" data-kt-scroll-wrappers="#kt_content, #kt_chat_messenger_body" data-kt-scroll-offset="5px" style="max-height: 446px;">
							<!--begin::Message(in)-->
							<div class="d-flex justify-content-start mb-10">
								<!--begin::Wrapper-->
								<div class="d-flex flex-column align-items-start">
									<!--begin::User-->
									<div class="d-flex align-items-center mb-2">
										<!--begin::Avatar-->
										<div class="symbol symbol-35px symbol-circle">
											<img alt="Pic" src="{!! URL::asset('media/300-1.jpg') !!}">
										</div>
										<!--end::Avatar-->
										<!--begin::Details-->
										<div class="ms-3">
											<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">Brian Cox</a>
											<span class="text-muted fs-7 mb-1">2 mins</span>
										</div>
										<!--end::Details-->
									</div>
									<!--end::User-->
									<!--begin::Text-->
									<div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">How likely are you to recommend our company to your friends and family ?</div>
									<!--end::Text-->
								</div>
								<!--end::Wrapper-->
							</div>
							<!--end::Message(in)-->
							<!--begin::Message(out)-->
							<div class="d-flex justify-content-end mb-10">
								<!--begin::Wrapper-->
								<div class="d-flex flex-column align-items-end">
									<!--begin::User-->
									<div class="d-flex align-items-center mb-2">
										<!--begin::Details-->
										<div class="me-3">
											<span class="text-muted fs-7 mb-1">5 mins</span>
											<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1">You</a>
										</div>
										<!--end::Details-->
										<!--begin::Avatar-->
										<div class="symbol symbol-35px symbol-circle">
											<img alt="Pic" src="{!! URL::asset('media/300-1.jpg') !!}">
										</div>
										<!--end::Avatar-->
									</div>
									<!--end::User-->
									<!--begin::Text-->
									<div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end" data-kt-element="message-text">Hey there, we’re just writing to let you know that you’ve been subscribed to a repository on GitHub.</div>
									<!--end::Text-->
								</div>
								<!--end::Wrapper-->
							</div>
							<!--end::Message(out)-->
							<!--begin::Message(in)-->
							<div class="d-flex justify-content-start mb-10">
								<!--begin::Wrapper-->
								<div class="d-flex flex-column align-items-start">
									<!--begin::User-->
									<div class="d-flex align-items-center mb-2">
										<!--begin::Avatar-->
										<div class="symbol symbol-35px symbol-circle">
											<img alt="Pic" src="{!! URL::asset('media/300-5.jpg') !!}">
										</div>
										<!--end::Avatar-->
										<!--begin::Details-->
										<div class="ms-3">
											<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">Brian Cox</a>
											<span class="text-muted fs-7 mb-1">1 Hour</span>
										</div>
										<!--end::Details-->
									</div>
									<!--end::User-->
									<!--begin::Text-->
									<div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">Ok, Understood!</div>
									<!--end::Text-->
								</div>
								<!--end::Wrapper-->
							</div>
							<!--end::Message(in)-->
							<!--begin::Message(out)-->
							<div class="d-flex justify-content-end mb-10">
								<!--begin::Wrapper-->
								<div class="d-flex flex-column align-items-end">
									<!--begin::User-->
									<div class="d-flex align-items-center mb-2">
										<!--begin::Details-->
										<div class="me-3">
											<span class="text-muted fs-7 mb-1">2 Hours</span>
											<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1">You</a>
										</div>
										<!--end::Details-->
										<!--begin::Avatar-->
										<div class="symbol symbol-35px symbol-circle">
											<img alt="Pic" src="{!! URL::asset('media/300-1.jpg') !!}">
										</div>
										<!--end::Avatar-->
									</div>
									<!--end::User-->
									<!--begin::Text-->
									<div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end" data-kt-element="message-text">You’ll receive notifications for all issues, pull requests!</div>
									<!--end::Text-->
								</div>
								<!--end::Wrapper-->
							</div>
							<!--end::Message(out)-->
							<!--begin::Message(in)-->
							<div class="d-flex justify-content-start mb-10">
								<!--begin::Wrapper-->
								<div class="d-flex flex-column align-items-start">
									<!--begin::User-->
									<div class="d-flex align-items-center mb-2">
										<!--begin::Avatar-->
										<div class="symbol symbol-35px symbol-circle">
											<img alt="Pic" src="{!! URL::asset('media/300-5.jpg') !!}">
										</div>
										<!--end::Avatar-->
										<!--begin::Details-->
										<div class="ms-3">
											<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">Brian Cox</a>
											<span class="text-muted fs-7 mb-1">3 Hours</span>
										</div>
										<!--end::Details-->
									</div>
									<!--end::User-->
									<!--begin::Text-->
									<div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">You can unwatch this repository immediately by clicking here:
									<a href="https://keenthemes.com">Keenthemes.com</a></div>
									<!--end::Text-->
								</div>
								<!--end::Wrapper-->
							</div>
							<!--end::Message(in)-->
							<!--begin::Message(out)-->
							<div class="d-flex justify-content-end mb-10">
								<!--begin::Wrapper-->
								<div class="d-flex flex-column align-items-end">
									<!--begin::User-->
									<div class="d-flex align-items-center mb-2">
										<!--begin::Details-->
										<div class="me-3">
											<span class="text-muted fs-7 mb-1">4 Hours</span>
											<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1">You</a>
										</div>
										<!--end::Details-->
										<!--begin::Avatar-->
										<div class="symbol symbol-35px symbol-circle">
											<img alt="Pic" src="{!! URL::asset('media/300-1.jpg') !!}">
										</div>
										<!--end::Avatar-->
									</div>
									<!--end::User-->
									<!--begin::Text-->
									<div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end" data-kt-element="message-text">Most purchased Business courses during this sale!</div>
									<!--end::Text-->
								</div>
								<!--end::Wrapper-->
							</div>
							<!--end::Message(out)-->
							<!--begin::Message(in)-->
							<div class="d-flex justify-content-start mb-10">
								<!--begin::Wrapper-->
								<div class="d-flex flex-column align-items-start">
									<!--begin::User-->
									<div class="d-flex align-items-center mb-2">
										<!--begin::Avatar-->
										<div class="symbol symbol-35px symbol-circle">
											<img alt="Pic" src="{!! URL::asset('media/300-5.jpg') !!}">
										</div>
										<!--end::Avatar-->
										<!--begin::Details-->
										<div class="ms-3">
											<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">Brian Cox</a>
											<span class="text-muted fs-7 mb-1">5 Hours</span>
										</div>
										<!--end::Details-->
									</div>
									<!--end::User-->
									<!--begin::Text-->
									<div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">Company BBQ to celebrate the last quater achievements and goals. Food and drinks provided</div>
									<!--end::Text-->
								</div>
								<!--end::Wrapper-->
							</div>
							<!--end::Message(in)-->
							<!--begin::Message(template for out)-->
							<div class="d-flex justify-content-end mb-10 d-none" data-kt-element="template-out">
								<!--begin::Wrapper-->
								<div class="d-flex flex-column align-items-end">
									<!--begin::User-->
									<div class="d-flex align-items-center mb-2">
										<!--begin::Details-->
										<div class="me-3">
											<span class="text-muted fs-7 mb-1">Just now</span>
											<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1">You</a>
										</div>
										<!--end::Details-->
										<!--begin::Avatar-->
										<div class="symbol symbol-35px symbol-circle">
											<img alt="Pic" src="{!! URL::asset('media/300-1.jpg') !!}">
										</div>
										<!--end::Avatar-->
									</div>
									<!--end::User-->
									<!--begin::Text-->
									<div class="p-5 rounded bg-light-primary text-dark fw-bold mw-lg-400px text-end" data-kt-element="message-text"></div>
									<!--end::Text-->
								</div>
								<!--end::Wrapper-->
							</div>
							<!--end::Message(template for out)-->
							<!--begin::Message(template for in)-->
							<div class="d-flex justify-content-start mb-10 d-none" data-kt-element="template-in">
								<!--begin::Wrapper-->
								<div class="d-flex flex-column align-items-start">
									<!--begin::User-->
									<div class="d-flex align-items-center mb-2">
										<!--begin::Avatar-->
										<div class="symbol symbol-35px symbol-circle">
											<img alt="Pic" src="{!! URL::asset('media/300-5.jpg') !!}">
										</div>
										<!--end::Avatar-->
										<!--begin::Details-->
										<div class="ms-3">
											<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">Brian Cox</a>
											<span class="text-muted fs-7 mb-1">Just now</span>
										</div>
										<!--end::Details-->
									</div>
									<!--end::User-->
									<!--begin::Text-->
									<div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">Right before vacation season we have the next Big Deal for you.</div>
									<!--end::Text-->
								</div>
								<!--end::Wrapper-->
							</div>
							<!--end::Message(template for in)-->
						</div>
						<!--end::Messages-->
					</div>
					<!--end::Card body-->
					<!--begin::Card footer-->
					<div class="card-footer pt-4" id="kt_chat_messenger_footer">
						<!--begin::Input-->
						<textarea class="form-control form-control-flush mb-3" rows="1" data-kt-element="input" placeholder="Type a message"></textarea>
						<!--end::Input-->
						<!--begin:Toolbar-->
						<div class="d-flex flex-stack">
							<!--begin::Actions-->
							<div class="d-flex align-items-center me-2">
								<button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" title="" data-bs-original-title="Attachment">
									<i class="bi bi-paperclip fs-3"></i>
								</button>
							</div>
							<!--end::Actions-->
							<!--begin::Send-->
							<button class="btn btn-primary" type="button" data-kt-element="send">Send</button>
							<!--end::Send-->
						</div>
						<!--end::Toolbar-->
					</div>
					<!--end::Card footer-->
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
	});

	$('#separatePage').on('change', function(){
		separatepagefunc();
	});

	separatepagefunc();
	function separatepagefunc(){
		v = $('#separatePage').val();
		$('.separatePageBox').hide();
		if(v == 'yes'){
			$('.separatePageBox').show();
		}
	}
</script>


@endsection