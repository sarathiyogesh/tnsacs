<?php 
	use App\Models\Coursenotes;
	use App\Models\User;
?>
@foreach($notelist as $list)
@if($list->msg_type == 'receiver')
<!--begin::Message(in)-->
<div class="d-flex justify-content-start mb-10">
	<!--begin::Wrapper-->
	<div class="d-flex flex-column align-items-start">
		<!--begin::User-->
		<div class="d-flex align-items-center mb-2">
			<!--begin::Avatar-->
			<div class="symbol symbol-35px symbol-circle">
			<div class="symbol symbol-35px symbol-circle">
				<img alt="Pic" src="{!! URL::asset('media/300-1.jpg') !!}">
			</div>
			<!--end::Avatar-->
			<!--begin::Details-->
			<div class="ms-3">
				<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">{{$list->msg_from}}</a>
				<span class="text-muted fs-7 mb-1">{{Coursenotes::gettimeago($list->created_at)}}</span>
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
@endif
@if($list->msg_type == 'sender')
<!--begin::Message(out)-->
<div class="d-flex justify-content-end mb-10">
	<!--begin::Wrapper-->
	<div class="d-flex flex-column align-items-end">
		<!--begin::User-->
		<div class="d-flex align-items-center mb-2">
			<!--begin::Details-->
			<div class="me-3">
				<span class="text-muted fs-7 mb-1">{{Coursenotes::gettimeago($list->created_at)}}</span>
				<a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary ms-1">{{ User::getName($list->msg_from)}}</a>
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
		<div class="p-5 rounded bg-light-primary fw-bold mw-lg-400px text-end" data-kt-element="message-text">{!! $list->notes !!}</div>
		<!--end::Text-->
	</div>
	<!--end::Wrapper-->
</div>
<!--end::Message(out)-->
@endif
@endforeach