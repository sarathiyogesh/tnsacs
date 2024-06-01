<?php
	use App\Models\Employee;
?>
<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="kt_ecommerce_products_table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
		   <th class="w-10px pe-2" rowspan="1" colspan="1" aria-label="">
		      <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
		         <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="1">
		      </div>
		   </th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Activity Name</th>
		   <th class="min-w-100" tabindex="0" rowspan="1" colspan="1">Ticket Name</th>
		   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Ticket Description</th>
		   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Price Type</th>
		   <th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">Adult Price</th>
		   <th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">Adult 1 Price</th>
		   <th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">Child Price</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Child 1 Price</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Allage Price</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Allage 1 Price</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Min/Max Value</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Last Date Available</th>
		   
		</tr>
		<!--end::Table row-->
	</thead>
	<!--end::Table head-->
	<!--begin::Table body-->
	<tbody>
		@if(count($results) > 0)
					<?php $i=1; ?>
			@foreach($results as $result)
				<tr>
					<td>
						<div class="form-check form-check-sm form-check-custom form-check-solid">
							<input class="form-check-input" type="checkbox" value="1">
						</div>
					</td>
					<td>{{ $result['activity_name'] }}</td>
                    <td>{{ $result['ticket_name'] }}</td>
                    <td>{{ $result['description'] }}</td>
                    <td>{{ $result['price_type'] }}</td>
                    <td>{{ $result['adult_price'] }}</td>
                    <td>{{ $result['adult1_price'] }}</td>
                    <td>{{ $result['child_price'] }}</td>
                    <td>{{ $result['child1_price'] }}</td>
                    <td>{{ $result['allage_price'] }}</td>
                    <td>{{ $result['allage1_price'] }}</td>
                    <td>{{ $result['minmax'] }}</td>
                    <td>{{ $result['last_date'] }}</td>
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