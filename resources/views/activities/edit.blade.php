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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Edit Activity</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('activities')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Manage Activities</a>
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

						<form action="{{url('/activities/update')}}" method="POST">
							@csrf
							<input type="hidden" name="activity_id" value="{{$activityInfo->activity_id}}">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Name</label>
										<input type="text" name="activity_name" class="form-control mb-2" placeholder="name" value="{{$activityInfo->activity_name}}">
										@if($errors->has("name"))
											<span id="name-error" class="help-block">{!! $errors->first("name") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Category</label>
										<select name="categories[]" multiple aria-label="Select Category" data-control="select2" data-placeholder="Select Category" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select Category</option>
											@foreach($categories as $cat)
												<option  value="{{$cat->id}}" @if(in_array($cat->id, $activityInfo['categories'])) selected="selected" @endif>{{$cat->name}}</option>
											@endforeach
										</select>
										@if($errors->has("categories"))
											<span id="categories-error" class="help-block">{!! $errors->first("categories") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Tags</label>
										<select name="tags[]" multiple aria-label="Select Tag" data-control="select2" data-placeholder="Select Tag" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select Tags</option>
											@foreach($tags as $tag)
												<option  value="{{$tag->id}}" @if(in_array($tag->id, $activityInfo['tags'])) selected="selected" @endif>{{$tag->name}}</option>
											@endforeach
										</select>
										@if($errors->has("tags"))
											<span id="tags-error" class="help-block">{!! $errors->first("tags") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Country</label>
										<select name="country_code" aria-label="Select Country" data-control="select2" data-placeholder="Select Country" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select Country</option>
											@foreach($countries as $rec)
												<option  value="{{$rec->country_code}}" @if($activityInfo->country_code == $rec->country_code) selected="selected" @endif>{{$rec->country_name}}</option>
											@endforeach
										</select>
										@if($errors->has("country_code"))
											<span id="country_code-error" class="help-block">{!! $errors->first("country_code") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">City</label>
										<select name="activity_city" aria-label="Select City" data-control="select2" data-placeholder="Select City" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select City</option>
											@foreach($cities as $rec)
												<option  value="{{$rec->id}}" @if($activityInfo->activity_city == $rec->id) selected="selected" @endif>{{$rec->name}}</option>
											@endforeach
										</select>
										@if($errors->has("activity_city"))
											<span id="activity_city-error" class="help-block">{!! $errors->first("activity_city") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Zone</label>
										<input type="text" name="activity_zone" class="form-control mb-2" placeholder="Zone" value="{{$activityInfo->activity_zone}}">
										@if($errors->has("activity_zone"))
											<span id="activity_zone-error" class="help-block">{!! $errors->first("activity_zone") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Address</label>
										<textarea  name="activity_address" class="form-control mb-2" placeholder="Zone">
											{{ $activityInfo->activity_address }}
										</textarea>
										@if($errors->has("activity_address"))
											<span id="activity_address-error" class="help-block">{!! $errors->first("activity_address") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Status</label>
										<select name="activity_status" aria-label="Select Status" data-placeholder="Select Status" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select Status</option>
											<option  value="active" @if($activityInfo->activity_status == 'active') selected="selected" @endif>Active</option>
											<option  value="hide" @if($activityInfo->activity_status == 'hide') selected="selected" @endif>Hide</option>
											<option  value="inactive" @if($activityInfo->activity_status == 'inactive') selected="selected" @endif>Inactive</option>
										</select>
										@if($errors->has("activity_status"))
											<span id="activity_status-error" class="help-block">{!! $errors->first("activity_status") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Location</label>
										<input type="text" name="searchLocation" id="searchLocation" class="form-control mb-2" placeholder="Search...">
										<div id="map" style="width: 100%; height: 300px; margin-top: 15px"></div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Ticket Source</label>
										<select name="ticket_source" aria-label="Select Ticket Source" data-placeholder="Select Ticket Source" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select Ticket Source</option>
											<option  value="a" @if($activityInfo->ticket_source == 'a') selected="selected" @endif>Rayna API</option>
											<option  value="ph" @if($activityInfo->ticket_source == 'ph') selected="selected" @endif>Priohub</option>
											<option  value="m" @if($activityInfo->ticket_source == 'm') selected="selected" @endif>Manual Ticketing</option>
										</select>
										@if($errors->has("ticket_source"))
											<span id="ticket_source-error" class="help-block">{!! $errors->first("ticket_source") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Timeslot</label>
										<select name="timeslot" aria-label="Select Timeslot" data-placeholder="Select Timeslot" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select timeslot</option>
											<option  value="enable" @if($activityInfo->api_timeslot == 'enable') selected="selected" @endif>Enable</option>
											<option  value="disable" @if($activityInfo->api_timeslot == 'disable') selected="selected" @endif>Disable</option>
										</select>
										@if($errors->has("api_timeslot"))
											<span id="api_timeslot-error" class="help-block">{!! $errors->first("api_timeslot") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6 raynaApiFields">
									<div class="form-group">
										<label class="required form-label">API Tour ID</label>
										<input type="text" name="api_tour_id" class="form-control mb-2" placeholder="Zone" value="{{$activityInfo->api_tour_id}}">
										@if($errors->has("api_tour_id"))
											<span id="api_tour_id-error" class="help-block">{!! $errors->first("api_tour_id") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6 raynaApiFields">
									<div class="form-group">
										<label class="required form-label">API Contract ID</label>
										<input type="text" name="api_contract_id" class="form-control mb-2" placeholder="Zone" value="{{$activityInfo->api_contract_id}}">
										@if($errors->has("api_contract_id"))
											<span id="api_contract_id-error" class="help-block">{!! $errors->first("api_contract_id") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Regular Price</label>
										<input type="text" name="regular_price" class="form-control mb-2" placeholder="Zone" value="{{$activityInfo->regular_price}}">
										@if($errors->has("regular_price"))
											<span id="regular_price-error" class="help-block">{!! $errors->first("regular_price") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Discount Price</label>
										<input type="text" name="discount_price" class="form-control mb-2" placeholder="Zone" value="{{$activityInfo->discount_price}}">
										@if($errors->has("discount_price"))
											<span id="discount_price-error" class="help-block">{!! $errors->first("discount_price") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Corporate Discount Price</label>
										<input type="text" name="corporate_discount_price" class="form-control mb-2" placeholder="Zone" value="{{$activityInfo->corporate_discount_price}}">
										@if($errors->has("corporate_discount_price"))
											<span id="corporate_discount_price-error" class="help-block">{!! $errors->first("corporate_discount_price") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Saving Text</label>
										<input type="text" name="saving_text" class="form-control mb-2" placeholder="Zone" value="{{$activityInfo->saving_text}}">
										@if($errors->has("saving_text"))
											<span id="saving_text-error" class="help-block">{!! $errors->first("saving_text") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Activity Tag</label>
										<select name="activity_tag" aria-label="Select Activity Tag" data-placeholder="Select Activity Tag" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select Activity Tag</option>
											@foreach($activity_tags as $rec)
												<option  value="enable" @if($rec->id == $activityInfo->activity_tag) selected="selected" @endif>Enable</option>
											@endforeach
										</select>
										@if($errors->has("activity_tag"))
											<span id="activity_tag-error" class="help-block">{!! $errors->first("activity_tag") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Experience booking starting from (days)</label>
										<input type="text" name="starting_days" class="form-control mb-2" placeholder="Zone" value="{{$activityInfo->starting_days}}">
										@if($errors->has("starting_days"))
											<span id="starting_days-error" class="help-block">{!! $errors->first("starting_days") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Phone</label>
										<input type="text" name="activity_phone" class="form-control mb-2" placeholder="Zone" value="{{$activityInfo->activity_phone}}">
										@if($errors->has("activity_phone"))
											<span id="activity_phone-error" class="help-block">{!! $errors->first("activity_phone") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Website</label>
										<input type="text" name="activity_website" class="form-control mb-2" placeholder="Zone" value="{{$activityInfo->activity_website}}">
										@if($errors->has("activity_website"))
											<span id="activity_website-error" class="help-block">{!! $errors->first("activity_website") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Email</label>
										<input type="text" name="activity_email" class="form-control mb-2" placeholder="Zone" value="{{$activityInfo->activity_email}}">
										@if($errors->has("activity_email"))
											<span id="activity_email-error" class="help-block">{!! $errors->first("activity_email") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Booking Info</label>
										<input type="text" name="booking_info" class="form-control mb-2" placeholder="Zone" value="{{$activityInfo->booking_info}}">
										@if($errors->has("booking_info"))
											<span id="booking_info-error" class="help-block">{!! $errors->first("booking_info") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Booking Info Link</label>
										<input type="text" name="activity_booking_link" class="form-control mb-2" placeholder="Zone" value="{{$activityInfo->activity_booking_link}}">
										@if($errors->has("activity_booking_link"))
											<span id="activity_booking_link-error" class="help-block">{!! $errors->first("activity_booking_link") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Video Link</label>
										<input type="text" name="video_link" class="form-control mb-2" placeholder="Zone" value="{{$activityInfo->video_link}}">
										@if($errors->has("video_link"))
											<span id="video_link-error" class="help-block">{!! $errors->first("video_link") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Notification Message</label>
										<input type="text" name="activity_notification" class="form-control mb-2" placeholder="Zone" value="{{$activityInfo->activity_notification}}">
										@if($errors->has("activity_notification"))
											<span id="activity_notification-error" class="help-block">{!! $errors->first("activity_notification") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Short Description</label>
										<textarea  name="activity_description" id="activity_description" class="summernote form-control mb-2">{!! $activityInfo->activity_description !!}</textarea>
										@if($errors->has("activity_description"))
											<span id="activity_description-error" class="help-block">{!! $errors->first("activity_description") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Title Name 1</label>
										<input type="text" name="activity_desc_title1" class="form-control mb-2" placeholder="Zone" value="{{$activityInfo->activity_desc_title1}}">
										@if($errors->has("activity_desc_title1"))
											<span id="activity_desc_title1-error" class="help-block">{!! $errors->first("activity_desc_title1") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Description 1</label>
										<textarea  name="activity_description1" id="activity_description1" class="summernote form-control mb-2">{!! $activityInfo->activity_description1 !!}</textarea>
										@if($errors->has("activity_description1"))
											<span id="activity_description1-error" class="help-block">{!! $errors->first("activity_description1") !!}</span>
										@endif
									</div>
								</div>


								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Title Name 2</label>
										<input type="text" name="activity_desc_title2" class="form-control mb-2" placeholder="Zone" value="{{$activityInfo->activity_desc_title2}}">
										@if($errors->has("activity_desc_title2"))
											<span id="activity_desc_title2-error" class="help-block">{!! $errors->first("activity_desc_title2") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Description 2</label>
										<textarea  name="activity_description2" id="activity_description2" class="summernote form-control mb-2">{!! $activityInfo->activity_description2 !!}</textarea>
										@if($errors->has("activity_description2"))
											<span id="activity_description2-error" class="help-block">{!! $errors->first("activity_description2") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Title Name 3</label>
										<input type="text" name="activity_desc_title3" class="form-control mb-3" placeholder="Zone" value="{{$activityInfo->activity_desc_title3}}">
										@if($errors->has("activity_desc_title3"))
											<span id="activity_desc_title3-error" class="help-block">{!! $errors->first("activity_desc_title3") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Description 3</label>
										<textarea  name="activity_description3" id="activity_description3" class="summernote form-control mb-3">{!! $activityInfo->activity_description3 !!}</textarea>
										@if($errors->has("activity_description3"))
											<span id="activity_description3-error" class="help-block">{!! $errors->first("activity_description3") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Title Name 4</label>
										<input type="text" name="activity_desc_title4" class="form-control mb-4" placeholder="Zone" value="{{$activityInfo->activity_desc_title4}}">
										@if($errors->has("activity_desc_title4"))
											<span id="activity_desc_title4-error" class="help-block">{!! $errors->first("activity_desc_title4") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Description 4</label>
										<textarea  name="activity_description4" id="activity_description4" class="summernote form-control mb-4">{!! $activityInfo->activity_description4 !!}</textarea>
										@if($errors->has("activity_description4"))
											<span id="activity_description4-error" class="help-block">{!! $errors->first("activity_description4") !!}</span>
										@endif
									</div>
								</div>


								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Title Name 5</label>
										<input type="text" name="activity_desc_title5" class="form-control mb-5" placeholder="Zone" value="{{$activityInfo->activity_desc_title5}}">
										@if($errors->has("activity_desc_title5"))
											<span id="activity_desc_title5-error" class="help-block">{!! $errors->first("activity_desc_title5") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Description 5</label>
										<textarea  name="activity_description5" id="activity_description5" class="summernote form-control mb-5">{!! $activityInfo->activity_description5 !!}</textarea>
										@if($errors->has("activity_description5"))
											<span id="activity_description5-error" class="help-block">{!! $errors->first("activity_description5") !!}</span>
										@endif
									</div>
								</div>


								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Title Name 6</label>
										<input type="text" name="activity_desc_title6" class="form-control mb-6" placeholder="Zone" value="{{$activityInfo->activity_desc_title6}}">
										@if($errors->has("activity_desc_title6"))
											<span id="activity_desc_title6-error" class="help-block">{!! $errors->first("activity_desc_title6") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Description 6</label>
										<textarea  name="activity_description6" id="activity_description6" class="summernote form-control mb-6">{!! $activityInfo->activity_description6 !!}</textarea>
										@if($errors->has("activity_description6"))
											<span id="activity_description6-error" class="help-block">{!! $errors->first("activity_description6") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Terms & Conditions</label>
										<textarea  name="activity_terms_and_condition" id="activity_terms_and_condition" class="summernote form-control mb-4">{!! $activityInfo->activity_terms_and_condition !!}</textarea>
										@if($errors->has("activity_terms_and_condition"))
											<span id="activity_terms_and_condition-error" class="help-block">{!! $errors->first("activity_terms_and_condition") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Opening Hours</label>
										<textarea  name="activity_opening_hours" id="activity_opening_hours" class="form-control mb-4">{!! $activityInfo->activity_opening_hours !!}</textarea>
										@if($errors->has("activity_opening_hours"))
											<span id="activity_opening_hours-error" class="help-block">{!! $errors->first("activity_opening_hours") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Review</label>
										<textarea  name="activity_review" id="activity_review" class="form-control mb-4">{!! $activityInfo->activity_review !!}</textarea>
										@if($errors->has("activity_review"))
											<span id="activity_review-error" class="help-block">{!! $errors->first("activity_review") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Self Parking</label>
										<br>
										<input type="radio" name="activity_selfparking" value="1" @if($activityInfo->activity_selfparking == 1) checked="checked" @endif>  Yes &nbsp;
										<input type="radio" name="activity_selfparking" value="0" @if($activityInfo->activity_selfparking == 0) checked="checked" @endif>  No 
										@if($errors->has("activity_selfparking"))
											<span id="activity_selfparking-error" class="help-block">{!! $errors->first("activity_selfparking") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Valet Parking</label>
										<br>
										<input type="radio" name="activity_valetparking" value="1" @if($activityInfo->activity_valetparking == 1) checked="checked" @endif>  Yes &nbsp;
										<input type="radio" name="activity_valetparking" value="0" @if($activityInfo->activity_valetparking == 0) checked="checked" @endif>  No 
										@if($errors->has("activity_valetparking"))
											<span id="activity_valetparking-error" class="help-block">{!! $errors->first("activity_valetparking") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Facebook</label>
										<input type="text" name="facebook_url" class="form-control mb-6" placeholder="Facebook" value="{{$activityInfo->facebook_url}}">
										@if($errors->has("facebook_url"))
											<span id="facebook_url-error" class="help-block">{!! $errors->first("facebook_url") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Twitter</label>
										<input type="text" name="twitter_url" class="form-control mb-6" placeholder="Twitter" value="{{$activityInfo->twitter_url}}">
										@if($errors->has("twitter_url"))
											<span id="twitter_url-error" class="help-block">{!! $errors->first("twitter_url") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Instagram</label>
										<input type="text" name="instagram_url" class="form-control mb-6" placeholder="Instagram" value="{{$activityInfo->instagram_url}}">
										@if($errors->has("instagram_url"))
											<span id="instagram_url-error" class="help-block">{!! $errors->first("instagram_url") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Youtube</label>
										<input type="text" name="youtube_url" class="form-control mb-6" placeholder="Youtube" value="{{$activityInfo->youtube_url}}">
										@if($errors->has("youtube_url"))
											<span id="youtube_url-error" class="help-block">{!! $errors->first("youtube_url") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Activity Banner</label>
										<input type="file" name="activityBanner">
										@if($errors->has("activityBanner"))
											<span id="activityBanner-error" class="help-block">{!! $errors->first("activityBanner") !!}</span>
										@endif
										<div class="fs-8 text-black">Dimension atleast 850px x 315px</div>
									</div>
								</div>
								@if($activityInfo->horizontal_banner)
									<div class="col-md-4">
										<div class="form-group">
											<img class="movie-banner featured-image img-fluid" src="{{ $activityInfo->horizontal_banner }}">
										</div>
									</div>
								@endif

								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Activity Poster</label>
										<input type="file" name="activityPoster">
										@if($errors->has("activityPoster"))
											<span id="activityPoster-error" class="help-block">{!! $errors->first("activityPoster") !!}</span>
										@endif
										<div class="fs-8 text-black">Dimension atleast 370px x 480px</div>
									</div>
								</div>
								@if($activityInfo->vertical_banner)
									<div class="col-md-4">
										<div class="form-group">
											<img class="movie-banner featured-image img-fluid" src="{{ $activityInfo->vertical_banner }}">
										</div>
									</div>
								@endif

								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Activity Feature Image</label>
										<input type="file" name="activityFeatured">
										@if($errors->has("activityFeatured"))
											<span id="activityFeatured-error" class="help-block">{!! $errors->first("activityFeatured") !!}</span>
										@endif
										<div class="fs-8 text-black">Dimension atleast 370px x 480px</div>
									</div>
								</div>
								@if($activityInfo->featured_image)
									<div class="col-md-4">
										<div class="form-group">
											<img class="movie-banner featured-image img-fluid" src="{{ $activityInfo->featured_image }}">
										</div>
									</div>
								@endif

								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Onload  Popup</label>
										<select name="popup_show" id="popup_show" aria-label="Select" data-placeholder="Select" class="form-select form-select-solid form-select-lg fw-bold">
											<option  value="0" @if($activityInfo->popup_show == '0') selected="selected" @endif>Hide</option>
											<option  value="1" @if($activityInfo->popup_show == '1') selected="selected" @endif>Show</option>
										</select>
									</div>
								</div>
							</div>


							<div class="row openPopupDiv" style="display:none;">
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label">Display</label>
										<select name="display" id="msg_display" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select</option>
											<option  value="whatsapp" @if($activityInfo->display == 'whatsapp') selected="selected" @endif>Whatsapp</option>
											<option  value="coupon" @if($activityInfo->display == 'coupon') selected="selected" @endif>Coupon</option>
										</select>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label">Popup message</label>
										<textarea  name="popup_msg" id="popup_msg" class="form-control mb-4" placeholder="popup message here ...">{!! $activityInfo->popup_msg !!}</textarea>
									</div>
								</div>

								<div class="col-md-6 couponDiv" style="display:none;">
									<div class="form-group">
										<label class="form-label">Coupon</label>
										<select name="coupon_id" id="coupon_id" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select</option>
											@foreach($coupons as $coupon)
												<option  value="{{$coupon->id}}" @if($activityInfo->coupon_id == $coupon->id) selected="selected" @endif>{{$coupon->couponname}}</option>
											@endforeach
										</select>
									</div>
								</div>

								<div class="col-md-6 couponMessageDiv" style="display:none;">
									<div class="form-group">
										<label class="form-label">Coupon message</label>
										<textarea  name="coupon_msg" id="coupon_msg" class="form-control mb-4" placeholder="coupon message here ...">{!! $activityInfo->coupon_msg !!}</textarea>
									</div>
								</div>

								<div class="col-md-6 whatsappDiv" style="display:none;">
									<div class="form-group">
										<label class="form-label">Whatsapp message</label>
										<textarea  name="whatsapp_msg" id="whatsapp_msg" class="form-control mb-4" placeholder="whatsapp message here ...">{!! $activityInfo->whatsapp_msg !!}</textarea>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Header Tag</label>
										<textarea  name="header_tags" id="header_tags" class="form-control mb-4" placeholder="Header tags here ...">{!! $activityInfo->header_tags !!}</textarea>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Meta Title</label>
										<input type="text" name="meta_title" class="form-control mb-6" placeholder="Meta Title" value="{{$activityInfo->meta_title}}">
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Meta Description</label>
										<textarea  name="meta_description" id="meta_description" class="form-control mb-4" placeholder="Meta Description here ...">{!! $activityInfo->meta_description !!}</textarea>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="form-label">Meta Keywords</label>
										<input type="text" name="meta_keywords" class="form-control mb-6" placeholder="Meta Title" value="{{$activityInfo->meta_keywords}}">
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Meta Image</label>
										<span class="help-block">Dimension atleast 370px x 472px</span>
										<input type="file" name="meta_image">
										@if($errors->has("activityFeatured"))
											<span id="meta_image-error" class="help-block">{!! $errors->first("meta_image") !!}</span>
										@endif
									</div>
								</div>
								@if($activityInfo->meta_image)
									<div class="col-md-6">
										<div class="form-group">
											<img class="movie-banner" src="{{ $activityInfo->meta_image }}">
										</div>
									</div>
								@endif

							</div>
							<div class="d-flex justify-content-end py-6">
								<button type="reset" class="btn btn-light btn-active-light-primary me-2">Reset</button>
								<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Update Changes</button>
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
@section('styles')
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_API_KEY')}}&libraries=places" async defer></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		//Summernote
		$('.summernote').summernote({
		    callbacks: {
		        onImageUpload: function(image) {
		            uploadImage(image[0]);
		        }
		    }
		});

		//Popup Change
		$(document).on('change', '#popup_show', function(){
			var value = $('#popup_show').val();
			if(value == '0'){
				$('.openPopupDiv').hide();
			}else{
				$('.openPopupDiv').show();
			}
			changedisplay();
		});

		$(document).on('change', '#msg_display', function(){
			changedisplay();
			return false;
		});

		$(document).on('change', '#coupon_id', function(){
			changedisplay();
			return false;
		});

		function changedisplay(){
			var val = $('#msg_display').val();
			if(val == 'whatsapp'){
				$('.whatsappDiv').show();
				$('.couponDiv').hide();
				$('.couponMessageDiv').hide();
			}else{
				$('.whatsappDiv').hide();
				$('.couponDiv').show();

				var coupon_id = $('#coupon_id').val();
				if(coupon_id){
					$('.couponMessageDiv').show();
				}else{
					$('.couponMessageDiv').hide();
				}

				
			}
		}

		var map = new google.maps.Map(document.getElementById('map'), {
			center: coords,
		  	zoom: 15,
		  	scrollwheel: false
		});

		var marker = new google.maps.Marker({
			position: coords,
			map: map,
			draggable: true
		});

		google.maps.event.addListener(marker, 'position_changed', function(){
			var lat = marker.getPosition().lat();
			var lng = marker.getPosition().lng();
			$scope.form.map_coordinates = lat+','+lng;
		})

		var search = new google.maps.places.Autocomplete(document.getElementById('searchLocation'));
		search.bindTo('bounds', map);

		search.addListener('place_changed', function() {
			marker.setVisible(false);
			var place = search.getPlace();
			if (!place.geometry) {
				window.alert("No details available for input: '" + place.name + "'");
				return;
			}

			if (place.geometry.viewport) {
				map.fitBounds(place.geometry.viewport);
			} else {
				map.setCenter(place.geometry.location);
				map.setZoom(17);
			}
			marker.setPosition(place.geometry.location);
			marker.setVisible(true);
		});

	});
</script>
@endsection