<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
		   <th class="min-w-70px" rowspan="1" colspan="1" aria-label="">S.No</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Option Name</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Option ID</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Adult Price</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Child Price</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Allage Price</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">API Adult Price</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">API Child Price</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">API Allage Price</th>

		</tr>
		<!--end::Table row-->
	</thead>
	<!--end::Table head-->
	<!--begin::Table body-->
	<tbody>
		@if(count($records) > 0)
					<?php $i=1; ?>
			@foreach($records as $re)
				
				<tr>
					<td>{{ $i++ }}</td>
					<td>{!! $re['name'] !!}</td>
	            	<td>{!! $re['option_id'] !!}</td>
	                <td>{!! $re['adult_price'] !!}</td>
	            	<td>{!! $re['child_price'] !!}</td>
	                <td>{!! $re['allage_price'] !!}</td>
	                <td>{!! $re['api_adult_price'] !!}</td>
	                <td>{!! $re['api_child_price'] !!}</td>
	                <td>{!! $re['api_adult_price'] !!}</td>
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
