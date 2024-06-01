<?php
	use App\Models\Bookingreportsapioptions;
?>
<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="contact-message-table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
		   <th class="min-w-70px" rowspan="1" colspan="1" aria-label="">S.No</th>
		   <th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">Invoice Number</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Reference No.</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">PG Reference No</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Customer Name</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">User Type</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Organization Name</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Ticket From</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Email</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Invoice Date</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Product</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Product Description</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Quantity Purchased</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Adult Rate</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Child Rate</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">All Age Rate</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Rayna Adult Price</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Rayna Child Price</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Rayna Allage Price</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Rayna Total Price</th>
		   <th class="min-w-70px" rowspan="1" colspan="1">Total Amount</th>

		</tr>
		<!--end::Table row-->
	</thead>
	<!--end::Table head-->
	<!--begin::Table body-->
	<tbody>
		@if(count($records) > 0)
					<?php $i=1; ?>
			@foreach($records as $record)
				<?php
                    $rayna_adult_price = $record->rayna_adult_price;
                    $rayna_child_price = $record->rayna_child_price;
                    $rayna_allage_price = $record->rayna_adult_price;
                    $rayna_total_price = $record->rayna_total_price;
                    $options = Bookingreportsapioptions::where('bookingreportId', $record->breportId)->count();
                    if($options > 0){
                        $rayna_adult_price = Bookingreportsapioptions::where('metaId', $record->metaId)->sum('rayna_adult_price');
                        $rayna_child_price = Bookingreportsapioptions::where('metaId', $record->metaId)->sum('rayna_child_price');
                        $rayna_allage_price = Bookingreportsapioptions::where('metaId', $record->metaId)->sum('rayna_allage_price');
                        $rayna_total_price = Bookingreportsapioptions::where('metaId', $record->metaId)->sum('rayna_total_price');
                    }
                ?>
				<tr>
					<td>{{ $i++ }}</td>
                    <td>{{ $record->bookingId }}</td>
                    <td>{{ $record->reference_no }}</td>
                    <td>{{ $record->pg_charge_ref_no }}</td>
                    <td>{{ $record->fullname }}</td>
                    <td>
                        <?php 
                            if($record->ca_status == 0){
                                echo 'Regular User';
                            }else if($record->ca_status == 1){
                                echo 'Corporate User';
                            }else if($record->ca_status == 2){
                                echo 'Pro User';
                            }
                            $org_name = '';
                            if($record->ca_status == 1){
                                $org = DB::table('corporates')->where('id',$record->ca_org_id)->first();
                                if($org){
                                    $org_name = $org->name;
                                }
                            }
                        ?>
                    </td>
                    <td>{{$org_name}}</td>
                    <td>{{ ucfirst($record->ticket_from) }}</td>
                    <td>{{ $record->email }}</td>
                    <td>{{ $record->bookingDate }}</td>
                    <td>{{ $record->activityName }}</td>
                    <td>{{ $record->sectionName}} - {{ $record->itemName}}</td>
                    <td>{{ $record->adultCount + $record->childCount + $record->allageCount }}</td>
                    <td>{{ $record->adultPrice }}</td>
                    <td>{{ $record->childPrice }}</td>
                    <td>{{ $record->allagePrice }}</td>
                    <td>{{ $rayna_adult_price }} </td>
                    <td>{{ $rayna_child_price }}</td>
                    <td>{{ $rayna_allage_price }}</td>
                    <td>{{ $rayna_total_price }}</td>
                    <td>{{ $record->metaTotal }}</td>
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
@if(count($records) > 0)
	<div class="custom-pagination pagination">
		{{ $records->links() }}
	</div>
@endif