<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
			<th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Name</th>
			@can('tags-edit')
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
					<td>{{ $record->tag_name }}</td>
					@can('tags-edit')
						<td>
							<a href="javascript:;" class="editTagBtn" data-id="{{ $record->tag_id }}" data-val="{{$record->tag_name}}"><i class="las la-edit fs-4 text-red"></i> Edit</a>
							<span class="px-3 text-black-50">|</span>
							<a href="javascript:;" data-id="{{ $record->tag_id }}" class="deleteTagBtn"><i class="las la-trash fs-4 text-red"></i> Delete</a>
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