<?php
	use App\Models\Bulkqrcode;
	use App\Models\Activity;
?>
<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
		   <th class="w-10px pe-2" rowspan="1" colspan="1" aria-label="">S.No</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Option ID</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Activity Name</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Pending</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Used</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Expired</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">View</th>
		</tr>
		<!--end::Table row-->
	</thead>
	<!--end::Table head-->
	<!--begin::Table body-->
	<tbody>
		@if(count($records) > 0)
					<?php $i=1; ?>
			@foreach($records as $record)
				<?php
					$used = Bulkqrcode::where('status', 'active')->where('qr_status', 'used')->where('option_id', $record->option_id)->count();
					$pending = Bulkqrcode::where('status', 'active')->where('qr_status', 'pending')->where('option_id', $record->option_id)->count();
					$expired = Bulkqrcode::where('status', 'active')->where('qr_status', 'pending')->where('expiry_date', '<', date('Y-m-d'))->where('option_id', $record->option_id)->count();
					$activity_name = Activity::getactivityname($record->activity_id);
				?>
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{ $record->option_id }}</td>
					<td>{{ $activity_name }}</td>
					<td>{{ $pending }}</td>
					<td>{{ $used }}</td>
					<td>{{ $expired }}</td>
					<td><a href="{{ url('bulk-qr-codes/option/'.$record->option_id) }}"><i class="las la-eye fs-4 text-red"></i> View </a></td>
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