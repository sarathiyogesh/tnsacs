<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
			<th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">S.No</th>
			<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Name</th>
			<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Status</th>
		   	<th class="min-w-200px" rowspan="1" colspan="1">Actions</th>
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
					<td >{{ $record->name }}</td>
					<td >{{ ucfirst($record->status) }}</td>
					<td>
						<a href="javascript:;" class="editLanguageBtn" data-id="{{ $record->id }}" data-val="{{$record->name}}"><i class="las la-edit fs-4 text-red"></i> Edit</a>
						<span class="px-3 text-black-50">|</span>
						<a href="javascript:;" data-id="{{ $record->id }}" class="deleteLanguageBtn"><i class="las la-trash fs-4 text-red"></i> Delete</a>
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