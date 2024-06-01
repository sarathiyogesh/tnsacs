<?php
	use App\Models\State;
?>
@if(count($records) > 0)
	<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="kt_ecommerce_products_table">
		<!--begin::Table head-->
		<thead>
			<!--begin::Table row-->
			<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
			   <th class="w-10px pe-2" rowspan="1" colspan="1" aria-label="">
			      S.No.
			   </th>
			   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Name</th>
			   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Email</th>
			   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Phone</th>
			   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Address</th>
			   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">POC Name</th>
			   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">POC Mobile</th>
			   <th>Status</th>
			   @can('institution-edit')
			   	<th class="min-w-70px" rowspan="1" colspan="1">Actions</th>
			   @endcan
			</tr>
			<!--end::Table row-->
		</thead>
		<!--end::Table head-->
		<!--begin::Table body-->
		<tbody>
			<?php $i=1; ?>
			@foreach($records as $record)
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{ $record->name }}</td>
					<td>{!! $record->email !!}</td>
					<td>{!! $record->mobile !!}</td>
					<td>{!! $record->address !!}<br>{{ $record->city }}, {{ State::getname($record->state) }} - {{ $record->pincode}}</td>
					<td>{!! $record->contact_person_name !!}</td>
					<td>{!! $record->contact_person_mobile !!}</td>
					<td><a href="javascript:;" class="btn {{ $record->status == 'active'?'btn-success':'btn-danger' }} btn-xs">{!! $record->status !!}</a></td>
					@can('institution-edit')
						<td>
							<a href="{{url('institution/edit/'.$record->id)}}" class="actionLink"><i class="las la-edit"></i> Edit</a>
							<!-- <a href="javascript:;" class="me-1" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="Delete"><i class="las la-trash text-red fs-xxl-5"></i></a> -->
						</td>
					@endcan
				</tr>
			@endforeach
		</tbody>
		<!--end::Table body-->
	</table>


	<input type="hidden" name="hidden_page" id="hidden_page" value="1" />

	<div class="custom-pagination pagination">
		{{ $records->links() }}
	</div>
@else
	<div class="alert alert-danger">Records not available.</div>
@endif