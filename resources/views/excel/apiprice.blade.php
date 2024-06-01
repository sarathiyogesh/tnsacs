
<table>
    <tbody>
        <tr>
            <th><b>API Price Report</b></th>
        </tr>
        <tr>
            <th>S.No</th>
            <th>Activity Name</th>
            <th>Item Name</th>
            <th>Adult Price</th>
            <th>Child Price</th>
            <th>All Age Price</th>
            <th>Adult Price 1</th>
            <th>Child Price 1</th>
            <th>All Age Price 1</th>
            <th>API Adult Price</th>
            <th>API Child Price</th>
            <th>API All Age Price</th>
        </tr>
        <?php $i=1; ?>
        @foreach($records as $record)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $record->activity_name }}</td>
                <td>{{ $record->item_name }}</td>
                <td>{{ $record->adult_price }}</td>
                <td>{{ $record->child_price }}</td>
                <td>{{ $record->allage_price }}</td>
                <td>{{ $record->adult1_price }}</td>
                <td>{{ $record->child1_price }}</td>
                <td>{{ $record->allage1_price }}</td>
                <td>{{ $record->api_adult_price }}</td>
                <td>{{ $record->api_child_price }}</td>
                <td>{{ $record->api_allage_price }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

