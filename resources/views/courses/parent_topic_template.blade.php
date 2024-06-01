<?php $i = 1; ?>
@foreach($parent_topics as $topic)
<div class="course-topics">
	<div class="course-topics-header">
		<div>{{$topic->topic_name}}</div>
		<div class="openclose openclose_{{$topic->id}}" data-id="{{$i}}" data-topic="{{$topic->id}}"><a href="javascript:;"><i class="las la-plus"></i></a></div>
	</div>
	<div class="course-body topic{{$i}}Div" style="display:none;">
		<div class="mb-2 d-flex justify-content-end"><a href="javascript:;" class="btn btn-info btn-xs openSubTopicModal" data-bs-toggle="modal" data-id="{{$topic->id}}"><i class="las la-plus"></i> Add Topic Sections</a></div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label class="required form-label">Topic Name</label>
					<input type="text" name="updateTopic_{{$topic->id}}" id="updateTopic_{{$topic->id}}" class="form-control mb-2" placeholder="Course Topic Name" value="{{$topic->topic_name}}">
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label class="required form-label">Topic Description</label>
					<textarea name="updateDescription_{{$topic->id}}" id="updateDescription_{{$topic->id}}" class="form-control mb-2 summernote" placeholder="Topic Description" rows="3">{{$topic->description}}</textarea>
				</div>
			</div>

			<div class="mb-2 d-flex justify-content-end"><a href="javascript:;" class="btn btn-success btn-xs updateParentFieldBtn"data-id="{{$topic->id}}">Update</a></div>

			<div class="subTopicTemplate_{{$topic->id}}">

			</div>
		</div>
	</div>
</div>
<?php $i++; ?>
@endforeach