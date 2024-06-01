<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
			<th class="w-10px pe-2" rowspan="1" colspan="1" aria-label="">S.No</th>
			<th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Category</th>
			@can('blogs-category-edit')
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
					<td>{{ $i++ }}</td>
					<td class="categoryNameTd">{{ $record->name }}</td>

					<td>
						@can('blogs-category-edit')
							<a href="javascript:;" class="me-1 editCategoryLink" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="Edit" data-id="{{$record->category_id}}" ><i class="las la-edit text-red fs-xxl-5"></i> Edit</a>
							<span class="px-3 text-black-50">|</span>
							<a href="javascript:;" class="me-1 deleteCategory" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="Delete" data-id="{{$record->category_id}}"><i class="las la-trash text-red fs-xxl-5"></i> Delete</a>
							<span class="px-3 text-black-50">|</span>
							<a href="javascript:;" class="me-1 " data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="View" data-id="{{$record->category_id}}"><i class="las la-eye text-red fs-xxl-5"></i> View</a>
							
						@endcan

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