<?php
    use App\Models\Bookingreportsapioptions;
?>
<table>
    <tbody>
        <tr>
            <th><b>Booking Report</b></th>
        </tr>
        <tr>
            <th>S.No</th>
            <th>Invoice Number</th>
            <th>Reference No.</th>
            <th>PG Reference No</th>
            <th>Customer Name</th>
            <th>User Type</th>
            <th>Organization Name</th>
            <th>Ticket From</th>
            <th>Email</th>
            <th>Invoice Date</th>
            <th>Product</th>
            <th>Product Description</th>
            <th>Quantity Purchased</th>
            <th>Adult Rate</th>
            <th>Child Rate</th>
            <th>All Age Rate</th>
            <th>Rayna Adult Price</th>
            <th>Rayna Child Price</th>
            <th>Rayna Allage Price</th>
            <th>Rayna Total Price</th>
            <th>Total Amount</th>

        </tr>
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
                <td>{{ $rayna_adult_price }}</td>
                <td>{{ $rayna_child_price }}</td>
                <td>{{ $rayna_allage_price }}</td>
                <td>{{ $rayna_total_price }}</td>
                <td>{{ $record->metaTotal }}</td>

            </tr>
        @endforeach
    </tbody>
</table>

