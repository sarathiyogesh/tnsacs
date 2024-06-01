<?php
	use App\Models\State;
	use App\Models\Course;
	use App\Models\User;
?>
@if(count($records) > 0)
<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="kt_ecommerce_products_table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
		   <th class="w-10px pe-2" rowspan="1" colspan="1" aria-label="">
		      S.No.
		   </th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Name</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Institution</th>
		   <th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">Roll No.</th>
		   <th class="min-w-70px" tabindex="0" rowspan="1" colspan="1">Class</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Father/Mother Name</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Father/Mother Phone</th>
		   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Created on</th>
		   <th>Status</th>
		</tr>
		<!--end::Table row-->
	</thead>
	<!--end::Table head-->
	<!--begin::Table body-->
	<tbody>
		<?php $i = 0; ?>
		@foreach($records as $record)
		<tr>
        	<td>{{ ++$i }}</td>
        	<td>{{ $record->name }}</td>
        	<td>{{ User::getName($record->institution) }}</td>
			<td>{{ $record->rollno }}</td>
			<td>{{ $record->class }}</td>
			<td>{{ $record->contact_person_name }}</td>
			<td>{{ $record->contact_person_mobile }}</td>
			<td>{{ date('d/m/Y', strtotime($record->created_at))}}</td>
			<td>
				<a href="javascript:;" class="btn {{ $record->status == 'active'?'btn-success':'btn-danger' }} btn-xs">{!! ucfirst($record->status) !!}</a>
			</td>
        </tr>
        @endforeach
	</tbody>
	<!--end::Table body-->
</table>


<input type="hidden" name="hidden_page" id="hidden_page" value="1" />

<div class="custom-pagination pagination">
	{{ $records->links() }}
</div>
@else
	<div class="alert alert-danger">Records not available.</div>
@endif