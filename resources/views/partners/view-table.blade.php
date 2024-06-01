<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="kt_ecommerce_products_table">
	<!--begin::Table head-->
	<thead>
		<!--begin::Table row-->
		<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
		   <th class="w-10px pe-2" rowspan="1" colspan="1" aria-label="">
		      S.No.
		   </th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Staff Name</th>
		   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Photo</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Type</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Position</th>
		   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Created on</th>
		   @can('partners-edit')
		   	<th class="min-w-70px" rowspan="1" colspan="1">Actions</th>
		   @endcan
		</tr>
		<!--end::Table row-->
	</thead>
	<!--end::Table head-->
	<!--begin::Table body-->
	<tbody>
		<tr>
        	<td>1</td>
			<td>John Doe</td>
			<td>
				<img src="{!! asset('media/300-1.jpg') !!}" class="w-40px rounded-4">
			</td>
			<td>Sales</td>
			<td>Salesman</td>
			<td>Active</td>
			@can('partners-edit')
				<td>
					<a href="javascript:;" title="Edit"><i class="las la-edit fs-4 text-red"></i> Edit</a>
				</td>
			@endcan
        </tr>
        <tr>
        	<td>2</td>
			<td>Micheal Doe</td>
			<td>
				<img src="{!! asset('media/300-5.jpg') !!}" class="w-40px rounded-4">
			</td>
			<td>Sales</td>
			<td>Salesman</td>
			<td>Active</td>
			@can('partners-edit')
				<td>
					<a href="javascript:;" title="Edit"><i class="las la-edit fs-4 text-red"></i> Edit</a>
				</td>
			@endcan
        </tr>
        <tr>
        	<td>3</td>
			<td>Allen Walker</td>
			<td>
				<img src="{!! asset('media/300-21.jpg') !!}" class="w-40px rounded-4">
			</td>
			<td>Sales</td>
			<td>Salesman</td>
			<td>Active</td>
			@can('partners-edit')
				<td>
					<a href="javascript:;" title="Edit"><i class="las la-edit fs-4 text-red"></i> Edit</a>
				</td>
			@endcan
        </tr>
	</tbody>
	<!--end::Table body-->
</table>


<div class="custom-pagination pagination">
	<div class="custom-pagination pagination">
	   <nav>
	      <ul class="pagination">
	         <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
	            <span class="page-link" aria-hidden="true">‹</span>
	         </li>
	         <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
	         <li class="page-item"><a class="page-link" href="javascript:;">2</a></li>
	         <li class="page-item"><a class="page-link" href="javascript:;">3</a></li>
	         <li class="page-item">
	            <a class="page-link" href="javascript:;" rel="next" aria-label="Next »">›</a>
	         </li>
	      </ul>
	   </nav>
	</div>
</div>