<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
		   <th class="w-10px pe-2" rowspan="1" colspan="1" aria-label="">S.No</th>
		   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Name</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Company</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Email</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Phone</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Date</th>
		   <th class="min-w-200px" rowspan="1" colspan="1">Message</th>
		</tr>
		<!--end::Table row-->
	</thead>
	<!--end::Table head-->
	<!--begin::Table body-->
	<tbody>
		@if(count($records) > 0)
					<?php $i=1; ?>
			@foreach($records as $msg)
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{ $msg->name }}</td>
					<td>{{ $msg->company }}</td>
					<td>{{ $msg->email }}</td>
					<td>{{ $msg->phone }}</td>
					<td>{{ date('M d, Y @ H:i', $msg->date) }}</td>
					<td>{{ $msg->message }}</td>
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