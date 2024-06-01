<?php
	use App\Models\Raynatouroptiondata;

?>
<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
		   <th class="min-w-70px" rowspan="1" colspan="1" aria-label="">S.No</th>
		   <th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">Tour ID</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Option ID</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Contract ID</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Transfer ID</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Tour Name</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Option Name</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Transfer Name</th>
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
					<td>{{ $i++ }}</td>
					<td>{{ $record->tour_id }}</td>
					<td>{{ $record->option_id }}</td>
					<td>{{ $record->contract_id }}</td>
					<td>{{ $record->transfer_id }}</td>
					<td>{!! $record->tour_name !!}</td>
	                <td>{!! Raynatouroptiondata::optionname($record->tour_id, $record->option_id) !!}</td>
	                <td>{!! $record->transfer_name !!}</td>
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