<?php 
	use App\Models\Category;
	use App\Models\Subject;
?>
<style type="text/css">
	table.loading tbody {
	    position: relative;
	}
	table.loading tbody:after {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.1);
    background-image: url('/backend/assets/img/loading.jpg');
    background-position: center;
    background-repeat: no-repeat;
    background-size: 50px 50px;
    content: "";
}
</style>
@if(count($records) > 0)
<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="kt_ecommerce_products_table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
		   	<th class="w-10px pe-2" rowspan="1" colspan="1" aria-label="">
		      	<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
		   	</th>
		   	<th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Course Name</th>
		   	<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Category</th>
		   	<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Subject</th>
		   	<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Status</th>
		   	<th class="min-w-70px" rowspan="1" colspan="1">Actions</th>
		</tr>
		<!--end::Table row-->
	</thead>
	<!--end::Table head-->
	<!--begin::Table body-->
	<tbody>
		@foreach($records as $record)
			<tr>
	        	<td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
				<td>{{$record->course_name}}</td>
				<td>{{ Category::getname($record->category) }}</td>
				<td>{{ Subject::getname($record->subject) }}</td>
				<td>
					<a href="javascript:;" class="btn {{ $record->status == 'active'?'btn-success':'btn-danger' }} btn-xs">{!! $record->status !!}</a>
				</td>
				<td>
					@can('course-edit')
						<a href="{{url('/courses/edit/'.$record->id)}}" class="actionLink"><i class="las la-edit"></i> Edit</a>
					@endcan
				</td>
	        </tr>
		@endforeach
	</tbody>
	<!--end::Table body-->
</table>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
<input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
<input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>
<div class="custom-pagination pagination">
    {{ $records->links() }}
</div>
@else
	<div class="alert alert-danger">Records not available.</div>
@endif
<!-- <div class="custom-pagination pagination">
	<div class="custom-pagination pagination">
	   <nav>
	      <ul class="pagination">
	         <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
	            <span class="page-link" aria-hidden="true">‹</span>
	         </li>
	         <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
	         <li class="page-item"><a class="page-link" href="javascript:;">2</a></li>
	         <li class="page-item"><a class="page-link" href="javascript:;">3</a></li>
	         <li class="page-item">
	            <a class="page-link" href="javascript:;" rel="next" aria-label="Next »">›</a>
	         </li>
	      </ul>
	   </nav>
	</div>
</div> -->