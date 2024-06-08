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


      <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
          <div class="row mb-5">
            <div class="col-md-6">
                <div class="row mb-5">
                  <div class="col-md-6">
                    <div class="card card-info">
                      <div class="card-body">
                        <div class="mb-3"><img src="{!! URL::asset('backend/icon-01.svg') !!}"></div>
                        <h4>Total number of users of this Learning</h4>
                        <h1 id="total_user"></h1>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card card-info">
                      <div class="card-body">
                        <div class="mb-3"><img src="{!! URL::asset('backend/icon-02.svg') !!}"></div>
                        <h4>Total number of Modules covered</h4>
                        <h1 id="total_module"></h1>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="card card-info">
                      <div class="card-body">
                        <div class="title">Average time spent</div>
                        <p class="mb-0">Users that learn our chapters in modules</p>

                        <hr>
                      </div>
                    </div>
                  </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-info">
                  <div class="card-body">
                    <div class="title">Top Performing Chapters</div>

                    <table class="table">
                      <thead>
                        <tr>
                          <th>&nbsp;</th>
                          <th class="text-center">Visitor</th>
                          <th class="text-center">Completed</th>
                        </tr>
                      </thead>

                      <tbody id="chapter_perform_data">
                        
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="card card-info mh-set1">
                  <div class="card-body">
                    <div class="title mb-5">Overall completion rate</div>

                      <div class="row d-flex align-items-center">
                      <div class="col-md-6" id="module_completion">
                       

                       
                      </div>

                      <div class="col-md-6">
                        <div class="text-center">

                          <div class="overall_com_rate" data-percent="73"><span id="overall_com_box">73</span>%</div>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>

            <div class="col-md-6">
              <div class="card card-info mh-set1">
                  <div class="card-body">
                    <div class="card-info-two mb-3">
                      <h3>Modules Viewed</h3>

                      <div class="text-center">
                        <div class="count">173648</div>
                        <div class="desc">Average module views</div>
                      </div>
                    </div>

                    <div class="card-info-two">
                      <h3>Hours Viewed</h3>

                      <div class="text-center">
                        <div class="count">238978</div>
                        <div class="desc">Average hours watched</div>
                      </div>
                    </div>
                  </div>
                </div>
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

   <script src="https://cdnjs.cloudflare.com/ajax/libs/easy-pie-chart/2.1.6/jquery.easypiechart.min.js"></script>

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
          $('#total_user').text(data.total_user);
          $('#total_module').text(data.total_module);
          $('#chapter_perform_data').html(data.chapter_perform_data);
          $('#module_completion').html(data.module_completion);
          $('#overall_com_box').text(data.overall_completion_percentage);
          overall_completion_per();

          // $('.today_trans').text(data.today_trans);
          // $('.thismonth_trans').text(data.thismonth_trans);
          // $('.lastsix_trans').text(data.lastsix_trans);
          // $('.last12month_trans').text(data.last12month_trans);

          // $('.coruser_count').text(data.coruser_count);
          // $('.prouser_count').text(data.prouser_count);
          // $('.reg_count').text(data.reg_count);

          // salestranssummarychart(data.sales_count_label,data.sales_count_data);
          // salestkesummarychart(data.sales_count_label,data.sales_tktcount_data);
          // activitychart(data.topsalesitemlabel,data.topsalesitemdata);
          // regchart(data.sales_count_label,data.sales_regcount_data);
      }
    }, error: function(e){
      console.log(e.responseText());
    }
  });
}

function overall_completion_per(){
   $('.overall_com_rate').easyPieChart({
    size: 160,
    barColor: "#17d3e6",
    scaleLength: 0,
    lineWidth: 15,
    trackColor: "#373737",
    lineCap: "circle",
    animate: 2000,
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