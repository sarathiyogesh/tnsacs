
<table>
    <tbody>
        <tr>
            <th><b>Subscribers Report</b></th>
        </tr>
        <tr>
            <th>S.No</th>
            <th>Email</th>
            <th>Status</th>
            <th>Created at</th>
        </tr>
        <?php $i=1; ?>
        @foreach($records as $record)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $record->email }}</td>
                <td>{{ $record->status }}</td>
                <td>{{ $record->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

