<?php
	use App\Models\user;
	use App\Models\Category;
	use App\Models\Course;
?>
<table>
	<thead>
		<tr>
		   <th>Subscription ID</th>
		   <th>Institution</th>
		   <th>Student</th>
		   <th>Course Name</th>
		   <th>Category</th>
		   <th>Plan</th>
		   <th>Purchased Date</th>
		   <th>Amount</th>
		</tr>
	</thead>
	<tbody>
		@foreach($records as $record)
			<tr>
                <td>{{ $record->unique_id }}</td>
                <td>{{ User::getName($record->institution_id) }}</td>
                <td>
                	{{ User::getName($record->user_id) }}<br>
                	{{ User::getuserdetails($record->user_id, 'email') }}<br>
                	{{ User::getuserdetails($record->user_id, 'rollno') }}
                </td>
                <td>{{ Course::getname($record->course_id) }}</td>
                <td>{{ Category::getname($record->category) }}</td>
                <td>{{ date('d-M-Y', strtotime($record->start_date)) }} to {{ date('d-M-Y', strtotime($record->end_date)) }}</td>
                <td>{{ date('d-M-Y', strtotime($record->purchase_date)) }}</td>
                <td>{{ $record->total_amount }}</td>
            </tr>
		@endforeach
	</tbody>
</table>