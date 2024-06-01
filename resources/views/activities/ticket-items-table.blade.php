<?php
	use App\Models\Ticketitem;
	use App\Models\Ticketitemapioptions;
?>
@if(count($sections) > 0)
	@foreach($sections as $section)
		<div class="box-info">
			<?php $items = Ticketitem::where('sectionId', $section->id)->orderBy('sorting')->get(); ?>
			
			<div class="d-flex align-items-center justify-content-between">
				<div><h4>{{ $section->section_name }}</h4></div>
				<div>
					<a href="javascript:;" data-id="{{ $section->id }}" data-name="{{ $section->section_name }}" class="editsection"><i class="las la-edit fs-4 text-red"></i> Edit Section</a>
					<span class="px-3 text-black-50">|</span>
					<a href="javascript:;" data-id="{{ $section->id }}" class="additem"><i class="las la-plus-circle fs-4 text-red"></i> Add Item</a>
				</div>
			</div>
			
			

			@if(count($items) > 0)
			<div class="bg-white p-3 mt-4">
				<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="kt_ecommerce_products_table">
					<!--begin::Table head-->
					<thead>
						<!--begin::Table row-->
						<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
							<th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">Item Type</th>
						   	<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Item Name</th>
						   	<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Item Description</th>
						   	<th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Tour ID</th>
						   	<th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">Option ID</th>
						   	<th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">Price Type</th>
						   	<th class="min-w-200px" rowspan="1" colspan="1">Prices (AED)</th>
						   	<th class="min-w-70px" rowspan="1" colspan="1">Minimum Ticket</th>
						   	<th class="min-w-70px" rowspan="1" colspan="1">Maximum Ticket</th>
						   	<th class="min-w-70px" rowspan="1" colspan="1">Sorting Position</th>
						   	<th class="min-w-70px" rowspan="1" colspan="1">Update</th>
						</tr>
						<!--end::Table row-->
					</thead>
					<!--end::Table head-->
					<!--begin::Table body-->
					<tbody>
						<?php $i=1; ?>
						@foreach($items as $item)
							<?php
								$options = Ticketitemapioptions::where('ticket_item_id', $item->id)->orderBy('id')->get();
								$option_type = 'Single';
								if(count($options) > 1){
									$option_type = 'Bundle';
								}
							?>
							<tr>
								<td>{{ $option_type }}</td>
			                    <td>{!! $item->item_name !!}</td>
			                    <td>{!! $item->item_desc !!}</td>
			                    @if(count($options) > 0)
			                    	<td>
				                    	@foreach($options as $option)
					                    	{!! $option->api_tour_id !!}<br/>
					                    @endforeach
					               	</td>
				                   	<td>
				                   		@foreach($options as $option)
					                    	{!! $option->api_tourOptionId !!}<br/>
					                    @endforeach
				                   	</td>
				                @else
				                	<td>&nbsp;</td>
				                	<td>&nbsp;</td>
				                @endif
			                    <td>{!! $item->price_type !!}</td>
			                    <td>
				                    @if($item->price_type == 'adult')
				                    	<b>Adult Price:</b>&nbsp;{!! $item->adult_price !!}<br/>
				                    	@if($item->adult_price1)
				                    		<b>Adult Price 1:</b>&nbsp;{!! $item->adult_price1 !!}
				                    	@endif
				                    @elseif($item->price_type == 'child')
				                    	<b>Child Price:</b>&nbsp;{!! $item->child_price !!}<br/>
				                    	@if($item->child_price1)
				                    		<b>Child Price 1:</b>&nbsp;{!! $item->child_price1 !!}
				                    	@endif
				                    @elseif($item->price_type == 'adultandchild')
				                    	<b>Adult Price:</b>&nbsp;{!! $item->adult_price !!}<br/>
				                    	@if($item->adult_price1)
				                    		<b>Adult Price 1:</b>&nbsp;{!! $item->adult_price1 !!}<br/>
				                    	@endif
				                    	<b>Child Price:</b>&nbsp;{!! $item->child_price !!}<br/>
				                    	@if($item->child_price1)
				                    		<b>Child Price 1:</b>&nbsp;{!! $item->child_price1 !!}
				                    	@endif

				                    @elseif($item->price_type == 'allage')
				                    	<b>Allage Price:</b>&nbsp;{!! $item->allage_price !!}<br/>
				                    	@if($item->allage_price1)
				                    		<b>Allage Price 1:</b>&nbsp;{!! $item->allage_price1 !!}
				                    	@endif
				                    @else
				                    	&nbsp;
				                    @endif
			                    </td>
			                    
			                    <td>{!! $item->minimum_ticket !!}</td>
			                    <td>{!! $item->maximum_ticket !!}</td>
			                    <td>{!! $item->sorting !!}</td>
			                    <td><a href="javascript:;" class="edititem" data-id="{{ $item->id }}" data-section="{{ $section->id }}">Edit</a></td>
							</tr>
						@endforeach
					</tbody>
					<!--end::Table body-->
				</table>
			</div>
			@else
				<div class="alert alert-danger">No ticket items available for this section</div>
			@endif
		</div>
	@endforeach
@else
	<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="kt_ecommerce_products_table">
		<tbody>
			<tr>
				<td colspan="12">Sections not available for this activity ticket</td>
			</tr>
		</tbody>
	</table>
@endif