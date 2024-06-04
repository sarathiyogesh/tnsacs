<?php
	use App\Models\Modules;
?>
@if(count($records) > 0)
	<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="kt_ecommerce_products_table">
		<!--begin::Table head-->
		<thead>
			<!--begin::Table row-->
			<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
			   <th class="w-10px pe-2" rowspan="1" colspan="1" aria-label="">
			      S.No
			   </th>
			   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Module</th>
			   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">First name</th>
			   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Last name</th>
			   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Gender</th>
			   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Address</th>
			</tr>
			<!--end::Table row-->
		</thead>
		<!--end::Table head-->
		<!--begin::Table body-->
		<tbody>
			
				<?php $i=0; ?>
				@foreach($records as $record)
					<tr>
						<td>
							{{ ++$i }}
						</td>
						<td>{{ Modules::getmodulename($record->module_id) }}</td>
						<td>{{ $record->first_name }}</td>
						<td>{!! $record->last_name !!}</td>
						<td>{!! $record->gender !!}</td>
						<td>{!! $record->address !!}</td>
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