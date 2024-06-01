<?php
	use App\Models\Bookingreportmeta;
?>
<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
		   <th class="min-w-70px" rowspan="1" colspan="1" aria-label="">S.No</th>
		   <th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">Subscription ID</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Subscription Date</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Subscription Status</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Amount Paid</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Send Ticket</th>
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
		            $url = url('report/ticket/view/'.$record->bookingId);
		            $mailto = 'mailto:'.$record->email.'?subject=Ticket for '.$record->bookingId;
		            $metas = Bookingreportmeta::where('bookingreportId',$record->id)->count();
		            $completed_records = Bookingreportmeta::where('bookingreportId', $record->id)->where('reference_no', '!=', '')->count();
		        ?>
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{ $record->bookingId }}</td>
					<td>{{ $record->bookingDate }}</td>
					<td>{{ $record->bookingStatus }}</td>
	                <td>AED {!! number_format($record->totalPrice,2) !!}</td>

			        <td>
		                @if($record->ticket_source == 'm')
		                    <a href="javascript:;">Send Ticket</a>
		                @elseif($record->reference_no != '' && $record->ticket_source != 'm')
		                    <a href="javascript:;">Send Ticket</a>
		                @else
		                    --
		                @endif
		            </td>
		        	<td>
		                <a class="label label-success" href="{{$url}}">View Details</a>
		            </td>
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