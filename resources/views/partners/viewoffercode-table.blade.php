<?php 
	use App\Models\Partneroffer;
	use App\Models\Partneroffercodemeta;
	use App\Models\User;
?>
<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="kt_ecommerce_products_table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Partner</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Code</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Card Type</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Status</th>
		    @can('partner-offer-edit')
		   		<th class="min-w-70px" rowspan="1" colspan="1">Actions</th>
		   	@endcan
		</tr>
		<!--end::Table row-->
	</thead>
	<!--end::Table head-->
	<!--begin::Table body-->
	<tbody>
		@if(count($records) > 0)
			@foreach($records as $rec)
				<?php 
	            	$partner = Partneroffer::where('id',$rec->partner_id)->first();
	            	$partnerName = '';
	            	if($partner){
	            		$partnerName = $partner->partner_name;
	            	}
	            ?>
		        <tr>
					<td>{{$partnerName}}</td>
					<td>{{$rec->offer_code}}</td>
					<td>{{$rec->bank_card_type}}</td>
					<td>
						<?php
							if($rec->status == 1){
								echo 'Active';
							}else if($rec->status == 2){
								//echo 'Used ('.User::getName($rec->user_id).')';
							}else if($rec->status == 0){
								echo 'Inactive';
							}
							$metacount = Partneroffercodemeta::where('partner_code_id',$rec->id)->count();
							if($metacount != 0){
								echo ' (Used count: '.$metacount.')';
							}
						?>
					</td>
					@can('partner-offer-edit')
						<td>
							@if($rec->status != 2)
							<a href="/partner/offercode/edit/{{$rec->id}}" title="Edit"><i class="las la-edit fs-4 text-red"></i> Edit</a>
							@endif
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

<input type="hidden" name="hidden_page" id="hidden_page" value="1" />

<div class="custom-pagination pagination">
	{{ $records->links() }}
</div>