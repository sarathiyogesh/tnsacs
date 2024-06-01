<style type="text/css">
	table.loading tbody {
	    position: relative;
	}
	table.loading tbody:after {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.1);
    background-image: url('/backend/assets/img/loading.jpg');
    background-position: center;
    background-repeat: no-repeat;
    background-size: 50px 50px;
    content: "";
}
</style>
@if(count($records) > 0)
<div class="table-responsive">
	<table id="myTable" class="table table-striped table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Image</th>
				@if($options['select'] != 'yes')
					<th>Copy Link</th>
					<th>Copy ID</th>
				@endif
				<th>Created At</th>
				@if($options['select'] == 'yes')
					<th>Choose</th>
				@endif
				@if($options['delete'] == 'yes')
					<th class="sort-alpha">Actions</th>
				@endif
			</tr>
		</thead>
		<tbody>
			<?php $i = 1; ?>
			@foreach($records as $record)
				<tr class="gradeX">
					<td>{!! $i !!}</td>
					<td>{!! $record->file_name !!}.{!! $record->file_extension !!}</td>
					<td><img src="{!! asset($record->image_link) !!}" style="width:50px;"></td>
					@if($options['select'] != 'yes')
						<td><a href="javascript:;" class="copyMediaLink" data-url="{!! asset($record->image_link) !!}"><i class="fa fa-copy" style="font-size:20px;"></i></a></td>
						<td><a href="javascript:;" class="copyMediaId" data-id="{!! $record->id !!}"><i class="fa fa-copy" style="font-size:20px;"></i></a></td>
					@endif
					<td>{!! date('d-M-Y H:i:s', strtotime($record->created_at)) !!}</td>
					@if($options['select'] == 'yes')
						<td><a href="javascript:;" class="btn btn-sm btn-primary chooseImage" data-url="{!! asset($record->image_link) !!}" data-id="{!! $record->id !!}">Select</a></td>
					@endif
					@if($options['delete'] == 'yes')
						<td>
							<button type="button" class="btn btn-icon-toggle mediaDelete" data-toggle="tooltip" data-placement="top" data-original-title="Delete row" data-id="{!! $record->id !!}"><i class="fa fa-trash-o"></i></button>
						</td>
					@endif	
				</tr>
			<?php $i++; ?>
			@endforeach
		</tbody>
	</table>
	<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
    <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
    </div>
	<div class="custom-pagination pagination media_pagination">
        {{ $records->links() }}
    </div>
</div><!--end .table-responsive -->
@else
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="alert alert-info text-center">
                <i class="icon icon-information"></i>
                <b>No Record Available</b>
            </div>
        </div>
    </div>
@endif