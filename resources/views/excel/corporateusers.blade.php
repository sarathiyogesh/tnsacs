
<table>
    <tbody>
        <tr>
            <th><b>Corporate Users Report</b></th>
        </tr>
        <tr>
            <th>S.No</th>
            <th>Name</th>
            <th>Registered Email</th>
            <th>Corporate Email</th>
            <th>Discount Expiry</th>
            <th>Status</th>
            <th>Organization</th>
            <th>Domain</th>
            <th>Organization Status</th>
            <th>Organization Expiry</th>

        </tr>
        <?php $i=1; ?>
        @foreach($records as $record)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $record->name }}</td>
                <td>{{ $record->email }}</td>
                <td>{{ $record->ca_email }}</td>
                <td>{{ $record->ca_expiry }}</td>
                <td>@if($record->ca_status) Active @else Inactive @endif</td>
                <td>{{ $record->org_name }}</td>
                <td>{{ $record->domain }}</td>
                <td>@if($record->org_status) Active @else Inactive @endif</td>
                <td>{{ $record->org_expiry }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

