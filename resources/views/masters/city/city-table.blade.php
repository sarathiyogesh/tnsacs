<?php
	use App\Models\Country;
?>
<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
			<th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">S.No</th>
			<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">City Name</th>
			<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Image</th>
			<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Country Name</th>
			<th class="min-w-250px" tabindex="0" rowspan="1" colspan="1">Description</th>
			<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Status</th>
			@can('city-edit')
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
					<td class="countryNameTd">{{ $record->name }}</td>
					@if(isset($record->image))
						<td class="countryImageTd"><img src="{{URL::asset($record->image)}}" class="w-50px"></td>
					@else
						<td>--</td>
					@endif
					<td>{!! Country::getName($record->country_id) !!}</td>
					<td class="countryDescriptionTd">{!! Str::limit($record->description, 30, ' ...') !!}</td>
					<td class="CountryStatusTd">{{ ucfirst($record->status) }}</td>
					@can('city-edit')
						<td>
							<a href="javascript:;" class="editCityBtn" data-id="{{ $record->id }}" data-val="{{$record->name}}"><i class="las la-edit fs-4 text-red"></i> Edit</a>
							<span class="px-3 text-black-50">|</span>
							<a href="javascript:;" data-id="{{ $record->id }}" class="deleteCityBtn"><i class="las la-trash fs-4 text-red"></i> Delete</a>
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