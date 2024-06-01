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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Add Form Sample</h1>
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
				<div class="card card-flush" style="display:none">
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="required form-label">Organization Name</label>
									<input type="text" name="product_name" class="form-control mb-2" placeholder="Organization name" value="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="required form-label">Email</label>
									<input type="text" name="product_name" class="form-control mb-2" placeholder="Email Address" value="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="required form-label">Phone</label>
									<input type="text" name="product_name" class="form-control mb-2" placeholder="Phone Number" value="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="required form-label">Domain</label>
									<input type="text" name="product_name" class="form-control mb-2" placeholder="Organization Website" value="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="required form-label">Expiry</label>
									<input type="text" name="product_name" class="form-control mb-2" placeholder="Select Expiry Date" value="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="required form-label">Location</label>
									<select name="country" aria-label="Select Location" data-control="select2" data-placeholder="Select Location" class="form-select form-select-solid form-select-lg fw-bold">
										<option value="">Select Location</option>
										<option data-kt-flag="flags/afghanistan.svg" value="AF">Afghanistan</option>
										<option data-kt-flag="flags/aland-islands.svg" value="AX">Aland Islands</option>
										<option data-kt-flag="flags/albania.svg" value="AL">Albania</option>
										<option data-kt-flag="flags/algeria.svg" value="DZ">Algeria</option>
										<option data-kt-flag="flags/american-samoa.svg" value="AS">American Samoa</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="required form-label">Status</label>
									<select name="country" aria-label="Select Status" data-control="select2" data-placeholder="Select Status" class="form-select form-select-solid form-select-lg fw-bold">
										<option value="">Select Status</option>
										<option value="active">Active</option>
										<option value="inactive">Inactive</option>
									</select>
								</div>
							</div>
						</div>
						<div class="d-flex justify-content-end py-6">
							<button type="reset" class="btn btn-light btn-active-light-primary me-2">Reset</button>
							<button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>
						</div>
					</div>
				</div>

				<div class="card card-flush">
					<div class="card-body">
						<h3 class="card-title">View Ticket Details (#300820238690)</h3>
						<div class="rightbox">
						    <div class="rb-container">
							    <ul class="rb">
							        <li class="rb-item" ng-repeat="itembx">
							          	<div class="timestamp">
							            	<div class="date">31</div> August 2023 <span class="px-7">|</span> 7:00 PM
							          	</div>
							          	<hr>
							          	<p class="item-title">Booking ID: 300820238690</p>
									   	<p class="item-title">Payment Reference No: ch_3NksqSH4kGdzGA9U19hWyeyo</p>
									   	<h2 class="item-title text-red mb-10">Dubai Aquarium Under water zoo - Dubai Mall</h2>

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
										      	<tr>
										         	<td>1571461</td>
										         	<td><a class="alert alert-sm alert-success" href="javascript:;">Confirmed</a></td>
										         	<td>--</td>
										         	<td><a class="label label-success" href="https://bookingbash.com/myaccount/ticket/E8CDtovy2JuyKtwSsyz300820238690Ssyz4ZSEBkS5qvunnNi/Ksc84rS2gHpm90cpYys4617pYysu8rcgUVQqZlaOEp" target="_blank">View</a></td>
										         	<td><a class="label label-success" href="https://findourticket.com/Ticket/DownloadTicketNew?token=QAV0EKdWyQJf%2fK9tqUYIuwn43Pl%2foW1HmNYy6aokmy8p33bM%2f%2bgMtUmiDGpDBZA9j2kJzspQr0v8Gsb4Fh4Igg%3d%3d" target="_blank">View</a></td>
										      	</tr>
										   </tbody>
										</table>
							        </li>

							        <li class="rb-item" ng-repeat="itembx">
							        	<div class="mt-0 mb-10">
                                            <div class="item-title text-red fw-bold">
                                                <i class="las la-map-marker-alt fs-3"></i>&nbsp; TICKETS - Dubai Aquarium and Underwater Zoo
                                            </div>
                                            <div class="timestamp">
								            	<i class="las la-calendar fs-3"></i> 31 August 2023 <span class="px-7">|</span><i class="las la-clock fs-3"></i>  7:00 PM
								          	</div>

								          	<div class="card card-flush bg-light mt-5">
								          		<div class="card-body">
								          			<table class="table align-middle table-row-dashed fs-7 gy-2 dataTable no-footer">
													   <tbody>
													      <tr>
													         <td><b>Pax Count</b></td>
													         <td></td>
													      </tr>
													      <tr>
													         <td>All Age</td>
													         <td>2</td>
													      </tr>
													      <tr>
													         <td><b>Buyer Details</b></td>
													         <td></td>
													      </tr>
													      <tr>
													         <td>Name</td>
													         <td>Larsen Lobo</td>
													      </tr>
													      <tr>
													         <td>Email</td>
													         <td>lobolarsen96@gmail.com</td>
													      </tr>
													      <tr>
													         <td>Gender</td>
													         <td>male</td>
													      </tr>
													      <tr>
													         <td>Phonenumber</td>
													         <td>(+971) 542465228</td>
													      </tr>
													      <tr>
													         <td>Send Message with WhatsApp: </td>
													         <td>Message will be sent with Web WhatsApp or Desktop WhatsApp if available. <a href="https://wa.me/+971542465228" target="_blank">Send WhatsApp</a></td>
													      </tr>
													      <tr>
													         <td>Send Google Review request </td>
													         <td>Google review via Whatsapp <a href="https://wa.me/+971542465228/?text=Thank+you+for+choosing+BookingBash%21+Your+positive+experience+means+a+lot+to+us+and+can+help+others+discover+our+easy-to-use+platform.%0APlease+take+a+moment+to+share+your+experience+and+help+us+spread+the+word+about+BookingBash.+%0AThanks+again+for+your+support%21+%0Ahttps%3A%2F%2Fg.page%2Fr%2FCa_wxgKgWxsIEB0%2Freview" target="_blank">Ask for Review</a></td>
													      </tr>
													      <tr>
													         <td>Send Ticket 1 with WhatsApp: </td>
													         <td> <a href="https://wa.me/+971542465228/?text=Your+booking+is+confirmed.+Hooray+%21+Your+ticket+for+Dubai+Aquarium+and+Underwater+Zoo+is+ready+for+download.+Please+download+your+ticket+by+clicking+this+link%3A+%0A++%0A+https%3A%2F%2Ffindourticket.com%2FTicket%2FDownloadTicketNew%3Ftoken%3DQAV0EKdWyQJf%252fK9tqUYIuwn43Pl%252foW1HmNYy6aokmy8p33bM%252f%252bgMtUmiDGpDBZA9j2kJzspQr0v8Gsb4Fh4Igg%253d%253d%0A++%0A+Activate+your+complimentary+1-month+BookingBash+Pro+Access+and+unlock+exclusive+benefits.+Enjoy+up+to+50%25+discounts+on+incredible+activities+and+attractions+throughout+the+UAE.+%0A%0A+Download+the+app+now+and+start+exploring+with+incredible+savings%21+Available+Here%3A+https%3A%2F%2Fonelink.to%2Fbbpro-app" target="_blank">Send Ticket 1 Via WhatsApp</a></td>
													      </tr>
													      <!-- Custom Ticket -->
													      <tr>
													         <td>Send Custom Ticket 1 with WhatsApp: </td>
													         <td> <a href="https://wa.me/+971542465228/?text=Your+booking+is+confirmed.+Hooray+%21+Your+ticket+for+Dubai+Aquarium+and+Underwater+Zoo+is+ready+for+download.+Please+download+your+ticket+by+clicking+this+link%3A+%0A++%0A+https%3A%2F%2Fbookingbash.com%2Fmyaccount%2Fticket%2F1wNLycFLhzibXiZSsyz300820238690SsyzwfDVmC829VJuUUs%2FhdX65OWri32zevLpYys4617pYysAZpcFW7tja0w8pG%0A++%0A+Activate+your+complimentary+1-month+BookingBash+Pro+Access+and+unlock+exclusive+benefits.+Enjoy+up+to+50%25+discounts+on+incredible+activities+and+attractions+throughout+the+UAE.+%0A%0A+Download+the+app+now+and+start+exploring+with+incredible+savings%21+Available+Here%3A+https%3A%2F%2Fonelink.to%2Fbbpro-app" target="_blank">Send Custom Ticket 1 Via WhatsApp</a></td>
													      </tr>
													      <tr>
													         <td><b>Fare Details</b></td>
													         <td></td>
													      </tr>
													      <tr>
													         <td>Ticket Fare</td>
													         <td>AED 278</td>
													      </tr>
													      <tr>
													         <td>Convenience fees</td>
													         <td>AED 0.00</td>
													      </tr>
													   </tbody>
													   <tfoot>
													      <tr>
													         <td class="total-price">Amount Paid</td>
													         <td class="total-price">AED 278.00</td>
													      </tr>
													   </tfoot>
													</table>

													<hr>

													<div class="row fs-7">
													   <div class="col-md-6">
													      <div class="post-prev-info pl-0">
													         <b>Booked on</b><br>
													         2023-08-30 22:10:23
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
					</div>
				</div>

				<div class="card card-flush mt-4">
					<div class="card-body">
						<h3 class="card-title mb-4">View Log - Option ID: 1571461</h3>
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
						     	<tr>
						         	<td>300820238690</td>
						         	<td>2023-08-30 22:31:05</td>
						         	<td></td>
						         	<td>Activity Price</td>
						         	<td>
						            <a class="btn btn-primary btn-xs viewreqres" href="javascript:;" data-id="3653">View</a>
						            <input type="hidden" name="" id="request_3653" value="test">
						         	</td>
						      	</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!--end::Post-->
	</div>
	<!--end::Content-->
@endsection