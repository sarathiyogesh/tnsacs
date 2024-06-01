<?php 
    use App\Models\Eventbookingmeta;
?>
<table>
    <tbody>
        <tr>
            <th><b>Event Report</b></th>
        </tr>
        <tr>
            <th>Order ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Total Amount</th>
            <th>Category</th>
            <th>Section</th>
            <th>Type</th>
            <th>Row</th>
            <th>Seat</th>
            <th>Amount</th>
            <th>Barcode</th>
        </tr>
        <?php 
                $l = 0;
        ?>
        @foreach($results as $result)
            <?php 
                $meta = Eventbookingmeta::where('booking_id',$result['booking_id'])->get();
                $i = 0;
            ?>
            @foreach($meta as $m)
            <?php 
                if ($l % 2 == 0) {
                  $bcolor = '#92dea7';
                }else{
                    $bcolor = '#95a399';
                }
            ?>
            <tr>
                @if($i == 0)
                    <td>{{ $result['order_id'] }}</td>
                    <td>{{ $result['first_name'] }} {{ $result['last_name'] }}</td>
                    <td>{{ $result['email'] }}</td>
                    <td>{{ $result['phonenumber'] }}</td>
                    <td>{{ $result['total_amount'] }}</td>
                @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                @endif
                <td bgcolor="{{$bcolor}}">{{ $m['category'] }}</td>
                <td bgcolor="{{$bcolor}}">{{ $m['section'] }}</td>
                <td bgcolor="{{$bcolor}}">{{ $m['pax_type'] }}</td>
                <td bgcolor="{{$bcolor}}">{{ $m['row'] }}</td>
                <td bgcolor="{{$bcolor}}">{{ $m['seat'] }}</td>
                <td bgcolor="{{$bcolor}}">{{ $m['amount'] }}</td>
                <td bgcolor="{{$bcolor}}">{{ $m['barcode'] }}</td>
            </tr>
            <?php 
                $i++;
            ?>
            @endforeach
            <?php 
                $l++;
            ?>
        @endforeach
    </tbody>
</table>

