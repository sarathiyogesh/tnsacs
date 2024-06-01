<?php
	use App\Models\Ticketitem;
?>
<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
		   <th class="w-10px pe-2" rowspan="1" colspan="1" aria-label="">S.No</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">QR Code</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Expiry Date</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Status</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Item Name</th>
		    @can('bulkQR-edit')
		   		<th class="min-w-70px" rowspan="1" colspan="1">Action</th>
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
					<td>{{ $i++ }}</td>
					<td>{{ $record->qr_code }}</td>
					<td> @if($record->expiry_date) {{ date('d-m-Y', strtotime($record->expiry_date))}} @else &nbsp; @endif</td>
					<td>{{ ucfirst($record->status) }}</td>
					<td>{{Ticketitem::getitemname($record->item_id)}}</td>
					@can('bulkQR-edit')
						<td>
							@if($record->qr_status == 'pending')
								<a href="{{ url('bulk-qr-codes/edit/'.$record->id) }}"> Edit </a>
							@else
								--
							@endif
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