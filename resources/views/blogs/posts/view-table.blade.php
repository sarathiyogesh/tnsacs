<?php
	use App\Models\Employee;
?>
<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="kt_ecommerce_products_table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
		   <th class="w-10px pe-2" rowspan="1" colspan="1" aria-label="">S.No</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Post name</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Post date</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Status</th>
		   	<th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Actions</th>
		</tr>
		<!--end::Table row-->
	</thead>
	<!--end::Table head-->
	<!--begin::Table body-->
	<tbody>
		@if(count($records) > 0)
					<?php $i=0; ?>
			@foreach($records as $record)
				<tr>
					<td>{{ ++$i }}</td>
					<td>{{ $record->title }}</td>
					<td>{{ date('d-M-Y', strtotime($record->date)) }}</td>
					<td><a href="javascript:;" class="btn {{ $record->status == 'active'?'btn-success':'btn-danger' }} btn-xs">{!! $record->status !!}</a></td>
					<td>
						<a href="{{url('blogs/post/edit/'.$record->id)}}" class="actionLink"><i class="las la-edit"></i> Edit</a>
						<!-- <a href="javascript:;" class="me-1" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="Delete"><i class="las la-trash text-red fs-xxl-5"></i></a> -->
					</td>
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