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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Edit Module</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{url('admin/modules')}}" id="kt_help_toggle" class="btn btn-sm btn-primary" >Manage Modules</a>

					<a href="javascript:;" id="addChapterBox" class="btn btn-sm btn-success" >Add Chapter</a>

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

				<div class="card card-flush mb-3">
					<div class="card-body">

						<form action="{{route('admin.module.update')}}" method="POST">
							@csrf
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Title</label>
										<input type="text" name="title" class="form-control mb-2" placeholder="title" value="{{$record->title}}">
										@if($errors->has("title"))
											<span id="name-error" class="help-block">{!! $errors->first("title") !!}</span>
										@endif
									</div>
								</div>
								<input type="hidden" name="editid" id="editid" value="{{$record->id}}">
								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Category</label>
										<input type="text" name="category" class="form-control mb-2" placeholder="category" value="{{$record->category}}">
										@if($errors->has("category"))
											<span id="name-error" class="help-block">{!! $errors->first("category") !!}</span>
										@endif
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label for="featuredImage">Banner image</label>
									  	<div class="row">
									  		<div class="col-sm-12">
											  	@include('media.select_media_template',['options'=>['select'=>'yes','select_type'=>'single','input_name'=>'banner_image','values'=>$record->banner_image]])
											  	@if($errors->has("banner_image"))
													<span id="name-error" class="help-block">{!! $errors->first("banner_image") !!}</span>
												@endif
											</div>
										</div>
										<div class="fs-8 text-black">Dimension atleast 500px x 620px</div>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label class="required form-label">Description</label>
										<textarea class="form-control mb-2"  name="description">{{$record->description}}</textarea>
										@if($errors->has("description"))
											<span id="description-error" class="help-block">{!! $errors->first("description") !!}</span>
										@endif
									</div>
									<div class="form-group">
										<label class="required form-label">Status</label>
										<select class="form-control mb-2"  name="status">
											<option value="">select</option>
											<option value="active" @if($record->status == 'active') selected @endif>Active</option>
											<option value="inactive" @if($record->status == 'inactive') selected @endif >Inactive</option>
										</select>
										@if($errors->has("status"))
											<span id="status-error" class="help-block">{!! $errors->first("status") !!}</span>
										@endif
									</div>
								</div>
								<div class="d-flex justify-content-end py-6">
									<button type="reset" class="btn btn-light btn-active-light-primary me-2">Reset</button>
									<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Update </button>
								</div>

							</div>
						</form>
					</div>
				</div>

				<div class="card">
					<div class="card-body">
						<h4><b>Chapters</b></h4>
						<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="kt_ecommerce_products_table">
							<thead>
								<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
								   <th>
								      S.No
								   </th>
								   <th>Title</th>
								   <th>Duration</th>
								   <th>URL</th>
								   <th>Status</th>
								   <th class="min-w-70px" rowspan="1" colspan="1">Actions</th>
								</tr>
							</thead>
							<tbody>
									<?php $i=0; ?>
									@foreach($chapters as $chapter)
										<tr>
											<td>
												{{ ++$i }}
											</td>
											<td>{{ $chapter->title }}</td>
											<td>{!! $chapter->duration !!}</td>
											<td><a href="{{ $chapter->video_url }}" target="_blank">View</a></td>
											<td>
												<a href="javascript:;" class="btn {{ $chapter->status == 'active'?'btn-success':'btn-danger' }} btn-xs">{!! ucfirst($chapter->status) !!}</a>
											</td>
											<td>
												<a href="javascript:;" class="actionLink"><i class="las la-edit"></i> Edit</a>
											</td>
										</tr>
									@endforeach
							</tbody>
							<!--end::Table body-->
						</table>
					</div>
				</div>
			</div>

			

		</div>
		<!--end::Post-->
	</div>
	<!--end::Content-->

	<div class="modal fade" id="addChapterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Add Chapter</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		        
		        <div class="col-md-12">
					<div class="form-group">
						<label class="required form-label">Title</label>
						<input type="text" name="chapter_title" id="chapter_title" class="form-control mb-2" placeholder="title" value="">
					</div>
				</div>

				<div class="col-md-12">
					<div class="form-group">
						<label class="required form-label">Duration (In minutes)</label>
						<input type="text" name="chapter_duration" id="chapter_duration" class="form-control mb-2" placeholder="Duration" value="">
						<em>Enter value in minutes</em>
					</div>
				</div>

				<div class="col-md-12">
					<div class="form-group">
						<label class="required form-label">URL</label>
						<input type="text" name="chapter_video_url" id="chapter_video_url" class="form-control mb-2" placeholder="URL" value="">
					</div>
				</div>


		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="button" class="btn btn-primary" id="addChapterBtn">Add</button>
		      </div>
		    </div>
		  </div>
		</div>

@endsection
@section('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('backend/js/media_handler.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#dob').datepicker({
			format: 'dd-mm-yyyy'
		});

		$('#addChapterBox').on('click', function(){
			$('#addChapterModal').modal('show');
		});


		$(document).on('click', '#addChapterBtn', function (){
			var t = $(this); ctxt = t.text();
			t.text('Processing...').prop('disabled', true);
			var title = $('#chapter_title').val();
			var duration = $('#chapter_duration').val();
			var url = $('#chapter_video_url').val();
			var editid = $('#editid').val();
			console.log(editid);
			$.ajax({
                url:"{{ url('admin/module/chapter/add') }}",
                dataType: 'json',
				headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'), },
                data: { title: title, duration:duration, url: url,editid: editid },
                type:"POST",
                success: function(res){
                	t.text(ctxt).prop('disabled', false);;
                    if(res.status == 'success'){
                    	alert('New chapter added successfully');
                    	$('#addChapterModal').modal('hide');
                    	location.reload();
                    	//getTable();
                    }else if(res.status == 'error'){
                    	alert(res.msg);
                    }else if(res.status == 'validation'){
                    	alert(res.msg);
                    }
                    return false;
                },error: function(e){
                	t.text(ctxt).prop('disabled', false);;
                	alert(e.responseText);
                }
            });
		});

	});
</script>


@endsection