<?php
	use App\Models\Bookingreportmeta;
	use App\Models\Bookingreportsapioptions;
?>
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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Ticket Details</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					
				</div>
				<!--end::Actions-->
			</div>
			<!--end::Container-->
		</div>
		<!--end::Toolbar-->
		<!--begin::Post-->
		<div class="post d-flex flex-column-fluid" id="kt_post">
			<div id="kt_content_container" class="container-xxl">
				<div class="card card-flush">
					<div class="card-body">
						<h3 class="card-title">View Ticket Details (#{{$records->bookingId}})</h3>
						<?php
                        	$meta = Bookingreportmeta::where('bookingId',$records->bookingId)->get();
                        	$pg_charge_ref_no = $records->pg_charge_ref_no;
                    	?>

					  	@foreach($meta as $me)
	                        <?php
	                        	$options = Bookingreportsapioptions::where('bookingreportId', $records->id)->where('metaId', $me->id)->orderBy('id', 'ASC')->get();
	                        ?>
						  	<div class="rightbox">
							    <div class="rb-container">
								    <ul class="rb">
								    	
								        <li class="rb-item" ng-repeat="itembx">
								          	<div class="timestamp">
								            	<div class="date">{!! date('d',strtotime($me->date)) !!}</div> {!! date('M',strtotime($me->date)) !!} {!! date('Y',strtotime($me->date)) !!} 
								            	@if($me->timeString)<span class="px-7">|</span> {{ $me->timeString }} @endif
								          	</div>
								          	<hr>
								          	<p class="item-title">Booking ID: {{$records->bookingId}}</p>
										   	<p class="item-title">Payment Reference No: {!! $pg_charge_ref_no !!}</p>
										   	<h2 class="item-title text-red mb-10">{!! $me->activity_name; !!}</h2>

										   	<table class="table table-row-dashed fs-6 gy-2 gx-2 dataTable">
											   <thead>
											      	<tr class="text-start bg-light text-gray-400 fw-bolder fs-7 text-uppercase">
											         	<th>Option ID</th>
											         	<th>Ticket Status</th>
											         	<th>Confirm Ticket</th>
											         	<th>Custom Ticket URL</th>
											         	<th>API Ticket URL</th>
											      	</tr>
											    </thead>
											    <tbody>
											    	@foreach($options as $option)
											    		<?php
		                                                    $ticket_status = 'Not Confirmed';
		                                                    $custom_ticket = '';
		                                                    if($option->ticket_url || $option->api_pnrNumber || $option->ticket_status == 'confirmed' || $option->ticket_confirmed_from == 'qrcode'){
		                                                        $ticket_status = 'Confirmed';
		                                                    }

		                                                    if($option->ticket_url || $option->api_pnrNumber || $me->ticket_confirmed_from == 'qrcode'){
		                                                        $custom_ticket = 'https://bookingbash.com/myaccount/ticket/'.Str::random(15).'Ssyz'.$records->bookingId.'Ssyz'.Str::random(15).'/'.Str::random(15).'pYys'.$option->id.'pYys'.Str::random(15);
		                                                    }
		                                                ?>
												      	<tr>
												         	<td>{{ $option->option_id }}</td>
												         	<td>
												         		@if($ticket_status == 'Confirmed')
												         			<a class="alert alert-sm alert-success" href="javascript:;">Confirmed</a>
												         		@else
												         			<a class="alert alert-sm alert-danger" href="javascript:;">Pending</a>
												         		@endif
												         	</td>
												         	@if(!$option->reservation_no || ($me->ticket_source == 'ph' && $option->ticket_status != 'confirmed'))
												         		<td>
			                                                        <a class="label label-success completeBooking"  id="completebookingaction_{{$option->id}}" data-id="{{$records->id}}" data-option-id="{{$option->id}}"  href="javascript:;">Confirm</a>
			                                                        <a class="label label-success" style="display: none;" id="completebookinghide_{{$option->id}}">Please wait...</a>
			                                                    d</td>
												         	@else
												         		<td>--</td>
												         	@endif
												         	@if($custom_ticket)
												         		<td><a class="label label-success" href="{{ $custom_ticket }}" target="_blank">View</a></td>
												         	@else
												         		<td>--</td>
												         	@endif
												         	@if($option->ticket_url)
												         		<td><a class="label label-success" href="{{ $option->ticket_url }}" target="_blank">View</a></td>
												         	@else
												         		<td>--</td>
												         	@endif
												      	</tr>
											      	@endforeach
											   </tbody>
											</table>
								        </li>

								        <li class="rb-item" ng-repeat="itembx">
								        	<div class="mt-0 mb-10">
	                                            <div class="item-title text-red fw-bold">
	                                                <i class="las la-map-marker-alt fs-3"></i>&nbsp; {!! $me->sectionName  !!} - {!! $me->itemName  !!}
	                                            </div>
	                                            <div class="timestamp">
									            	<i class="las la-calendar fs-3"></i> {!! date('d-M-Y',strtotime($me->date)) !!} <span class="px-7">|</span><i class="las la-clock fs-3"></i>  {!! $me->timeString !!}
									          	</div>

									          	<div class="card card-flush bg-light mt-5">
									          		<div class="card-body">
									          			<table class="table align-middle table-row-dashed fs-7 gy-2 dataTable no-footer">
														   <tbody>
														      <tr>
														         <td><b>Pax Count</b></td>
														         <td></td>
														      </tr>
														      @if($me->adultCount != 0)
															      <tr>
															         <td>Adult</td>
															         <td>{!! $me->adultCount !!}</td>
															      </tr>
														      @endif
														      @if($me->childCount != 0)
															      <tr>
															         <td>Child</td>
															         <td>{!! $me->childCount !!}</td>
															      </tr>
														      @endif
														      @if($me->infantCount != 0)
															      <tr>
															         <td>All Age</td>
															         <td>{!! $me->infantCount !!}</td>
															      </tr>
														      @endif
														      <tr>
														         <td><b>Buyer Details</b></td>
														         <td></td>
														      </tr>
														      	@if($me->email != '')
																    <tr>
																        <td>Name</td>
																        <td>{!! $me->fullname !!}</td>
																    </tr>
																    <tr>
																        <td>Email</td>
																        <td>{!! $me->email !!}</td>
																    </tr>
																    <tr>
																        <td>Gender</td>
																        <td>{!! $me->gender !!}</td>
																    </tr>
																    <?php $trimmednumber = trim($me->phonenumber) ?>
																    <tr>
																        <td>Phonenumber</td>
																        <td>(+{!! $records->country_code !!}) {!! $trimmednumber !!}</td>
																    </tr>
															  	@else
															  		<?php
							                                            $userprofile = DB::table('user_profile')->where('user_id',$me->userId)->first();
							                                        ?>
							                                        <tr>
																        <td>Name</td>
																        <td>{!! $records->fullname !!}</td>
																    </tr>
																    <tr>
																        <td>Email</td>
																        <td>{!! $records->email !!}</td>
																    </tr>
																    <tr>
																        <td>Gender</td>
																        <td>{!! $records->gender !!}</td>
																    </tr>
																    <?php
																    	$trimnumber= trim($records->phonenumber);
						                                                $trimnumber= str_replace(' ', '', $trimnumber);
						                                            ?>
						                                            <tr>
																        <td>Phonenumber</td>
																        <td>(+{!! $records->country_code !!}) {!! $trimnumber !!}</td>
																    </tr>
																    <?php 
																    	$whatsapp = "+" . $records->country_code . $trimnumber;
																    ?>
																    @if($records->whatsapp_country_code && trim($records->whatsapp_phonenumber))
																    	<?php 
							                                                $trimnumber= str_replace(' ', '', $records->whatsapp_phonenumber);
							                                                $whatsapp = "+" . $records->whatsapp_country_code . $trimnumber;
							                                               ?>
																	    <tr>
						                                                    <td>Whatsapp Phonenumber</td>
						                                                    <td class="text-right">(+{!! $records->whatsapp_country_code !!}) {!! $records->whatsapp_phonenumber !!}</td>
						                                                </tr>
														      		@endif

														      		<tr>
																        <td>Send Message with WhatsApp: </td>
																        <td>Message will be sent with Web WhatsApp or Desktop WhatsApp if available. <a href="https://wa.me/{!! $whatsapp !!}" target="_blank">Send WhatsApp</a></td>
																    </tr>

																    <tr>
			                                                            <?php 
			                                                            	$link = urlencode("Thank you for choosing BookingBash! Your positive experience means a lot to us and can help others discover our easy-to-use platform.\nPlease take a moment to share your experience and help us spread the word about BookingBash. \nThanks again for your support! \nhttps://g.page/r/Ca_wxgKgWxsIEB0/review");
			                                                            	$review = trim($whatsapp) . "/?text=" . $link ; 
			                                                            ?>
			                                                			<td>Send Google Review request </td>
			                                                			<td class="text-right">Google review via Whatsapp <a href="https://wa.me/{!! $review !!}" target="_blank">Ask for Review</a></td>
			                                           	 			</tr>

			                                           	 			@if(count($options) > 0)
						                                                <?php $i = 1; ?>
						                                                @foreach($options as $option)
						                                                    @if($option->ticket_url != '')
						                                                        <tr>
						                                                            <?php 
						                                                             $link = urlencode("Your booking is confirmed. Hooray ! Your ticket for " . $me->itemName .  " is ready for download. Please download your ticket by clicking this link: \n  \n " . $option->ticket_url . "\n  \n Activate your complimentary 1-month BookingBash Pro Access and unlock exclusive benefits. Enjoy up to 50% discounts on incredible activities and attractions throughout the UAE. \n\n Download the app now and start exploring with incredible savings! Available Here: https://onelink.to/bbpro-app");
						                                                            $ticketURL = trim($whatsapp) . "/?text=" . $link ; ?>
						                                                            <td>Send Ticket {{$i}} with WhatsApp: </td>
						                                                            <td class="text-right"> <a href="https://wa.me/{!! $ticketURL !!}" target="_blank">Send Ticket {{$i}} Via WhatsApp</a></td>
						                                                        </tr>
						                                                    @endif
						                                                    <?php $i++; ?>
						                                                @endforeach


						                                                <!-- Custom Ticket -->
						                                                <?php $i = 1; ?>
						                                                @foreach($options as $option)
						                                                    <tr>
						                                                        <?php 
						                                                        $ticket_url = 'https://bookingbash.com/myaccount/ticket/'.Str::random(15).'Ssyz'.$records->bookingId.'Ssyz'.Str::random(15).'/'.Str::random(15).'pYys'.$option->id.'pYys'.Str::random(15);
						                                                        $link = urlencode("Your booking is confirmed. Hooray ! Your ticket for " . $me->itemName .  " is ready for download. Please download your ticket by clicking this link: \n  \n " . $ticket_url . "\n  \n Activate your complimentary 1-month BookingBash Pro Access and unlock exclusive benefits. Enjoy up to 50% discounts on incredible activities and attractions throughout the UAE. \n\n Download the app now and start exploring with incredible savings! Available Here: https://onelink.to/bbpro-app");

						                                                        $ticketURL = trim($whatsapp) . "/?text=" . $link ; ?>
						                                                        <td>Send Custom Ticket {{$i}} with WhatsApp: </td>
						                                                        <td class="text-right"> <a href="https://wa.me/{!! $ticketURL !!}" target="_blank">Send Custom Ticket {{$i}} Via WhatsApp</a></td>
						                                                    </tr>
						                                                    <?php $i++; ?>
						                                                @endforeach
						                                            @else
						                                                @if($me->ticketpath)
						                                                    <tr>
						                                                        <?php 
						                                                         $link = urlencode("Your booking is confirmed. Hooray ! Your ticket for " . $me->itemName .  " is ready for download. Please download your ticket by clicking this link: \n  \n " . $option->ticket_url . "\n  \n Activate your complimentary 1-month BookingBash Pro Access and unlock exclusive benefits. Enjoy up to 50% discounts on incredible activities and attractions throughout the UAE. \n\n Download the app now and start exploring with incredible savings! Available Here: https://onelink.to/bbpro-app");
						                                                        $ticketURL = trim($whatsapp) . "/?text=" . $link ; ?>
						                                                        <td>Send Ticket with WhatsApp: </td>
						                                                        <td class="text-right"> <a href="https://wa.me/{!! $ticketURL !!}" target="_blank">Send Ticket Via WhatsApp</a></td>
						                                                    </tr>
						                                                @endif
						                                            @endif

															  	@endif
														      <tr>
														         <td><b>Fare Details</b></td>
														         <td></td>
														      </tr>
														      <tr>
														         <td>Ticket Fare</td>
														         <td>AED {!! $me->subtotal !!}</td>
														      </tr>
														      <tr>
														         <td>Convenience fees</td>
														         <td>AED 0.00</td>
														      </tr>
														      	@if($me->promoAmount != 0)
					                                             	<tr>
					                                                	<td>Discount Amount ( {!! $me->promoCode !!} )</td>
					                                                	<td class="text-right">AED {!! number_format($me->promoAmount,2) !!}</td>
					                                            	</tr>
					                                            @endif
														   </tbody>
														   <tfoot>
														      <tr>
														         <td class="total-price">Amount Paid</td>
														         <td class="total-price">AED {!! number_format($me->totalPrice,2) !!}</td>
														      </tr>
														   </tfoot>
														</table>

														<hr>

														<div class="row fs-7">
														   <div class="col-md-6">
														      <div class="post-prev-info pl-0">
														         <b>Booked on</b><br>
														         {!! $me->created_at !!}
														      </div>
														   </div>
														   <div class="col-md-6">
														      <div class="post-prev-info pl-0">
														         <b>Payment made</b><br>
														         Credit Card/Debit Card
														      </div>
														   </div>
														</div>
									          		</div>
									          	</div>
	                                        </div>
								        </li>

							      	</ul>
							    </div>
						  	</div>
						@endforeach
					</div>
				</div>

				<?php
			        $options = Bookingreportsapioptions::where('bookingreportId', $records->id)->orderBy('id', 'ASC')->get();
			    ?>
			    @foreach($options as $option)
			    	<?php
			            $logs = DB::table('booking_log')->where('bookingId', $records->bookingId)->where('optionId', $option->option_id)->orderBy('id', 'ASC')->get();
			        ?>
					<div class="card card-flush mt-4">
						<div class="card-body">
							<h3 class="card-title mb-4">View Log - Option ID: {{ $option->option_id }}</h3>
							<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer">
							   	<thead>
							      	<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
							         	<th>Booking ID</th>
							         	<th>Date</th>
							         	<th>Message</th>
							         	<th>Type</th>
							         	<th>Request/Response</th>
							      	</tr>
							    </thead>
							    <tbody>
							    	@foreach($logs as $log)
								     	<tr>
								         	<td>{{ $records->bookingId }}</td>
								         	<td>{{ $log->created_at }}</td>
								         	<td>{!! $log->error_msg !!}</td>
								         	<td>{{ $log->api_type }}</td>
								         	<td>
									            @if($log->api_type != 'automatic_confirmation')
					                                <a class="btn btn-primary btn-xs viewreqres" href="javascript:;" data-id="{{$log->id}}">View</a>
					                                <input type="hidden" name="" id="request_{{$log->id}}" value="{{ $log->api_request }}">
					                                <input type="hidden" name="" id="response_{{$log->id}}" value="{{ $log->api_response }}">
					                            @endif
								         	</td>
								      	</tr>
								     @endforeach
								</tbody>
							</table>
						</div>
					</div>
				@endforeach
			</div>
		</div>
		<!--end::Post-->
	</div>
	<!--end::Content-->

	<!-- log modal -->
	<div class="modal fade" id="logModal" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Request / Response</h4>
                </div>
                <div class="modal-body" style="overflow:scroll">
                    <form>
                      <div class="box-body">
                        <div class="form-group">
                          <label for="activity-name" class="form-label">Request</label>
                          <div id="requestBox">
                            
                          </div>
                        </div>

                         <div class="form-group">
                          <label for="activity-name" class="form-label">Response</label>
                          <div id="responseBox">
                            
                          </div>
                        </div>

                      </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="sendticketbtn">Submit</button>
                    <button type="button" class="btn btn-warning" ng-click="resetForm()" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){
			$('.viewreqres').on('click', function(){
		        var d = $(this).attr('data-id');
		        $('#requestBox').text($('#request_'+d).val());
		        $('#responseBox').text($('#response_'+d).val());
		        $('#logModal').modal('show');
		    });

		    $('.completeBooking').on('click', function(){
		        var th = $(this);
		        th.text('Please wait...');
		        var id = $(this).attr('data-id');
		        var option_id = $(this).attr('data-option-id');
		        var con = confirm('Do you want to complete this booking?');
		        if(con == false){
		            th.text('Confirm');
		           return false;
		        }
		        $('#completebookingaction_'+option_id).hide();
		        $('#completebookinghide_'+option_id).show();

		        //th.prop('disabled', true);
		        $.ajax({
		            url: '/report/ticket/complete/booking',
		            data: { id:id, option_id: option_id },
		            dataType: 'json',
		            type: 'GET',
		            success: function (res){
		                if(res.status == 'success'){
		                    alert('Ticket booking completed.');
		                    location.reload();
		                }else{
		                    $('#completebookingaction_'+id).show();
		                    $('#completebookinghide_'+id).hide();
		                    th.text('Confirm');
		                    alert(res.msg);
		                }
		                return false;
		            }, error: function(e){
		                $('#completebookingaction_'+id).show();
		                $('#completebookinghide_'+id).hide();
		                th.text('Confirm');
		                alert(e.responseText);
		                return false;
		            }
		        });
		    });
		});
	</script>
@endsection