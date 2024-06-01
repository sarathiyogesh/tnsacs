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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">{{ $activity->activity_name }} - Update Ticket Items</h1>
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

				<div class="card card-flush">
					<!--begin::Card body-->
					<div class="card-body">
						<div class="d-flex align-items-center justify-content-end gap-2 gap-lg-3">
							<a href="javascript:;" id="addsection" class="btn btn-sm btn-primary" >Add Section</a>
						</div>
						<!--begin::Table-->
						<div class="alert alert-danger errorMsg-show" style="display:none;"></div>
						<div class="alert alert-success successMsg-show" style="display:none;"></div>

						<div class="box-body sectionDiv">
				            
						</div>


					<!--end::Card body-->
				</div>
			</div>
		</div>
		<!--end::Post-->

		<!--end::Help drawer-->
	</div>
	<!--end::Content-->


	<!-- Add Section Modal -->
	<div class="modal fade" id="addsectionmodal" tabindex="-1" aria-labelledby="addsectionmodalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="sectionmodallabel">Add Section</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form id="photoForm">
	        	<input type="hidden" name="section_id" id="section_id" value="">
			<!--begin::Body-->
			<div class="card-body" id="kt_help_body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="required form-label">Section Name</label>
							<input type="text" name="section_name" id="section_name" class="form-control" placeholder="Section name" value="">
						</div>
					</div>
				</div>
			</div>
			<!--end::Body-->
		</form>
	      </div>
	      <div class="modal-footer">
			<button type="button" class="btn btn-primary" id="savesection">Save</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Add Section Item Modal -->
	<div class="modal fade" id="additemmodal" tabindex="-1" aria-labelledby="additemmodalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="itemmodallabel">Add Section</h5>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">
	        <form id="itemForm">
	        	<input type="hidden" name="item_section_id" id="item_section_id" value="">
	        	<input type="hidden" name="item_id" id="item_id" value="">
			<!--begin::Body-->
			<div class="card-body" id="kt_help_body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="required form-label">Item Name</label>
							<input type="text" name="item_name" id="item_name" class="form-control" placeholder="Item name" value="">
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label class="required form-label">Item Description</label>
							<input type="text" name="item_description" id="item_description" class="form-control" placeholder="Item description" value="">
						</div>
					</div>
				</div>

				<div class="touroptionDiv">
					<div class="row optionDiv">
						<div class="col-md-5">
							<div class="form-group">
								<label class="required form-label">Tour ID</label>
								<input type="text" name="tour_id" class="form-control tour_id" placeholder="Tour ID" value="">
							</div>
						</div>

						<div class="col-md-5">
							<div class="form-group">
								<label class="required form-label">Option ID</label>
								<input type="text" name="option_id" class="form-control option_id" placeholder="Option ID" value="">
							</div>
						</div>

						<div class="col-md-2">
	            			<a href="javascript:;" class="addOption" style="font-size:18px;"><i class="fa fa-plus-circle" ></i></a>
	          				<a href="javascript:;" class="deleteOption" style="font-size:18px;color:red;display:none;"><i class="fa fa-minus-circle"></i></a>
	            		</div>
	            	</div>
            	</div>

            	<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="required form-label">Price Type</label>
							<select name="price_type" id="price_type" class="form-control">
								<option value="">Select</option>
								<option value="allage">For All Age</option>
								<option value="adult">Adult only</option>
								<option value="child">Child only</option>
								<option value="adultandchild">Adult and Child</option>
							</select>
						</div>
					</div>

					<div class="col-md-6 adultPriceDiv" style="display:none;">
						<div class="form-group">
							<label class="required form-label">Adult Price</label>
							<input type="text" name="adult_price" id="adult_price" class="form-control" placeholder="Adult Price" value="">
						</div>
					</div>

					<div class="col-md-6 adultPriceDiv" style="display:none;">
						<div class="form-group">
							<label class="required form-label">Adult Price 1</label>
							<input type="text" name="adult_price1" id="adult_price1" class="form-control" placeholder="Adult Price 1" value="">
						</div>
					</div>

					<div class="col-md-6 childPriceDiv" style="display:none;">
						<div class="form-group">
							<label class="required form-label">Child Price</label>
							<input type="text" name="child_price" id="child_price" class="form-control" placeholder="Child Price" value="">
						</div>
					</div>

					<div class="col-md-6 childPriceDiv" style="display:none;">
						<div class="form-group">
							<label class="required form-label">Child Price 1</label>
							<input type="text" name="child_price1" id="child_price1" class="form-control" placeholder="Child Price 1" value="">
						</div>
					</div>

					<div class="col-md-6 allagePriceDiv" style="display:none;">
						<div class="form-group">
							<label class="required form-label">Allage Price</label>
							<input type="text" name="allage_price" id="allage_price" class="form-control" placeholder="Allage Price" value="">
						</div>
					</div>

					<div class="col-md-6 allagePriceDiv" style="display:none;">
						<div class="form-group">
							<label class="required form-label">Allage Price 1</label>
							<input type="text" name="allage_price1" id="allage_price1" class="form-control" placeholder="Allage Price 1" value="">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label class="required form-label">Minimum Ticket</label>
							<input type="text" name="minimum_ticket" id="minimum_ticket" class="form-control" placeholder="Minimum Ticket" value="">
							<em>Please enter integer value starting from 1</em>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label class="required form-label">Maximum Ticket</label>
							<input type="text" name="maximum_ticket" id="maximum_ticket" class="form-control" placeholder="Maximum Ticket" value="">
							<em>Please enter integer value starting from 1</em>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label class="required form-label">Soriting Position</label>
							<input type="text" name="sorting_position" id="sorting_position" class="form-control" placeholder="Sorting Position" value="">
							<em>Please enter integer value starting from 1</em>
						</div>
					</div>
				</div>
			</div>
			<!--end::Body-->
		</form>
	      </div>
	      <div class="modal-footer">
			<button type="button" class="btn btn-primary" id="saveitem">Save</button>
	      </div>
	    </div>
	  </div>
	</div>

	
