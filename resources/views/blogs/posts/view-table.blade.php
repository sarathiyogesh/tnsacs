<?php
	use App\Models\Employee;
?>
<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="kt_ecommerce_products_table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
		   <th class="w-10px pe-2" rowspan="1" colspan="1" aria-label="">
		      <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
		         <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="1">
		      </div>
		   </th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Post name</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Status</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Author</th>
		   @can('blogs-post-edit')
		   	<th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Actions</th>
		   @endcan
		</tr>
		<!--end::Table row-->
	</thead>
	<!--end::Table head-->
	<!--begin::Table body-->
	<tbody>
		@if(count($records) > 0)
					<?php $i=1; ?>
			@foreach($records as $record)
				<tr>
					<td>
						<div class="form-check form-check-sm form-check-custom form-check-solid">
							<input class="form-check-input" type="checkbox" value="1">
						</div>
					</td>
					<td>{{ $record->post_title }}</td>
					<td>{!! ucfirst($record->status) !!}</td>
					<td>{!! $record->author !!}</td>
					@can('blogs-post-edit')
						<td>
							<div class="dropdown">
							  <button class="dropbtn btn btn-primary btn-xs"><i class="fa-solid fa-list-dropdown"></i>Actions</button>
							  <div class="dropdown-content">
							    <a href="{{url('blogs/post/edit/'.$record->post_id)}}">Edit</a>
							    @if($record->status == 'published' && !$record->featured_post)
							    	<a href="javascript:;" >Mark featured</a>
							    @endif
							    <!-- @if($record->status == 'published' && $record->featured_post)
							    	<a href="javascript:;" >Remove featured</a>
							    @endif
							    @if($record->status != 'published')
							    	<a href="javascript:;" >Publish</a>
							    @endif
							    @if($record->status != 'unpublished')
							    	<a href="javascript:;" >Unpublish</a>
							    @endif
							    @if($record->status != 'draft')
							    	<a href="javascript:;" >Move to draft</a>
							    @endif -->
							    <!-- @if($record->status == 'active')
							    	<a href="javascript:;" class="changStatus">Inactivate</a>
							    @endif

							     @if($record->status == 'inactive')
							    	<a href="javascript:;" class="changStatus" >Activate</a>
							    @endif -->

							    <a href="javascript:;" class="changStatus" data-id="{{$record->post_id}}">Change Status</a>
						  	</div>
						</div>
						</td>
					@endcan
				</tr>
			@endforeach
		@else
			<tr>
				<td colspan="3">No data available</td>
			</tr>
		@endif
	</tbody>
	<!--end::Table body-->
</table>

<input type="hidden" name="hidden_page" id="hidden_page" value="1" />

<div class="custom-pagination pagination">
	{{ $records->links() }}
</div>