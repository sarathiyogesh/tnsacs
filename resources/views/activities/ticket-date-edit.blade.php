@extends("master")
@section('styles')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style type="text/css">
	.ui-datepicker{
		width:100% !important;
		font-family: Poppins, Helvetica, sans-serif;
	}
	.ui-datepicker.ui-datepicker-multi{
		width:50% !important;
		font-family: Poppins, Helvetica, sans-serif;
	}
	.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button:active {
	    border: none;
	    background: #f6f6f6;
	    font-weight: normal;
	    color: #454545;
	  }
	  .ui-state-disabled:active
	  {
	  	background:#000;
	  }
	.ui-datepicker .ui-datepicker-calendar .ui-state-highlight a{
		background: #b01a1e;
		color:white;
		font-size:15px;
	}
	.ui-datepicker td span, .ui-datepicker td a {
	    display: block;
	    padding: 14px;
	    font-size: 20px;
	    text-align: center;
	    text-decoration: none;
	}
	.ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight a {
	    border: none;
	    background: white;
	    color: #000000;
	}
</style>
@endsection
@section('maincontent')
	<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<!--begin::Toolbar-->
		<div class="toolbar" id="kt_toolbar">
			<!--begin::Container-->
			<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
				<!--begin::Page title-->
				<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
					<!--begin::Title-->
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">{{ $activity->activity_name }} - Update Ticket Dates</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{ url('/activities/ticket/'.$activity->activity_id) }}" class="btn btn-sm btn-primary" >View Tickets</a>
				</div>
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<div id="kt_content_container" class="container-xxl">

				<div class="card card-flush mb-20">
					<!--begin::Card body-->
					<div class="card-body">
						<!--begin::Table-->
						

						<div class="box-body mb-10">
				       <div id="dateextraOption" class="mb-20" style="display:none">
				          <div class="box box-primary">
						            <div class="box-body">
						            	<div class="row">
						            		<div class="col-md-4">
						            			<div class="box-header with-border">
									              <h3 class="box-title">Date Range</h3>
									            </div>
									            <br>
						            			<div class="form-group">
								            		<label>From Date</label>
											      	<input type="text" class="form-control input-sm" placeholder="From Date" name="date_from" id="date_from" autocomplete="off">
											    </div>
											    <div class="form-group">
											    	<label>To Date</label>
											      	<input type="text" class="form-control input-sm" placeholder="To Date" name="date_to" id="date_to" autocomplete="off">
											    </div>
						            		</div>
						            		<div class="col-md-3">
						            			<div class="box-header with-border">
									              <h3 class="box-title">Except</h3>
									            </div>
						            			<div class="checkbox">
								                    <label>
								                      <input type="checkbox" class="exceptDay" name="exceptDay[]" id="exceptDay" value="Monday"> Monday
								                    </label>
								                 </div>
								                 <div class="checkbox">
								                    <label>
								                      <input type="checkbox" class="exceptDay" name="exceptDay[]" id="exceptDay" value="Tuesday"> Tuesday
								                    </label>
								                 </div>
								                 <div class="checkbox">
								                    <label>
								                      <input type="checkbox" class="exceptDay" name="exceptDay[]" id="exceptDay" value="Wednesday"> Wednesday
								                    </label>
								                 </div>
								                 <div class="checkbox">
								                    <label>
								                      <input type="checkbox" class="exceptDay" name="exceptDay[]" id="exceptDay" value="Thursday"> Thursday
								                    </label>
								                 </div>
								                 <div class="checkbox">
								                    <label>
								                      <input type="checkbox" class="exceptDay" name="exceptDay[]" id="exceptDay" value="Friday"> Friday
								                    </label>
								                 </div>
								                 <div class="checkbox">
								                    <label>
								                      <input type="checkbox" class="exceptDay" name="exceptDay[]" id="exceptDay" value="Saturday"> Saturday
								                    </label>
								                 </div>
								                 <div class="checkbox">
								                    <label>
								                      <input type="checkbox" class="exceptDay" name="exceptDay[]" id="exceptDay" value="Sunday"> Sunday
								                    </label>
								                 </div>
						            		</div>
						            		<div class="col-md-3">
						            			<div class="box-header with-border">
									              <h3 class="box-title">Only</h3>
									            </div>
						            			<div class="checkbox">
								                    <label>
								                      <input type="checkbox" class="onlyDay" name="onlyDay[]" id="onlyDay" value="Monday"> Monday
								                    </label>
								                 </div>
								                 <div class="checkbox">
								                    <label>
								                      <input type="checkbox" class="onlyDay" name="onlyDay[]" id="onlyDay" value="Tuesday"> Tuesday
								                    </label>
								                 </div>
								                 <div class="checkbox">
								                    <label>
								                      <input type="checkbox" class="onlyDay" name="onlyDay[]" id="onlyDay" value="Wednesday"> Wednesday
								                    </label>
								                 </div>
								                 <div class="checkbox">
								                    <label>
								                      <input type="checkbox" class="onlyDay" name="onlyDay[]" id="onlyDay" value="Thursday"> Thursday
								                    </label>
								                 </div>
								                 <div class="checkbox">
								                    <label>
								                      <input type="checkbox" class="onlyDay" name="onlyDay[]" id="onlyDay" value="Friday"> Friday
								                    </label>
								                 </div>
								                 <div class="checkbox">
								                    <label>
								                      <input type="checkbox" class="onlyDay" name="onlyDay[]" id="onlyDay" value="Saturday"> Saturday
								                    </label>
								                 </div>
								                 <div class="checkbox">
								                    <label>
								                      <input type="checkbox" class="onlyDay" name="onlyDay[]" id="onlyDay" value="Sunday"> Sunday
								                    </label>
								                 </div>
						            		</div>
						            	</div>
						            	<a href="javascript:;" class="btn-sm btn btn-primary" id="setfromtodate">Submit</a>
						            </div>
						      </div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="ticket_date" style="margin-bottom:10px">
					              		<a href="javascript:;" class="btn btn-info btn-sm" id="showextraoption">Option</a>
					              		<a href="javascript:;" class="btn btn-default btn-sm" id="clearextraoption">Clear</a>
				                    </div>
					              	<div id="ticket_date_dev" class="cus-calendar-width"></div>
					             	<input type="hidden" name="ticket_date" id="ticket_date">
								</div>
								<div class="col-md-6">
									<div class="box box-success">
							            <div class="box-header with-border">
							              <h3 class="box-title">Selected Dates</h3>
							            </div>
							            <div class="box-body" style="overflow-y:scroll; height:360px">
							            	<div class="todo-list" id="ticket_selecteddate_dev"></div>
							              <h4 id="ticket_selecteddate_dev1" class="cus-calendar-width" style="color:#b01a1e"></h4>
							            </div>
							         </div>
								</div>
							</div>
						</div>

						<div class="box box-info mb-10">
		            <div class="box-header with-border">
		              <h3 class="box-title">Time Slot(s)</h3>
		            </div>
		            <div class="box-body">
		            	@if(count($timeslots) > 0)
		            		@foreach($timeslots as $slot)
				            	<div class="row d-flex align-items-center timeslotDiv mb-5">
				            		<div class="col-md-5">
				            			<div class="form-group mb-0">
				            				<select name="ticket_fromtime" class="form-control ticket_fromtime">
				            					<option value="">Select</option>
				            					@foreach($time as $val => $label)
				            						<option value="{{$val}}" @if($slot->from_slot == $val) selected @endif>{{ $label }}</option>
				            					@endforeach
				            				</select>
	                            		</div>
				            		</div>
				            		<div class="col-md-5">
				            			<div class="form-group mb-0">
							            	<select name="ticket_totime" class="form-control ticket_totime">
				            					<option value="">Select</option>
				            					@foreach($time as $val => $label)
				            						<option value="{{$val}}" @if($slot->to_slot == $val) selected @endif>{{ $label }}</option>
				            					@endforeach
				            				</select>
			                            </div>
				            		</div>
				            		<div class="col-md-2">
				            			<a href="javascript:;" class="addTimeslot btn btn-primary btn-xs"><i class="fa fa-plus-circle" ></i> Add</a>
			              			<a href="javascript:;" class="deleteTimeslot btn btn-secondary btn-xs" style="display:none;"><i class="fa fa-minus-circle"></i> Delete</a>
				            		</div>
				            	</div>
				            @endforeach
			            @else
			            	<div class="row timeslotDiv">
			            		<div class="col-md-5">
			            			<div class="form-group">
			            				<select name="ticket_fromtime" class="form-control ticket_fromtime">
			            					<option value="">Select</option>
			            					@foreach($time as $val => $label)
			            						<option value="{{$val}}">{{ $label }}</option>
			            					@endforeach
			            				</select>
                            		</div>
			            		</div>
			            		<div class="col-md-5">
			            			<div class="form-group">
						            	<select name="ticket_totime" class="form-control ticket_totime">
			            					<option value="">Select</option>
			            					@foreach($time as $val => $label)
			            						<option value="{{$val}}">{{ $label }}</option>
			            					@endforeach
			            				</select>
		                            </div>
			            		</div>
			            		<div class="col-md-2">
			            			<a href="javascript:;" class="addTimeslot" style="font-size:18px;"><i class="fa fa-plus-circle" ></i></a>
		              				<a href="javascript:;" class="deleteTimeslot" style="font-size:18px;color:red;display:none;"><i class="fa fa-minus-circle"></i></a>
			            		</div>
			            	</div>
			            @endif
		            </div>
		        </div>

		        <div class="box">
		            <div class="box-header with-border">
		              <h3 class="box-title">Status</h3>
		            </div>
		            <div class="box-body">
		            	<div class="row">
		            		<div class="col-md-5">
		            			<div class="form-group">
		            				<select name="status" id="status" class="form-control">
		            					<option value="">Select status</option>
		            					<option value="active" @if($ticketInfo->status == 'active') selected @endif>Active</option>
		            					<option value="inactive" @if($ticketInfo->status == 'inactive') selected @endif>Inactive</option>
		            				</select>
                        		</div>
		            		</div>
		            	</div>
		            </div>
		        </div>

				        <div class="d-flex justify-content-end py-6">
							<a href="/activities/ticket/dates/{{$activity->activity_id}}/{{$ticketInfo->id}}/edit" class="btn btn-light btn-active-light-primary me-2">Reset</a>
							<button type="button" class="btn btn-primary" id="updateticketdates">Update Ticket Dates</button>
						</div>

						<div class="alert alert-danger errorMsg-show" style="display:none;"></div>
						<div class="alert alert-success successMsg-show" style="display:none;"></div>


					<!--end::Card body-->
				</div>
			</div>
		</div>
		<!--end::Post-->

		<!--end::Help drawer-->
	</div>
	<!--end::Content-->

	
