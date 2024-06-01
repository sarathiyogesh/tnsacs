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
					<h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Dashboard</h1>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
				<div class="d-flex align-items-center gap-2 gap-lg-3">
					<div class="m-0">
						<!-- <a href="javascript:;" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
						<span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor" />
							</svg>
						</span>
						Filter</a> -->
						<!-- <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_6244763d93048">
							<div class="px-7 py-5">
								<div class="fs-5 text-dark fw-bolder">Filter Options</div>
							</div>
							<div class="separator border-gray-200"></div>
							<div class="px-7 py-5">
								<div class="mb-10">
									<label class="form-label fw-bold">Status:</label>
									<div>
										<select class="form-select form-select-solid" data-kt-select2="true" data-placeholder="Select option" data-dropdown-parent="#kt_menu_6244763d93048" data-allow-clear="true">
											<option></option>
											<option value="1">Approved</option>
											<option value="2">Pending</option>
											<option value="2">In Process</option>
											<option value="2">Rejected</option>
										</select>
									</div>
								</div>
								<div class="mb-10">
									<label class="form-label fw-bold">Member Type:</label>
									<div class="d-flex">
										<label class="form-check form-check-sm form-check-custom form-check-solid me-5">
											<input class="form-check-input" type="checkbox" value="1" />
											<span class="form-check-label">Author</span>
										</label>
										<label class="form-check form-check-sm form-check-custom form-check-solid">
											<input class="form-check-input" type="checkbox" value="2" checked="checked" />
											<span class="form-check-label">Customer</span>
										</label>
									</div>
								</div>
								<div class="mb-10">
									<label class="form-label fw-bold">Notifications:</label>
									<div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
										<input class="form-check-input" type="checkbox" value="" name="notifications" checked="checked" />
										<label class="form-check-label">Enabled</label>
									</div>
								</div>
								<div class="d-flex justify-content-end">
									<button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
									<button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
								</div>
							</div>
						</div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--end::Content-->
@endsection

@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.1.1/chart.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.1.1/helpers.esm.min.js"></script>

<script>

getdashboardinfo();

function getdashboardinfo(){
  $.ajax({
    url: '/getdashboardinfo',
    data: { },
    dataType: 'json',
    type: 'GET',
    success: function(res){
      if(res.status == 'success'){
          data = res.data;
          $('.today_count').text(data.today_count);
          $('.thismonth_count').text(data.thismonth_count);
          $('.lastsix_count').text(data.lastsix_count);
          $('.last12month_count').text(data.last12month_count);

          $('.today_trans').text(data.today_trans);
          $('.thismonth_trans').text(data.thismonth_trans);
          $('.lastsix_trans').text(data.lastsix_trans);
          $('.last12month_trans').text(data.last12month_trans);

          $('.coruser_count').text(data.coruser_count);
          $('.prouser_count').text(data.prouser_count);
          $('.reg_count').text(data.reg_count);

          salestranssummarychart(data.sales_count_label,data.sales_count_data);
          salestkesummarychart(data.sales_count_label,data.sales_tktcount_data);
          // activitychart(data.topsalesitemlabel,data.topsalesitemdata);
          // regchart(data.sales_count_label,data.sales_regcount_data);
      }
    }, error: function(e){
      console.log(e.responseText());
    }
  });
}

function salestranssummarychart(label,data){
  var chrt = document.getElementById("saleschartId").getContext("2d");
  var chartId = new Chart(chrt, {
     type: 'bar',
     data: {
        labels: label,
        datasets: [{
           label: "Monthly sales (INR)",
           data: data,
          backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 159, 64, 0.2)',
              'rgba(255, 205, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(76, 245, 39, 0.8)'
              ],
           borderColor: [
             'rgb(255, 99, 132)',
            'rgb(255, 159, 64)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(54, 162, 235)',
            'rgb(153, 102, 255)',
            'rgb(201, 203, 207)'
           ],
           borderWidth: 1,
           barThickness: 30
        }],
     },
     options: {
      plugins: {
        legend: {
            display: false
          }
      },
      responsive: true,
     },
  });
}

function salestkesummarychart(label,data){
  var chrttkt = document.getElementById("salestktchartId").getContext("2d");
  var tktchartId = new Chart(chrttkt, {
     type: 'bar',
     data: {
        labels: label,
        datasets: [{
           label: "Monthly Course Purchased",
           data: data,
           backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 159, 64, 0.2)',
              'rgba(255, 205, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(76, 245, 39, 0.8)'
              ],
           borderColor: [
             'rgb(255, 99, 132)',
            'rgb(255, 159, 64)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(54, 162, 235)',
            'rgb(153, 102, 255)',
            'rgb(201, 203, 207)'
           ],
           borderWidth: 1,
           barThickness: 30
        }],
     },
     options: {
      plugins: {
        legend: {
            display: false
          }
      },
        responsive: true,
     },
  });
}

// function activitychart(label,data){
// 	console.log(data);
//   var xValues = label;
//   var yValues = data;
//   var barColors = [
//     "#b91d47",
//     "#00aba9",
//     "#2b5797",
//     "#e8c3b9",
//     "#1e7145"
//   ];

//   new Chart("activityChartId", {
//     type: "doughnut",
//     data: {
//       labels: xValues,
//       datasets: [{
//         backgroundColor: barColors,
//         data: yValues
//       }]
//     },
//     options: {
//       title: {
//         display: true,
//         text: "Top sales activity"
//       }
//     }
//   });
// }

// function regchart(label,data){
//   new Chart(document.getElementById("regChartId"), {
//     type : 'line',
//     data : {
//       labels : label,
//       datasets : [
//           {
//             data : data,
//             label : "",
//             borderColor : "#3cba9f",
//             fill : false
//           }]
//     },
//     options : {
//       plugins: {
//         legend: {
//             display: false
//           }
//       },
//       title : {
//         display : true,
//         text : 'Monthly registration'
//       }
//     }
//   });
// }



</script>
@endsection