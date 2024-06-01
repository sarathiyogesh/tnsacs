<?php
	use App\Models\LaConfig;
?>
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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Configuration</h1>

					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					
				</div>
				<!--end::Actions-->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<div id="kt_content_container" class="container-xxl">
				<div class="card card-flush">
					<div class="card-body">
						{!! Helpers::displaymsg() !!}
						<div class="box-header with-border">
							<h3 class="box-title">GUI Settings</h3>
						</div>
						<form id="kt_modal_new_target_form" class="form addAgency" action="{{route('saveconfiguration')}}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Sitename</label>
										<input type="text" name="sitename" class="form-control mb-2" placeholder="Sitename" value="{{LaConfig::getvalue('sitename')}}">
										@if($errors->has("sitename"))
											<span id="sitename-error" class="help-block">{!! $errors->first("sitename") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Sitename First Word</label>
										<input type="text" class="form-control mb-2" placeholder="Sitename First Word" name="sitename_part1" value="{{LaConfig::getvalue('sitename_part1')}}">
										@if($errors->has("sitename_part1"))
											<span id="sitename_part1-error" class="help-block">{!! $errors->first("sitename_part1") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Sitename Second Word</label>
										<input type="text" class="form-control mb-2" placeholder="Sitename Second Word" name="sitename_part2" value="{{LaConfig::getvalue('sitename_part2')}}">
										@if($errors->has("sitename_part2"))
											<span id="sitename_part2-error" class="help-block">{!! $errors->first("sitename_part2") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Sitename Short (2/3 Characters)</label>
										<input type="text" class="form-control mb-2" placeholder="Sitename Short (2/3 Characters)" name="sitename_short" value="{{LaConfig::getvalue('sitename_short')}}">
										@if($errors->has("sitename_short"))
											<span id="sitename_short-error" class="help-block">{!! $errors->first("sitename_short") !!}</span>
										@endif
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Site Description</label>
										<input type="text" class="form-control mb-2" placeholder="Description in 140 Characters" name="site_description" value="{{LaConfig::getvalue('site_description')}}">
										@if($errors->has("site_description"))
											<span id="site_description-error" class="help-block">{!! $errors->first("site_description") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="sidebar_search" @if(LaConfig::getvalue('sidebar_search')) checked @endif>
												Show Search Bar
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" name="show_messages" @if(LaConfig::getvalue('show_messages')) checked @endif>
												Show Messages Icon
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" name="show_notifications" @if(LaConfig::getvalue('show_notifications')) checked @endif>
												Show Notifications Icon
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" name="show_tasks" @if(LaConfig::getvalue('show_tasks')) checked @endif>
												Show Tasks Icon
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" name="show_rightsidebar" @if(LaConfig::getvalue('show_rightsidebar')) checked @endif>
												Show Right SideBar Icon
											</label>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Skin Color</label>
										<select name="skin" aria-label="Select Skin Color" data-control="select2" data-placeholder="Select Skin Color" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select Skin Color</option>
											@foreach(LaConfig::getskins() as $name=>$property)
												<option value="{{ $property }}" @if(LaConfig::getvalue('skin') == $property) selected @endif>{{ $name }}</option>
											@endforeach
										</select>
										@if($errors->has("skin"))
											<span id="skin-error" class="help-block">{!! $errors->first("skin") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Layout</label>
										<select name="layout" aria-label="Select Layout" data-control="select2" data-placeholder="Select Layout" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select Layout</option>
											@foreach(LaConfig::getlayout() as $name=>$property)
												<option value="{{ $property }}" @if(LaConfig::getvalue('layout') == $property) selected @endif>{{ $name }}</option>
											@endforeach
										</select>
										@if($errors->has("layout"))
											<span id="layout-error" class="help-block">{!! $errors->first("layout") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Default Email Address</label>
										<input type="text" class="form-control mb-2" placeholder="To send emails to others via SMTP" name="default_email" value="{{LaConfig::getvalue('default_email')}}">
										@if($errors->has("default_email"))
											<span id="default_email-error" class="help-block">{!! $errors->first("default_email") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="required form-label">Bulk QR Code</label>
										<select name="bulk_qr_code" aria-label="Select Bulk QR Code" data-control="select2" data-placeholder="Select Bulk QR Code" class="form-select form-select-solid form-select-lg fw-bold">
											<option value="">Select Bulk QR Code</option>
											<option value="enable" @if(LaConfig::getvalue('bulk_qr_code') == 'enable') selected @endif>Enable</option>
											<option value="disable" @if(LaConfig::getvalue('bulk_qr_code') == 'disable') selected @endif>Disable</option>
										</select>
										@if($errors->has("bulk_qr_code"))
											<span id="bulk_qr_code-error" class="help-block">{!! $errors->first("bulk_qr_code") !!}</span>
										@endif
									</div>
								</div>
								
								
							</div>
							<div class="d-flex justify-content-end py-6">
								<button type="reset" class="btn btn-light btn-active-light-primary me-2">Reset</button>
								<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>
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