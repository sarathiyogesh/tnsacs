<?php
	use App\Models\user;
	use App\Models\Category;
	use App\Models\Course;
?>
@if(count($records) > 0)
	<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
		<!--begin::Table head-->
		<thead>
			<!--begin::Table row-->
			<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
			   <th class="min-w-70px" rowspan="1" colspan="1" aria-label="">S.No</th>
			   <th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">Subscription ID</th>
			   <th class="min-w-70px" rowspan="1" colspan="1">Institution</th>
			   <th class="min-w-70px" rowspan="1" colspan="1">Student</th>
			   <th class="min-w-70px" rowspan="1" colspan="1">Course Name</th>
			   <th class="min-w-70px" rowspan="1" colspan="1">Category</th>
			   <th class="min-w-70px" rowspan="1" colspan="1">Plan</th>
			   <th class="min-w-70px" rowspan="1" colspan="1">Purchased Date</th>
			   <th class="min-w-70px" rowspan="1" colspan="1">Amount</th>
			   <!-- <th class="min-w-70px" rowspan="1" colspan="1">Status</th> -->
			</tr>
			<!--end::Table row-->
		</thead>
		<!--end::Table head-->
		<!--begin::Table body-->
		<tbody>
			<?php $i=1; ?>
			@foreach($records as $record)
				<tr>
					<td>{{ $i++ }}</td>
	                <td>{{ $record->unique_id }}</td>
	                <td>{{ User::getName($record->institution_id) }}</td>
	                <td>
	                	{{ User::getName($record->user_id) }}<br>
	                	{{ User::getuserdetails($record->user_id, 'email') }}<br>
	                	{{ User::getuserdetails($record->user_id, 'rollno') }}
	                </td>
	                <td>{{ Course::getname($record->course_id) }}</td>
	                <td>{{ Category::getname($record->category) }}</td>
	                <td>{{ date('d-M-Y', strtotime($record->start_date)) }} to {{ date('d-M-Y', strtotime($record->end_date)) }}</td>
	                <td>{{ date('d-M-Y', strtotime($record->purchase_date)) }}</td>
	                <td>{{ $record->total_amount }}</td>
	            </tr>
			@endforeach
		</tbody>
		<!--end::Table body-->
	</table>

	<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
	<div class="custom-pagination pagination">
		{{ $records->links() }}
	</div>
@else
	<div class="alert alert-danger">Records not available.</div>
@endif
