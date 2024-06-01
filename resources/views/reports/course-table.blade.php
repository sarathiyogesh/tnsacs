<?php
	use App\Models\Course;
?>
@if(count($records) > 0)
	<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
		<!--begin::Table head-->
		<thead>
			<!--begin::Table row-->
			<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
			   <th class="min-w-70px" rowspan="1" colspan="1" aria-label="">S.No</th>
			   <th class="min-w-70px" rowspan="1" colspan="1">Course Name</th>
			   <th class="min-w-70px" rowspan="1" colspan="1">Plan</th>
			   <th class="min-w-70px" rowspan="1" colspan="1">Purchased Date</th>
			   <th class="min-w-70px" rowspan="1" colspan="1">Amount</th>
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
	                <td>{{ Course::getname($record->course_id) }}</td>
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
