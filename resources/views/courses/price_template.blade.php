<h3>Price List</h3>
<hr>
@foreach($prices as $price)
<div class="course-semester">
	<div class="row d-flex align-items-center">
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="required form-label">Pricing Label</label>
						<input type="text" name="priceLabel_{{$price->id}}" id="priceLabel_{{$price->id}}" class="form-control mb-2" placeholder="Pricing Label (Ex. 1st Semester)" value="{{$price->price_label}}">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="required form-label">Institute Amount</label>
						<input type="text" name="courseAmount_{{$price->id}}" id="courseAmount_{{$price->id}}" class="form-control mb-2" placeholder="Amount" value="{{$price->amount}}">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="required form-label">Student Amount</label>
						<input type="text" name="studentAmount_{{$price->id}}" id="studentAmount_{{$price->id}}" class="form-control mb-2" placeholder="Amount" value="{{$price->student_amount}}">
					</div>
				</div>
				<div class="col-md-6">
					<b>From:</b>
					<div class="row">
						<div class="col-md-7">
							<div class="form-group selectDiv">
								<label class="required form-label">Select</label>
								<?php 
									$months = array(
										    'January',
										    'February',
										    'March',
										    'April',
										    'May',
										    'June',
										    'July ',
										    'August',
										    'September',
										    'October',
										    'November',
										    'December',
										);
									?>
								<select class="form-control" name="fromMonth_{{$price->id}}" id="fromMonth_{{$price->id}}">
									<option value="">Select Month</option>
									@foreach($months as $k=>$v)
										<option value="{{$k+1}}" @if($k+1 == $price->from_month) selected @endif>{{$v}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group selectDiv">
								<label class="required form-label">Select Year</label>
								<select class="form-control" name="fromYear_{{$price->id}}" id="fromYear_{{$price->id}}">
									<option value="">Select</option>
									@for($i=0; $i<=4; $i++)
										<?php $year = date('Y') + $i; ?>
										<option value="{{$year}}" @if($year == $price->from_year) selected @endif>{{$year}}</option>
									@endfor
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<b>To:</b>
					<div class="row">
						<div class="col-md-7">
							<div class="form-group selectDiv">
								<label class="required form-label">Select Month</label>
								<select class="form-control" name="toMonth_{{$price->id}}" id="toMonth_{{$price->id}}">
									<option value="">Select</option>
									@foreach($months as $k=>$v)
										<option value="{{$k+1}}" @if($k+1 == $price->to_month) selected @endif>{{$v}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group selectDiv">
								<label class="required form-label">Select Year</label>
								<select class="form-control" name="toYear_{{$price->id}}" id="toYear_{{$price->id}}">
									<option value="">Select</option>
									@for($i=0; $i<=4; $i++)
										<?php $year = date('Y') + $i; ?>
										<option value="{{$year}}" @if($year == $price->to_year) selected @endif>{{$year}}</option>
									@endfor
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="text-center">
				<a href="javascript:;" class="btn btn-primary btn-xs w-100px mb-2 updatePriceBtn" data-id="{{$price->id}}">Update</a>
				<a href="javascript:;" class="btn btn-danger btn-xs w-100px mb-2 removePriceBtn" data-id="{{$price->id}}">Remove</a>
			</div>
		</div>
	</div>
</div>
@endforeach
@if(count($prices) == 0)
	No result found
@endif