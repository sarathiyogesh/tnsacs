@if(count($records) > 0)
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
			   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Email</th>
			   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Created On</th>
			   <th>Status</th>
			</tr>
			<!--end::Table row-->
		</thead>
		<!--end::Table head-->
		<!--begin::Table body-->
		<tbody>
			
				<?php $i=1; ?>
				@foreach($records as $record)
					<tr>
						<td>
							<div class="form-check form-check-sm form-check-custom form-check-solid">
								<input class="form-check-input" type="checkbox" value="1">
							</div>
						</td>
						<td>{{ $record->name }}</td>
						<td>{!! $record->email !!}</td>
						<td>{!! date('d-M-Y', strtotime($record->created_at)) !!}</td>
						<td>
							<a href="javascript:;" class="btn {{ $record->status == 'active'?'btn-success':'btn-danger' }} btn-xs">{!! $record->status !!}</a>
						</td>
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