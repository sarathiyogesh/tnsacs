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
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Order ID</th>
		   <th class="min-w-100" tabindex="0" rowspan="1" colspan="1">Full Name</th>
		   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Email</th>
		   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Phone Number</th>
		   <th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">Total Amount</th>
		   <th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">Details</th>
		   
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
					<td>{{ $result['order_id'] }}</td>
                    <td>{{ $result['first_name'] }} {{ $result['last_name'] }}</td>
                    <td>{{ $result['email'] }}</td>
                    <td>{{ $result['phonenumber'] }}</td>
                    <td>{{ $result['total_amount'] }}</td>
                    <td><a href="javascript:;" class="btn btn-sm btn-primary">Ticket Details</a></td>
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