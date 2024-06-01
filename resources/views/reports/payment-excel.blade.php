<?php
	use App\Models\Course;
?>
<table>
	<thead>
		<tr>
		   <th>Subscription ID</th>
		   <th>Transaction ID</th>
		   <th>Course Name</th>
		   <th>Plan</th>
		   <th>Purchased Date</th>
		   <th>Amount</th>
		</tr>
	</thead>
	<tbody>
		@foreach($records as $record)
			<tr>
                <td>{{ $record->unique_id }}</td>
                <td>{{ $record->pg_tracking_id }}</td>
                <td>{{ Course::getname($record->course_id) }}</td>
                <td>{{ date('d-M-Y', strtotime($record->start_date)) }} to {{ date('d-M-Y', strtotime($record->end_date)) }}</td>
                <td>{{ date('d-M-Y', strtotime($record->purchase_date)) }}</td>
                <td>{{ $record->total_amount }}</td>
            </tr>
		@endforeach
	</tbody>
</table>