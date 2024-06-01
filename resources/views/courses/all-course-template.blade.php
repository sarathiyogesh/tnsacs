<?php 
	use App\Models\Category;
	use App\Models\Subject;
	use App\Models\Courseprice;
?>
<style type="text/css">
	div.loading div {
	    position: relative;
	}
	div.loading div:after {
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
<!--begin::Card body-->
<div class="row d-flex justify-content-end mb-3">
	<div class="col-md-6 filters">
		<div class="d-flex align-items-center justify-content-end">
			<div class="me-3">Sort By:</div>
			<div>
				<a href="javascript:;" class="active"><i class="las la-border-all"></i></a>
				<a href="javascript:;"><i class="las la-list"></i></a>
			</div>
		</div>
	</div>
</div>

<div class="row" id="coursesection">
	@foreach($records as $record)
		<div class="col-md-4 mb-5">
			<div class="course-container">
				<div class="course-status">
					@if($record->status == 'active')
						<div class="btn btn-success btn-xs mb-2">Active</div>
					@else
						<div class="btn btn-danger btn-xs mb-2">{!!ucfirst($record->status) !!}</div>
					@endif
				</div>
				<div><a href="{!! url('/courses/view-course/'.$record->id)  !!}"><img src="{!!asset($record->image) !!}" class="image"></a></div>
				<div class="course-inner">
					<h4>{!!$record->course_name !!}</h4>
					<div class="section-text">
						{!! strip_tags(mb_strimwidth($record->description, 0, 100, "...")) !!}
					</div>
					<hr>
					<div class="fs-8">Available:</div>
					<?php 
						$course_price = Courseprice::where('course_id',$record->id)->where('status','!=','deleted')->get();
					?>
					@foreach($course_price as $price)
						<div class="course-fee">{!!$price->price_label !!} ({!!date("M", mktime(0, 0, 0, $price->from_month, 10)) !!} to {!!date("M", mktime(0, 0, 0, $price->to_month, 10)) !!}) - <i class="las la-rupee-sign"></i> {!!number_format($price->amount,2) !!}</div>
					@endforeach
				</div>
			</div>
		</div>
	@endforeach
</div>

<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
<input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
<input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
</div>
<div class="custom-pagination pagination">
    {!! $records->links()  !!}
</div>
<!--end::Card body-->