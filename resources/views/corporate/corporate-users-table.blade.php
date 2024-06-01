<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
		   <th class="w-10px pe-2" rowspan="1" colspan="1" aria-label="">S.No</th>
		   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Name</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Registered Email</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Corporate Email</th>
		   <th class="min-w-100px" rowspan="1" colspan="1">Discount Expiry</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Status</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Organization</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Domain</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Organization Status</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Organization Expiry</th>
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
					<td>{{ $msg->email }}</td>
					<td>{{ $msg->ca_email }}</td>
					<td>{{ $msg->ca_expiry }}</td>
					<td>@if($msg->ca_status) <span class="badge badge-light-success fs-8 fw-bolder">Active</span> @else <span class="badge badge-light-danger fs-8 fw-bolder">Inative</span> @endif</td>
					<td>{{ $msg->org_name }}</td>
					<td>{{ $msg->domain }}</td>
					<td>@if($msg->org_status) <span class="badge badge-light-success fs-8 fw-bolder">Active</span> @else <span class="badge badge-light-danger fs-8 fw-bolder">Inative</span> @endif</td>
					<td>{{ $msg->org_expiry }}</td>
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