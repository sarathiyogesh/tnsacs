@extends("master")

@section('maincontent')
	<!--begin::Content-->
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
		<!--begin::Toolbar-->
		<div class="toolbar" id="kt_toolbar">
			<!--begin::Container-->
			<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
				<!--begin::Page title-->
				<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title flex-wrap me-3 mb-5 mb-lg-0">
					<!--begin::Title-->
					<h1 class="d-flex fw-bold fs-3 align-items-center my-1">Hello Flynet &nbsp; <img src="{!! asset('waving.png') !!}"></h1>
          <div>Let’s learn something  today!</div>
					<!--end::Title-->
				</div>
				<!--end::Page title-->
				<!--begin::Actions-->
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