<?php 
	use App\Models\Category;
	use App\Models\Subject;
	use App\Models\User;
	use App\Models\Purchasecoursefaculty;
?>
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
			   	<th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Institution</th>
			   	<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Category</th>
			   	<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Subject</th>
			   	<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Purchased On</th>
			   	<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Plan Name</th>
			   	<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Total Amount</th>
			   	<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">D.O. Expire</th>
			   	<th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Co-Ordinator</th>
			   	<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Total Faculty</th>
			   	<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Status</th>
			   	<th class="min-w-70px" rowspan="1" colspan="1">Actions</th>
			</tr>
			<!--end::Table row-->
		</thead>
		<!--end::Table head-->
		<!--begin::Table body-->
		<tbody>
			@foreach($records as $record)
				<?php
					$faculty_count = Purchasecoursefaculty::where('course_id', $record->course_id)->where('meta_id', $record->id)->count();
				?>
				<tr>
		        	<td><input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"></td>
					<td><a href="{{url('/courses/institution/view-course/'.$record->id)}}"> {{$record->course_name}} </a></td>
					<td>{{ User::getName($record->user_id) }}</td>
					<td>{{Category::getname($record->category)}}</td>
					<td>{{Subject::getname($record->subject)}}</td>
					<td>{{date('M d Y', strtotime($record->purchase_date))}}</td>
					<td>{{ $record->course_title }}</td>
					<td>{{ $record->total_amount }}</td>
					<td>{{date('M d Y', strtotime($record->end_date))}}</td>
					<td>--</td>
					<td>{{ $faculty_count }}</td>
					<td><a href="javascript:;" class="btn {{ $record->booking_status == 'completed'?'btn-success':'btn-danger' }} btn-xs">{{$record->booking_status}}</a></td>
					<td>
						<a href="{{url('/courses/institution/view-course/'.$record->id)}}" class="actionLink"><i class="las la-edit"></i> View</a>
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