@endsection

@section('scripts')
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="{{ asset('/js/jquery-ui.multidatespicker.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			var ticket_date = "{{ $ticketInfo->ticket_date}}";
			var selected_dates = ticket_date.split(', ');
			$( "#ticket_date_dev" ).multiDatesPicker({
				dateFormat: 'yy-mm-dd',
				altField: '#ticket_date',
				minDate: 0, // today
				maxDate: 180, // +30 days from today
				addDates: selected_dates,
				onSelect: function() {
			        showselecteddate();
			    }
			});

			function showselecteddate(){
				var date = $('#ticket_date').val();
				$('#ticket_selecteddate_dev').text(date);
			}

			$( "#date_from" ).datepicker({
			    changeMonth: true,
			    dateFormat:'yy-mm-dd',
			    numberOfMonths: 2,
			    onClose: function( selectedDate ) {
			    $( "#date_to" ).datepicker( "option", "minDate", selectedDate );
			    }
			});
			$( "#date_to" ).datepicker({
				dateFormat:'yy-mm-dd',
				changeMonth: true,
				numberOfMonths: 2,
				onClose: function( selectedDate ) {
				$( "#date_from" ).datepicker( "option", "maxDate", selectedDate );
				}
			});

			$('.exceptDay').on('click', function(){
				$('.onlyDay').prop('checked', false);
			});

			$('.onlyDay').on('click', function(){
				$('.exceptDay').prop('checked', false);
			});

			$('#showextraoption').on('click', function(){
				$('#dateextraOption').slideToggle();
			});

			$('#clearextraoption').on('click', function(){
			    $('#ticket_date_dev').multiDatesPicker('resetDates','picked');
			   	$('#ticket_date').val('');
			    showselecteddate();
			});

			//Update ticket date
			
			$('#ticket_date').val(ticket_date);
			showselecteddate();

			

			//Find date range
			$(document).on('click', '#setfromtodate', function(){
				var exceptday = [];
		        $('.exceptDay:checked').each(function () {
		           exceptday.push($(this).val());
		        });
		        var onlyday = [];
		        $('.onlyDay:checked').each(function () {
		           onlyday.push($(this).val());
		        });
				var from = $('#date_from').val();
				var to = $('#date_to').val();
			    $.ajax({
			        url: '/activities/ticket/get/date',
			        data: { from:from, to:to, exceptday:exceptday, onlyday:onlyday },
			        dataType: 'json',
			        type: 'GET',
			        success: function (res){
			            if(res.status == 'success'){
							dateRange = res.dateRange;
							//reset
							$('#ticket_date_dev').multiDatesPicker('destroy');
				            $('#ticket_date_dev').multiDatesPicker('resetDates','picked');
				            $('#ticket_date').val('');
				            //reset
							$('#ticket_date').val(dateRange);
							var dates = dateRange.split(', ');
							console.log(dates);
							$('#ticket_date_dev').multiDatesPicker({
								addDates:dates,
								dateFormat: 'yy-mm-dd',
								altField: '#ticket_date',
								minDate: 0, // today
								maxDate: 180, // +30 days from today
								onSelect: function() {
							        showselecteddate();
							    }
							});
							showselecteddate();
							$('#dateextraOption').hide();
						}else if(res.status == 'validation'){
							$.each(res.validation, function(k,v){
								toastr.error(v[0]);
							});
						}else{
							toastr.error('Error processing your request. Please try again.');
						}
			            return false;
			        }, error: function(e){
			            alert(e.responseText);
			            return false;
			        }
			    });
			});

			//Clone Timeslots
			function clonetimeslot(){
				$(".addTimeslot").hide();
				$(".deleteTimeslot").hide();
				var length = $('.timeslotDiv').length;
				if(length > 1)  {
					$(".deleteTimeslot").show();
				}
				$(".addTimeslot:last").show();
			}

			clonetimeslot();


			$(document).on('click', '.addTimeslot', function(){
				$('.timeslotDiv:first').clone().insertAfter('.timeslotDiv:last');
				$('.timeslotDiv:last').find("input[type='text']").val('');
				clonetimeslot();
				return false;
			});

			$(document).on('click', '.deleteTimeslot', function(){
		       $(this).closest(".timeslotDiv").remove();
		       clonetimeslot();
		       return false;
		    });

		    //Find date range
			$(document).on('click', '#updateticketdates', function(){
				var dates = $('#ticket_date').val();
				var activityId = "{{$activity->activity_id}}";
				var ticket_id = "{{ $ticketInfo->id }}";
				var status = $('#status').val();
				var timeslots = [];
				$('.timeslotDiv').each(function(){
					var array = [];
					var slotdiv = $(this);
					var from_time = slotdiv.find('.ticket_fromtime').val();
					var to_time = slotdiv.find('.ticket_totime').val();
					array = {from_time: from_time, to_time: to_time};
					timeslots.push(array);
				});
				var strtimeslots = '';
				if(timeslots.length > 0){
					strtimeslots = JSON.stringify(timeslots);
				}
				$('.errorMsg-show').hide();
				$('.successMsg-show').hide();
			    $.ajax({
			        url: '/activities/ticket/update/dates',
			        data: { dates:dates, timeslots:strtimeslots, activity_id: activityId, status: status, ticket_id: ticket_id },
			        dataType: 'json',
			        type: 'GET',
			        success: function (res){
			            if(res.status == 'success'){
			            	$('.errorMsg-show').hide();
							$('.successMsg-show').show().text('Ticket date & timeslot details updated.');
						}else if(res.status == 'validation'){
							$.each(res.validation, function(k,v){
								toastr.error(v[0]);
							});
						}else{
							toastr.error('Error processing your request. Please try again.');
						}
			            return false;
			        }, error: function(e){
			            alert(e.responseText);
			            return false;
			        }
			    });
			});
		});

	</script>
@endsection