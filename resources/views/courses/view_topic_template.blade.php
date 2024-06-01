<?php 
	use App\Models\Coursetopicfield;
?>

<div class="accordion" id="accordionExample">
  	<div class="accordion-item">
	    <h2 class="accordion-header" id="headingOne">
	      <!-- <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> -->
	        {{$topic->topic_name}}
	      </button>
	    </h2>
	    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
	      <div class="accordion-body">
	      	<div class="form-check d-flex justify-content-end mb-3">
			  	<input class="form-check-input me-3" type="checkbox" value="" id="flexCheckDefault">
			  	<label class="form-check-label" for="flexCheckDefault">
			    	<b>Mark as Completed</b>
			  	</label>
			</div>
	        <!-- <h4>Topic 1 Description</h4> -->
			<p>{!! $topic->description !!}</p>
			<?php $j = 1; ?>
			@foreach($sub_topics as $topic)
			<div class="course-body-">
				<div class="course-innertopics-header">
					<div>{{$topic->topic_name}}</div>
					<div class="subopenclose subopenclose_{{$topic->id}}" data-id="{{$j}}"><a href="javascript:;"><i class="las la-plus"></i></a></div>
				</div>

				<div class="course-subtopics subtopic{{$j}}Div" style="display: none;">
					<?php
					 $topic_fields = Coursetopicfield::where('course_id',$course->id)->where('course_topic_id',$topic->id)->get();
					?>
					@foreach($topic_fields as $field)
						@if($field->field_type == 'text-area')
							{!! $field->field_value !!}
						@endif
						@if($field->field_type == 'text-editor')
							{!! $field->field_value !!}
						@endif
						@if($field->field_type == 'audio')
							{!! $field->field_value !!}
						@endif
						@if($field->field_type == 'video')
							{!! $field->field_value !!}
						@endif
						@if($field->field_type == 'iframe')
							{!! $field->field_value !!}
						@endif
						@if($field->field_type == 'pdf')
							{!! $field->field_value !!}
						@endif
					@endforeach
				</div>

			</div>
			<?php $j++; ?>
			@endforeach
	      </div>
	    </div>
  	</div>
</div>