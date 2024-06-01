<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
			<th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">S.No</th>
			<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Name</th>
			<th class="min-w-100" tabindex="0" rowspan="1" colspan="1">Image</th>
			<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Country Code</th>
			<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Phone Code</th>
			<th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Description</th>
			<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Status</th>

			@can('country-edit')
		   		<th class="min-w-200px" rowspan="1" colspan="1">Actions</th>
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
					<td class="countryNameTd">{{ $record->country_name }}</td>
					<td class="countryCodeTd">{{ $record->country_code }}</td>
					@if(isset($record->country_image))
						<td class="countryImageTd"><img src="{{URL::asset($record->country_image)}}" class="w-50px"></td>
					@else
						<td>--</td>
					@endif
					<td class="PhoneCodeTd">{{ $record->phone_code }}</td>
					<td class="countryDescriptionTd">{!! Str::limit($record->country_description, 20, ' ...') !!}</td>
					<td class="CountryStatusTd">{{ ucfirst($record->status) }}</td>
					@can('country-edit')
						<td>
							<a href="javascript:;" class="editCountryBtn" data-id="{{ $record->id }}" data-val="{{$record->country_name}}"><i class="las la-edit fs-4 text-red"></i> Edit</a>
							<span class="px-3 text-black-50">|</span>
							<a href="javascript:;" data-id="{{ $record->id }}" class="deleteCountryBtn"><i class="las la-trash fs-4 text-red"></i> Delete</a>
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