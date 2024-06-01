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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">{{ $activity->activity_name }} - Manage Ticket</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<a href="{{ url('/activities/ticket/'.$activity->activity_id.'/add') }}" class="btn btn-sm btn-primary" >Add Ticket</a>
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
						<!--begin::Table-->
						<div class="alert alert-danger errorMsg-show" style="display:none;"></div>
						<div class="alert alert-success successMsg-show" style="display:none;"></div>
						<div id="kt_ecommerce_products_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
							<div class="table-responsive showTable">
								<table class="table align-middle table-row-dashed fs-6 gy-2 dataTable no-footer" id="kt_ecommerce_products_table">
									<!--begin::Table head-->
									<thead>
										<!--begin::Table row-->
										<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
										   <th class="w-10px pe-2" rowspan="1" colspan="1" aria-label="">S.No</th>
										   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Date</th>
										   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Status</th>
										   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Manage Dates</th>
										   <th class="min-w-200px" tabindex="0" rowspan="1" colspan="1">Manage Ticket Item</th>
										   <th class="min-w-70px" rowspan="1" colspan="1">Delete</th>
										</tr>
										<!--end::Table row-->
									</thead>
									<!--end::Table head-->
									<!--begin::Table body-->
									<tbody>
										@if(count($list) > 0)
											<?php $i=1; ?>
											@foreach($list as $ac)
												<tr class="ticketdate{{$ac->id}}">
													<td>{{ $i++ }}</td>
													<td>{{ $ac->ticket_date }}</td>
													<td>{{ strtoupper($ac->status) }}</td>
													<td>
														<a href="{{ url('/activities/ticket/dates/'.$activity->activity_id.'/'.$ac->id.'/edit') }}" class="label label-danger">View/Update</a>
													</td>
													<td>
														<a href="{{ url('/activities/ticket/items/'.$activity->activity_id.'/'.$ac->id.'/edit') }}" class="label label-danger">View/Update</a>
													</td>
													<td>
														<a href="javascript:;" data-id="{{ $ac->id }}" class="deleteTicket" title="Delete"><i class="las la-trash fs-4 text-red"></i> Delete</a>
													</td>
												</tr>
											@endforeach
										@else
											<tr>
												<td colspan="5">No data available</td>
											</tr>
										@endif
									</tbody>
									<!--end::Table body-->
								</table>
							</div>
						</div>
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
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.deleteTicket', function(){
			    var th = $(this);
			    var id = th.attr('data-id');
			    var con = confirm('Do you want to delete this ticket dates?');
			    if(con == false){
			       return false;
			    }
			    $.ajax({
			        url: '/activities/ticket/list/delete',
			        data: { id:id },
			        dataType: 'json',
			        type: 'GET',
			        success: function (res){
			            if(res.status == 'success'){
			            	$('.ticketdate'+id).remove();
			                alert('Ticket date deleted successfully');
			                location.reload();
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