<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
		   <th class="w-10px pe-2" rowspan="1" colspan="1" aria-label="">S.No</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Name</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Email</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Amount</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Transaction No.</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Order No.</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Pro Expiry</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Plan Desc</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Status</th>
		</tr>
		<!--end::Table row-->
	</thead>
	<!--end::Table head-->
	<!--begin::Table body-->
	<tbody>
		@if(count($records) > 0)
					<?php $i=1; ?>
			@foreach($records as $msg)
				<?php
                  	$status = 'Expired'; 
                	if($msg->pro_plan_enddate > date('Y-m-d')){
                		$status = 'Active'; 
                	}
                ?>
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{ $msg->name }}</td>
					<td>{{ $msg->email }}</td>
					<td>{{ $msg->res_amount }}</td>
					<td>{{ $msg->transaction_id }}</td>
					<td>{{ $msg->unique_id }}</td>
					<td>{{ $msg->pro_plan_enddate }}</td>
					<td>{{ $msg->pro_plan_desc }}</td>
					<td><span class="badge badge-light-primary fs-8 fw-bolder">{{ strtoupper($status) }}</span></td>
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