<?php
	use App\Models\Bookingreportsapioptions;
?>
<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
		   <th class="min-w-70px" rowspan="1" colspan="1" aria-label="">S.No</th>
		   <th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">Customer Name</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Email</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">User Type</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Total Tickets</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Total Purchased Amount</th>
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
					<td>{{ $record->fullname }}</td>
                    <td>{{ $record->email }}</td>
                    <td>
                        <?php 
                            if($record->ca_status == 0){
                                echo 'Regular User';
                            }else if($record->ca_status == 1){
                                echo 'Corporate User';
                            }else if($record->ca_status == 2){
                                echo 'Pro User';
                            }
                        ?>
                    </td>
                    <td>{{ $record->total_count }}</td>
                    <td>{{ $record->total_amount }}</td>
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