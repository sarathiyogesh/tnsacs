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
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Name</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Designation</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Mobile</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Email</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Created On</th>
		   <th>Status</th>
		   @can('employee-edit')
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
					<td>{{ $record->name }}</td>
					<td>{!! $record->designation !!}</td>
					<td>{!! $record->mobile !!}</td>
					<td>{!! $record->email !!}</td>
					<td>{!! Employee::getdepartment($record->dept) !!}</td>
					@can('employee-edit')
						<td>
							<a href="{{url('users/'.$record->id.'/edit')}}" class="me-1" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="Edit"><i class="las la-edit fs-4 text-red"></i> Edit</a>
							<a href="javascript:;" class="me-1" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="Delete"><i class="las la-trash text-red fs-xxl-5"></i></a>
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