@endsection

@section('scripts')
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){

			//open add section modal
			$(document).on('click', '#addsection', function(){
				$('#sectionmodallabel').text('Add Section');
				$('#section_id').val('');
				$('#addsectionmodal').modal('show');
			});

			//open edit section modal
			$(document).on('click', '.editsection', function(){
				var id = $(this).attr('data-id');
				var name = $(this).attr('data-name');
				$('#sectionmodallabel').text('Update Section');
				$('#section_id').val(id);
				$('#section_name').val(name);
				$('#addsectionmodal').modal('show');
			});

			//save section modal
			$(document).on('click', '#savesection', function(){
				var section_id = $('#section_id').val();
				var activityId = "{{ $activity->activity_id }}";
				var ticket_id = "{{ $ticketInfo->id }}";
				var name = $('#section_name').val();
				$('.errorMsg-show').hide();
				$('.successMsg-show').hide();
			    $.ajax({
			        url: '/activities/ticket/items/section/save',
			        data: { section_id:section_id, ticket_id:ticket_id, activity_id: activityId, name: name },
			        dataType: 'json',
			        type: 'GET',
			        success: function (res){
			            if(res.status == 'success'){
			            	$('#addsectionmodal').modal('hide');
			            	$('.errorMsg-show').hide();
							$('.successMsg-show').show().text('Ticket section details updated.');
							getsections();
						}else if(res.status == 'validation'){
							$.each(res.validation, function(k,v){
								toastr.error(v[0]);
							});
						}else{
							toastr.error('Error processing your request. Please try again.');
						}
			            return false;
			        }, error: function(e){
			            toastr.error(e.responseText);
			            return false;
			        }
			    });
			});

			getsections();

			function getsections(){
				var activityId = "{{ $activity->activity_id }}";
				var ticket_id = "{{ $ticketInfo->id }}";
				$.ajax({
			        url: '/activities/ticket/items/section/get',
			        data: { ticket_id:ticket_id, activity_id: activityId },
			        dataType: 'json',
			        type: 'GET',
			        success: function (res){
			            if(res.status == 'success'){
			            	$('.sectionDiv').html(res.html);
						}else if(res.status == 'validation'){
							$.each(res.validation, function(k,v){
								toastr.error(v[0]);
							});
						}else{
							toastr.error('Error processing your request. Please try again.');
						}
			            return false;
			        }, error: function(e){
			            toastr.error(e.responseText);
			            return false;
			        }
			    });
			}

			//open add items modal
			$(document).on('click', '.additem', function(){
				var section_id = $(this).attr('data-id');
				$('#itemmodallabel').text('Add Ticket Item');
				$('#item_section_id').val(section_id);
				$('#item_id').val('');
				$('#additemmodal').modal('show');
			});

			//open edit items modal
			$(document).on('click', '.edititem', function(){
				var section_id = $(this).attr('data-section');
				var id = $(this).attr('data-id');
				$('#itemmodallabel').text('Update Ticket Item');
				$('#item_section_id').val(section_id);
				$('#item_id').val(id);


				$.ajax({
			        url: '/activities/ticket/items/details/get',
			        data: { item_id:id },
			        dataType: 'json',
			        type: 'GET',
			        success: function (res){
			            if(res.status == 'success'){
			            	var item = res.item;
			            	$('#item_name').val(item.item_name);
							$('#item_description').val(item.item_desc);
							$('#price_type').val(item.price_type);
							$('#adult_price').val(item.adult_price);
							$('#adult_price1').val(item.adult_price1);
							$('#child_price').val(item.child_price);
							$('#child_price1').val(item.child_price);
							$('#allage_price').val(item.allage_price);
							$('#allage_price1').val(item.allage_price);
							$('#minimum_ticket').val(item.minimum_ticket);
							$('#maximum_ticket').val(item.maximum_ticket);
							$('#sorting_position').val(item.sorting);
							$('.touroptionDiv').html(res.html);
							openpricetypes();
							clonetouroptions();
			            	$('#additemmodal').modal('show');
						}else if(res.status == 'validation'){
							$.each(res.validation, function(k,v){
								toastr.error(v[0]);
							});
						}else{
							toastr.error(res.message);
						}
			            return false;
			        }, error: function(e){
			            toastr.error(e.responseText);
			            return false;
			        }
			    });


				
			});

			function openpricetypes(){
				var type = $('#price_type').val();
				$('.adultPriceDiv').hide();
				$('.childPriceDiv').hide();
				$('.allagePriceDiv').hide();
				if(type == 'adult'){
					$('.adultPriceDiv').show();
				}else if(type == 'child'){
					$('.childPriceDiv').show();
				}else if(type == 'adultandchild'){
					$('.adultPriceDiv').show();
					$('.childPriceDiv').show();
				}else if(type == 'allage'){
					$('.allagePriceDiv').show();
				}
			}

			$(document).on('change', '#price_type', function(){
				openpricetypes();
				return false;
			});

			//save items modal
			$(document).on('click', '#saveitem', function(){
				var section_id = $('#item_section_id').val();
				var item_id = $('#item_id').val();
				var activityId = "{{ $activity->activity_id }}";
				var ticket_id = "{{ $ticketInfo->id }}";
				var item_name = $('#item_name').val();
				var item_description = $('#item_description').val();
				var price_type = $('#price_type').val();
				var adult_price = $('#adult_price').val();
				var adult_price1 = $('#adult_price1').val();
				var child_price = $('#child_price').val();
				var child_price1 = $('#child_price1').val();
				var allage_price = $('#allage_price').val();
				var allage_price1 = $('#allage_price1').val();
				var minimum_ticket = $('#minimum_ticket').val();
				var maximum_ticket = $('#maximum_ticket').val();
				var sorting_position = $('#sorting_position').val();


				var touroptions = [];
				$('.optionDiv').each(function(){
					var array = [];
					var optiondiv = $(this);
					var tour_id = optiondiv.find('.tour_id').val();
					var option_id = optiondiv.find('.option_id').val();
					array = {tour_id: tour_id, option_id: option_id};
					touroptions.push(array);
				});
				var strtouroptions = '';
				if(touroptions.length > 0){
					strtouroptions = JSON.stringify(touroptions);
				}

				$('.errorMsg-show').hide();
				$('.successMsg-show').hide();
			    $.ajax({
			        url: '/activities/ticket/items/details/save',
			        data: { section_id:section_id, item_id:item_id, ticket_id:ticket_id, activity_id: activityId, item_name: item_name, item_description: item_description, touroptions: strtouroptions, price_type: price_type, adult_price: adult_price, adult_price1: adult_price1, child_price: child_price, child_price1: child_price1, allage_price: allage_price, allage_price1: allage_price1, minimum_ticket: minimum_ticket, maximum_ticket: maximum_ticket, sorting_position: sorting_position  },
			        dataType: 'json',
			        type: 'GET',
			        success: function (res){
			            if(res.status == 'success'){
			            	getsections();
			            	$('#additemmodal').modal('hide');
			            	$('.errorMsg-show').hide();
							$('.successMsg-show').show().text('Ticket item details updated.');
						}else if(res.status == 'validation'){
							$.each(res.validation, function(k,v){
								toastr.error(v[0]);
							});
						}else{
							toastr.error('Error processing your request. Please try again.');
						}
			            return false;
			        }, error: function(e){
			            toastr.error(e.responseText);
			            return false;
			        }
			    });
			});

			//Clone Tour ID & Option ID
			function clonetouroptions(){
				$(".addOption").hide();
				$(".deleteOption").hide();
				var length = $('.optionDiv').length;
				if(length > 1)  {
					$(".deleteOption").show();
				}
				$(".addOption:last").show();
			}

			clonetouroptions();


			$(document).on('click', '.addOption', function(){
				$('.optionDiv:first').clone().insertAfter('.optionDiv:last');
				$('.optionDiv:last').find("input[type='text']").val('');
				clonetouroptions();
				return false;
			});

			$(document).on('click', '.deleteOption', function(){
		       $(this).closest(".optionDiv").remove();
		       clonetouroptions();
		       return false;
		    });
		});

	</script>
@endsection