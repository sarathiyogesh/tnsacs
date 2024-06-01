<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="kt_ecommerce_products_table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
		   <th class="w-10px pe-2" rowspan="1" colspan="1" aria-label="">S.No</th>
		   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Institution</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Start Date</th>
		   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">End Date</th>
		   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Course(s)</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Status</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Action</th>
		</tr>
		<!--end::Table row-->
	</thead>
	<!--end::Table head-->
	<!--begin::Table body-->
	<tbody>
		<tr>
			<td>1</td>
			<td>SDNB Vaishnav College Women</td>
			<td>02-Jan-2024</td>
			<td>02-Apr-2024</td>
			<td>2</td>
			<td><span class="alert alert-info alert-xs">Active</span></td>
			<td><a href="javascript:;" title="Edit"><i class="las la-edit fs-4 text-red"></i> Edit</a></td>
		</tr>

		{{-- @if(count($records) > 0)
					<?php $i=1; ?>
			@foreach($records as $record)
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{ $record->email }}</td>
					<td>{{ $record->status }}</td>
					<td>{{ $record->created_at }}</td>
				</tr>
			@endforeach
		@else
			<tr>
				<td colspan="3">No data available</td>
			</tr>
		@endif --}}
	</tbody>
	<!--end::Table body-->
</table>

<input type="hidden" name="hidden_page" id="hidden_page" value="1" />

<div class="custom-pagination pagination">
	{{ $records->links() }}
</div>