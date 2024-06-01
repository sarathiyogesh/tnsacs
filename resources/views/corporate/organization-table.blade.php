<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
			<th class="w-10px pe-2" rowspan="1" colspan="1" aria-label="">S.No</th>
			<th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Organization Name</th>
		   <th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">Domain</th>
		   <th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">Email</th>
		   <th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">Phone</th>
		   <th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">Location</th>
		   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Expiry</th>
		   <th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">Status</th>
		    @can('discount-organization-edit')
			   <th class="min-w-150px" rowspan="1" colspan="1">Actions</th>
			   <th class="min-w-100px" rowspan="1" colspan="1">Activation Link</th>
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
					<td>{{ $record->name }}</td>
					<td>{{ $record->domain }}</td>
					<td>{{ $record->email }}</td>
					<td>{{ $record->phone }}</td>
					<td>{{ $record->location }}</td>
					<td>{{ $record->expiry }}</td>
					
					@if($record->deleted_at)
						<td><span class="badge badge-light-danger fs-8 fw-bolder">Deleted</span></td>
						@can('discount-organization-edit')
							<td><a href="javascript:;"  data-id="{{ $record->id }}" class="restoreOrganization"><span class="badge badge-light-primary fs-8 fw-bolder">Restore</span></a></td>
						@endcan
						<td>&nbsp;</td>

					@else
						<td>@if($record->status) <span class="badge badge-light-success fs-8 fw-bolder">Active</span> @else <span class="badge badge-light-danger fs-8 fw-bolder">Inative</span> @endif</td>
						@can('discount-organization-edit')
							<td>
								<a href="javascript:;" class="editOrganization" data-id="{{ $record->id }}"><i class="las la-edit fs-4 text-red"></i> Edit</a>
								<span class="px-3 text-black-50">|</span>
								<a href="javascript:;" data-id="{{ $record->id }}" class="deleteOrganization"><i class="las la-trash fs-4 text-red"></i> Delete</a>

							</td>
							<td><a href="javascript:;" data-id="https://bookingbash.com/login?ac_id={{$record->activation_link}}" class="copyToClipboard"><i class="las la-copy fs-4 text-red"></i></a></td>
							 {{-- https://bookingbash.com/login?ac_id={{ $record->activation_link }} --}}
						@endcan
					@endif
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