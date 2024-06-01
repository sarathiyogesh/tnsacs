@extends("master")

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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Subscription Report</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<div id="kt_content_container" class="container-xxl">

				<div class="card card-flush mb-4">
					<div class="card-header py-5 gap-2 gap-md-5">
						<div class="card-header-title">Search by Filter</div>
						<!--begin::Search-->
						<form method="GET" action="">
							<div class="row">
								<div class="col-md-2">
									<div class="d-flex align-items-center position-relative">
										<input type="text" autocomplete="off" class="form-control form-control-solid" placeholder="Subscription From" id="booking_from" name="booking_from" value="<?php if(isset($_GET['booking_from']) && $_GET['booking_from'] != ''){ echo $_GET['booking_from']; } ?>">
									</div>
								</div>
								<div class="col-md-2">
									<div class="d-flex align-items-center position-relative">
										<input type="text" autocomplete="off" class="form-control form-control-solid" placeholder="Subscription To" id="booking_to" name="booking_to" value="<?php if(isset($_GET['booking_to']) && $_GET['booking_to'] != ''){ echo $_GET['booking_to']; } ?>">
									</div>
								</div>
								<div class="col-md-2">
									<div class="d-flex align-items-center position-relative">
										<input type="text" class="form-control form-control-solid" placeholder="Subscription ID" id="booking_id" name="booking_id" value="<?php if(isset($_GET['booking_id']) && $_GET['booking_id'] != ''){ echo $_GET['booking_id']; } ?>">
									</div>
								</div>
								<div class="col-md-3">
									<div class="d-flex align-items-center position-relative">
										<input type="text" class="form-control form-control-solid" placeholder="Email" id="email" name="email" value="<?php if(isset($_GET['email']) && $_GET['email'] != ''){ echo $_GET['email']; } ?>">
									</div>
								</div>
								<div class="col-md-3">
									<div class="d-flex align-items-center position-relative">
										<input type="text" class="form-control form-control-solid" placeholder="Phone Number" id="phonenumber" name="phonenumber" value="<?php if(isset($_GET['phonenumber']) && $_GET['phonenumber'] != ''){ echo $_GET['phonenumber']; } ?>">
									</div>
								</div>
								<div class="col-md-2 mt-2">
									<button type="submit" class="btn btn-primary btn-sm">Search</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="card card-flush">
					<!--begin::Card body-->
					<div class="card-body">
						<!--begin::Table-->
						<div class="alert alert-danger errorMsg-show" style="display:none;"></div>
						<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="kt_ecommerce_products_table scroll-x">
							<!--begin::Table head-->
							<thead>
								<!--begin::Table row-->
								<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
								   <th class="w-10px pe-2" rowspan="1" colspan="1" aria-label="">S.No</th>
								   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">ID</th>
								   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Institution</th>
								   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Purchased On</th>
								   <th class="min-w-100px" tabindex="0" rowspan="1" colspan="1">Course(s)</th>
								   <th class="min-w-70px" rowspan="1" colspan="1">Status</th>
								   <th class="min-w-70px" rowspan="1" colspan="1">Action</th>
								</tr>
								<!--end::Table row-->
							</thead>
							<!--end::Table head-->
							<!--begin::Table body-->
							<tbody>
								<tr>
									<td>1</td>
									<td>OR20230102</td>
									<td>SDNB Vaishnav College Women</td>
									<td>02-Jan-2024</td>
									<td>Tamil Ariviyal - 1st Semester (Jan - Jun)</td>
									<td><span class="btn btn-success btn-xs">Completed</span></td>
									<td><a href="javascript:;" title="Edit"><i class="las la-eye fs-4 text-red"></i> View</a></td>
								</tr>
								<tr>
									<td>2</td>
									<td>OR20230102</td>
									<td>SDNB Vaishnav College Women</td>
									<td>02-Jan-2024</td>
									<td>Tamil Ariviyal - 2nd Semester (Jul - Dec)</td>
									<td><span class="btn btn-warning btn-xs">For Renewal</span></td>
									<td><a href="javascript:;" title="Edit"><i class="las la-eye fs-4 text-red"></i> View</a></td>
								</tr>
								<tr>
									<td>3</td>
									<td>OR20230102</td>
									<td>SDNB Vaishnav College Women</td>
									<td>02-Jan-2024</td>
									<td>Tamil Ariviyal - 2nd Semester (Jul - Dec)</td>
									<td><span class="btn btn-danger btn-xs">Expired</span></td>
									<td><a href="javascript:;" title="Edit"><i class="las la-eye fs-4 text-red"></i> View</a></td>
								</tr>
							</tbody>
							<!--end::Table body-->
						</table>
					</div>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){

			$('#booking_from, #booking_to').datepicker({
				format: 'dd-mm-yyyy'
			});

			$('.completeStatus').on('click', function(){
			    var th = $(this);
			    var id = $(this).val();
			    var con = confirm('Do you want to change status?');
			    if(con == false){
			       return false;
			    }
			    if(th.prop('checked') == true){
			        var ch = 'yes';
			    }else{
			        var ch = 'no';
			    }
			    $.ajax({
			        url: '/report/ticket/updateticketstatus',
			        data: { id:id,ch:ch },
			        dataType: 'json',
			        type: 'POST',
			        success: function (res){
			            if(res.status == 'success'){
			                alert('Stauts Updated');
			            }else{
			                alert(res.msg);
			            }
			            return false;
			        }, error: function(e){
			            alert(e.responseText);
			            return false;
			        }
			    });
			});

		
			$('.completeBooking').on('click', function(){
			    var th = $(this);
			    th.text('Please wait...');
			    var id = $(this).attr('data-id');
			    var con = confirm('Do you want to complete booking?');
			    if(con == false){
			        th.text('Complete Booking');
			       return false;
			    }
			    $('#completebookingaction_'+id).hide();
			    $('#completebookinghide_'+id).show();

			    //th.prop('disabled', true);
			    $.ajax({
			        url: '/report/ticket/complete/booking',
			        data: { id:id },
			        dataType: 'json',
			        type: 'GET',
			        success: function (res){
			            if(res.status == 'success'){
			                alert('Ticket booking completed.');
			                $('#searchBtn').click();
			            }else{
			                $('#completebookingaction_'+id).show();
			                $('#completebookinghide_'+id).hide();
			                th.text('Complete Booking');
			                alert(res.msg);
			            }
			            return false;
			        }, error: function(e){
			            $('#completebookingaction_'+id).show();
			            $('#completebookinghide_'+id).hide();
			            th.text('Complete Booking');
			            alert(e.responseText);
			            return false;
			        }
			    });
			});

			$('.resetBtn').on('click', function(){
			    var th = $(this);
			    var id = $(this).attr('data-id');
			    $.ajax({
			        url: '/report/ticket/resetbooking',
			        data: { id:id },
			        dataType: 'json',
			        type: 'GET',
			        success: function (res){
			            if(res.status == 'success'){
			                alert('Reset done');
			            }else{
			                alert(res.msg);
			            }
			            return false;
			        }, error: function(e){
			            alert(e.responseText);
			            return false;
			        }
			    });
			});

			$('#autoProcess').on('click', function(){
			    var c = 'no';
			    if ($('#autoProcess').is(":checked")){
			      c = 'yes';
			    }
			    $.ajax({
			        url: '/report/ticket/autoprocess/setting',
			        data: { c:c },
			        dataType: 'json',
			        type: 'GET',
			        success: function (res){
			            if(res.status == 'success'){
			                alert('Status updated');
			            }else{
			                alert('Error. Please try again');
			            }
			            return false;
			        }, error: function(e){
			            alert(e.responseText);
			            return false;
			        }
			    });
			});

			$('.apiSendTicket').on('click', function(){
			    var id = $(this).attr('data-id');
			    var email = $(this).attr('data-email');
			    $('#apiSendTicketModal').modal('show');
			    $('#ticketOrderId').val(id);
			    $('#ticket_email').val(email)
			    return false;
			});

			$(document).on('click', '#sendticketbtn', function(){
			    var id = $('#ticketOrderId').val();
			    var email = $('#ticket_email').val();
			    if(id && email){
			        var th = $(this);
			        th.text('Please wait...');
			        $.ajax({
			            url: '/report/ticket/api/sendticket',
			            data: { id:id, email:email },
			            dataType: 'json',
			            type: 'GET',
			            success: function (res){
			                if(res.status == 'success'){
			                    th.text('Submit');
			                    $('#apiSendTicketModal').modal('hide');
			                    alert('Ticket sent successfully.');
			                }else{
			                    alert(res.msg);
			                }
			                return false;
			            }, error: function(e){
			                th.text('Send Ticket');
			                alert(e.responseText);
			                return false;
			            }
			        });
			    }
			});

			$(document).on('click','.viewOptionId', function(){
			    var id = $(this).attr('data-id');
			    $.ajax({
			        url: '/report/ticket/viewoptionids',
			        data: { id:id },
			        dataType: 'json',
			        type: 'GET',
			        success: function (res){
			            if(res.status == 'success'){
			                $('#showOptionIdBox').html(res.template);
			                $('#updateOptionIdModal').modal('show');
			            }else{
			                alert(res.msg);
			            }
			            return false;
			        }, error: function(e){
			            alert(e.responseText);
			            return false;
			        }
			    });
			});

			$(document).on('click','.updateOptionId', function(){
			    var id = $(this).attr('data-id');
			    var v = $('#option_'+id).val();
			    if(!v){
			        alert('Error. Please try again'); return false;
			    }
			    $.ajax({
			        url: '/report/ticket/updateoptionid',
			        data: { id:id,option_id: v },
			        dataType: 'json',
			        type: 'GET',
			        success: function (res){
			            if(res.status == 'success'){
			                alert('Updated');
			                $('#updateOptionIdModal').modal('hide');
			            }else{
			                alert(res.msg);
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