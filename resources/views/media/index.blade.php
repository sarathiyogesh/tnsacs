@extends("master")
@section('styles')
{!!HTML::style('backend/assets/css/theme-default/libs/DataTables/jquery.dataTables.css')!!}
{!!HTML::style('backend/assets/css/theme-default/libs/DataTables/extensions/dataTables.colVis.css')!!}
{!!HTML::style('backend/assets/css/theme-default/libs/DataTables/extensions/dataTables.tableTools.css')!!}
@stop
@section('pageTitle')
	Media | {!! Helpers::sitetitle() !!} 
@stop
@section('maincontent')
	<!-- BEGIN CONTENT-->
	<div id="content">
		<section class="style-default-bright">
			<div class="section-header ">
				<ol class="breadcrumb">
					<li><a href="{{ route('index') }}">Home</a></li>
					<li class="active">Media</li>
				</ol>
			</div>
			<div class="section-header">
				<div class="row">
					<div class="col-lg-6">
						<h2 class="text-primary">Manage Media</h2>
					</div>
				</div>
			</div>

			{!! Form::text("image_link", "", ["id"=>"image_link",'style'=>'display:none;']) !!}

			<div class="section-body">
				<div class="row">
					<div class="col-lg-12">
							<iframe height="100%" width="100%" frameborder="0" src="{{url('manage/console/medias/template?select=no&select_type=single&input_name=&values=')}}" style="min-height:650px">Your browser isnt compatible</iframe>
					</div><!--end .col -->
				</div><!--end .row -->
				<!-- END DATATABLE 1 -->

			</div><!--end .section-body -->
		</section>
	</div><!--end #content-->
	<!-- END CONTENT -->
@stop

@section('scripts')
	{!! HTML::script('backend/assets/js/libs/DataTables/jquery.dataTables.min.js') !!}
	{!! HTML::script('backend/assets/js/libs/DataTables/extensions/ColVis/js/dataTables.colVis.min.js') !!}
	{!! HTML::script('backend/assets/js/libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js') !!}
	{!! HTML::script('backend/assets/js/core/demo/DemoTableDynamic.js') !!}
	{!! HTML::script('backend/js/admin.js') !!}
	<script type="text/javascript">
	$(document).ready(function(){
    	$('#myTable').DataTable();
    	
	});
	</script>
@stop


