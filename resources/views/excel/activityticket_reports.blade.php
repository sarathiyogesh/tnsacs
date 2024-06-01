
<table>
    <tbody>
        <tr>
            <th><b>Activity Ticket Report</b></th>
        </tr>
        <tr>
            <th>Activity Name</th>
            <th>Ticket Name</th>
            <th>Ticket Description</th>
            <!-- <th>Price Value</th> -->
            <th>Price Type</th>
            <th>Adult Price</th>
            <th>Adult 1 Price</th>
            <th>Child Price</th>
            <th>Child 1 Price</th>
            <th>Allage Price</th>
            <th>Allage 1 Price</th>
            <th>Min/Max Value</th>
            <th>Last Date Available</th>
        </tr>
        @foreach($results as $result)
            <tr>
                <td>{{ $result['activity_name'] }}</td>
                <td>{{ $result['ticket_name'] }}</td>
                <td>{{ $result['description'] }}</td>
                <td>{{ $result['price_type'] }}</td>
                <td>{{ $result['adult_price'] }}</td>
                <td>{{ $result['adult1_price'] }}</td>
                <td>{{ $result['child_price'] }}</td>
                <td>{{ $result['child1_price'] }}</td>
                <td>{{ $result['allage_price'] }}</td>
                <td>{{ $result['allage1_price'] }}</td>
                <td>{{ $result['minmax'] }}</td>
                <td>{{ $result['last_date'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

