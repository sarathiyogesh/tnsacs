<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="kt_ecommerce_products_table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
		   <th class="w-10px pe-2" rowspan="1" colspan="1" aria-label="">S.No</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Activity Name</th>
		   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">City</th>
		   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Last Date</th>
		    @can('activities-edit')
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
					<td>{{ $record->activity_name }}</td>
					<td>{{ $record->activity_city_name }}</td>
					<td>
						@if($record->past_date == 'yes')
							<a href="javascript:;" class="label label-danger">{{ $record->last_date }} </a>
						@else
							<a href="javascript:;" class="label label-success">{{ $record->last_date }} </a>
						@endif
					</td>						
					@can('activities-edit')
						<td>
							<a class="label label-success" href="{{ url('activities/ticket/'.$record->activity_id) }}" title="Ticket"><i class="las la-ticket-alt fs-4 text-red"></i></a>
							<span class="px-3 text-black-50">|</span>
							<a class="label label-success" href="{{ url('activities/gallery/'.$record->activity_id) }}" title="Gallery"><i class="las la-images fs-4 text-red"></i></a>
							<span class="px-3 text-black-50">|</span>
							<a class="label label-primary" href="{{ url('activities/edit/'.$record->activity_id) }}" title="Edit"><i class="las la-edit fs-4 text-red"></i></a>
							<span class="px-3 text-black-50">|</span>
							<a class="label label-danger deleteActivity" data-id="{{ $record->activity_id}}" href="javascript:;" title="Delete"><i class="las la-trash fs-4 text-red"></i></a>
							@if(!$record->featured)
								
							@else
								
							@endif

							<?php
								$class = 'label label-danger';
								$value = 'Feature this';
								if($record->featured){
									$class = 'label label-success';
									$value = 'Unfeature this';
								}
							?>
							<span class="px-3 text-black-50">|</span>
							<a href="javascript:;" class="{!! $class !!} updatefeature" data-activity="{{ $record->activity_id}}" data-city="{{ $record->activity_city }}">{{ $value }}</a>
										

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