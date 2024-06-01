<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
		   <th class="min-w-70px" rowspan="1" colspan="1" aria-label="">S.No</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Activity Name</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Item Name</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Adult Price</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Child Price</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">All Age Price</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Adult Price 1</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Child Price 1</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">All Age Price 1</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">API Adult Price</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">API Child Price</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">API All Age Price</th>

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
                    <td>{{ $record->activity_name }}</td>
                    <td>{{ $record->item_name }}</td>
                    <td>{{ $record->adult_price }}</td>
                    <td>{{ $record->child_price }}</td>
                    <td>{{ $record->allage_price }}</td>
                    <td>{{ $record->adult1_price }}</td>
                    <td>{{ $record->child1_price }}</td>
                    <td>{{ $record->allage1_price }}</td>
                    <td>{{ $record->api_adult_price }}</td>
                    <td>{{ $record->api_child_price }}</td>
                    <td>{{ $record->api_allage_price }}</td>
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
@if(count($records) > 0)
	<div class="custom-pagination pagination">
		{{ $records->appends(request()->query())->links() }} 
	</div>
@endif