@extends("master")
@section('pageTitle')
	All media | {!! Helpers::sitetitle() !!} 
@stop
@section('maincontent')
	<!-- BEGIN CONTENT-->
	<div id="content">
		<section>
			<div class="section-header ">
				<ol class="breadcrumb">
					<li><a href="{{ route('index') }}">Home</a></li>
					<li><a href="{{ route('media.index') }}">Media</a></li>
					<li class="active">Add New Media</li>
				</ol>
			</div>
			<div class="section-body">
				<!-- BEGIN VERTICAL FORM -->
				<div class="row">
					<div class="col-lg-12">
						<h1 class="text-primary">Add New Media</h1>
					</div><!--end .col -->
					<div class="col-lg-3 col-md-4">
						
						<div class="section-header">
							{!! HTML::link(route('media.index'),"Manage Media",["class"=>"btn ink-reaction btn-block btn-primary"]) !!}
						</div>
					</div><!--end .col -->
					<div class="col-md-9">
						{!! Form::open(["route"=>"media.store","class"=>"form", 'files'=>true]) !!}
							<div class="card">
								<div class="card-head style-primary">
									<header>Create Media</header>
								</div>
								{!! Helpers::displaymsg() !!}
								<div class="card-body">
									

									<div class="form-group @if($errors->has('mediaFile'))has-error @endif">
										{!! HTML::decode(Form::label("mediaFile","Media File")) !!}<br>
										{!! Form::file("mediaFile",["class"=>"form-control", 'id'=>'mediaFile']) !!}
										@if($errors->has("mediaFile"))
											<span id="mediaFile-error" class="help-block">{!! $errors->first("mediaFile") !!}</span>
										@endif
									</div>


								</div><!--end .card-body -->

								<div class="card-actionbar">
									<div class="card-actionbar-row">
										<button type="submit" class="btn ink-reaction btn-primary-dark" id="submitMedia">Add Media</button>
									</div>
								</div>

							</div><!--end .card -->
						{!! Form::close() !!}
					</div><!--end .col -->
				</div><!--end .row -->
				<!-- END VERTICAL FORM -->
			</div>
		</section>
	</div><!--end #content-->
	<!-- END CONTENT -->
@stop

@section("script")
{!!HTML::script('backend/js/bala.js')!!}

<script type="text/javascript">
	$('#submitMedia').click(function () {
		var val = $('#mediaFile').val();
		if(val == ''){
			alert('Please select any media file.');
			return false;
		}
	});	
</script>

@stop