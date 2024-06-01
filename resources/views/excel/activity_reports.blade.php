
<table>
    <tbody>
        <tr>
            <th><b>Activity Report</b></th>
        </tr>
        <tr>
            <th>Activity Name</th>
            <th>Status</th>
            <th>Connected Via</th>
            <th>Date</th>
            <th>Regular Price</th>
            <th>Discount Price</th>
            <th>Corporate Discount Price</th>
            <th>Experience booking starting from (days)</th>
        </tr>
        @foreach($results as $result)
            <tr>
                <td>{{ $result['name'] }}</td>
                <td>{{ $result['status'] }}</td>
                <td>{{ $result['via'] }}</td>
                <td>{{ $result['date'] }}</td>
                <td>{{ $result['regular_price'] }}</td>
                <td>{{ $result['discount_price'] }}</td>
                <td>{{ $result['corporate_discount_price'] }}</td>
                <td>{{ $result['start_day'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

