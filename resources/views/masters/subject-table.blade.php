@if(count($records) > 0)
	<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
		<!--begin::Table head-->
		<thead>
			<!--begin::Table row-->
			<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
				<th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Name</th>
				<th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Status</th>
			   <th class="min-w-70px" rowspan="1" colspan="1">Actions</th>
			</tr>
			<!--end::Table row-->
		</thead>
		<!--end::Table head-->
		<!--begin::Table body-->
		<tbody>
			<?php $i=1; ?>
			@foreach($records as $record)
				<tr>
					<td>{{ $record->name }}</td>
					<td><a href="javascript:;" class="btn btn-sm @if($record->status == 'active') btn-success btn-xs @else btn-danger @endif">{{ ucfirst($record->status?'Active':'Inactive') }}</a> </td>
					<td>
						<a href="{{url('/master/subject/edit/'.$record->id)}}" class="actionLink"><i class="las la-edit"></i> Edit</a>
							<!-- <span class="px-3 text-black-50">|</span> -->
						<!-- <a href="javascript:;" data-id="{{ $record->category_id }}" class="deleteCategoryBtn"><i class="las la-trash fs-4 text-red"></i> Delete</a> -->
					</td>
				</tr>
			@endforeach
		</tbody>
		<!--end::Table body-->
	</table>
@else
	<div class="alert alert-danger">Records not available.</div>
@endif