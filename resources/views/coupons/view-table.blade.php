<?php
	use App\Models\Activity;
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
		   <th class="min-w-75px" tabindex="0" rowspan="1" colspan="1">Name</th>
		   <th class="min-w-50px" tabindex="0" rowspan="1" colspan="1">Code</th>
		   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Activity Name</th>
		   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Type</th>
		   <th class="min-w-50px" tabindex="0" rowspan="1" colspan="1">Amount/Percentage</th>
		   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Start Date</th>
		   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">End Date</th>
		   <th class="min-w-75px" tabindex="0" rowspan="1" colspan="1">Total Coupon</th>
		   <th class="min-w-75px" tabindex="0" rowspan="1" colspan="1">Status</th>
		   @can('coupon-edit')
		   	<th class="min-w-50px" tabindex="0" rowspan="1" colspan="1">Manage</th>
		   @endcan
		   @can('coupon-delete')
		   	<th class="min-w-70px" rowspan="1" colspan="1">Actions</th>
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
					<td>
						<div class="form-check form-check-sm form-check-custom form-check-solid">
							<input class="form-check-input" type="checkbox" value="1">
						</div>
					</td>
					<td>{{ $record->couponname }}</td>
					<td>{!! $record->couponcode !!}</td>
					<td>{!! Activity::getactivityname($record->activity_id) !!}</td>
					<td>{!! $record->coupontype !!}</td>
					@if($record->coupontype == 'amount')
                		<td>{{$record->couponamount}}</td>
                	@else
                		<td>{{$record->couponpercentage}}</td>
                	@endif
                	<td>{{$record->startdate}}</td>
                	<td>{{$record->enddate}}</td>
                	<td>{{$record->totalcoupon}}</td>
                	<td>{{$record->status}}</td>
					@can('coupon-edit')
						<td>
							<a href="{{url('coupons/'.$record->couponcode.'/edit')}}" class="me-1" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="Edit"><i class="las la-edit text-red fs-xxl-5"></i>Edit</a>
						</td>
					@endcan
					@can('coupon-delete')
						<td>
							<a href="javascript:;" class="me-1 deleteCoupon" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="Delete" data-id="{{$record->id}}"><i class="las la-trash text-red fs-xxl-5"></i>Delete</a>
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