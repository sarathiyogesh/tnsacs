
<table>
    <tbody>
        <tr>
            <th><b>Sales By Customer Report</b></th>
        </tr>
        <tr>
            <th>S.No</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>User Type</th>
            <th>Total Tickets</th>
            <th>Total Purchased Amount</th>
        </tr>
        <?php $i=1; ?>
        @foreach($records as $record)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $record->fullname }}</td>
                <td>{{ $record->email }}</td>
                <td>
                    <?php 
                        if($record->ca_status == 0){
                            echo 'Regular User';
                        }else if($record->ca_status == 1){
                            echo 'Corporate User';
                        }else if($record->ca_status == 2){
                            echo 'Pro User';
                        }
                    ?>
                </td>
                <td>{{ $record->total_count }}</td>
                <td>{{ $record->total_amount }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

