<?php $j = 1; ?>
@foreach($sub_topics as $topic)
<div class="course-body-">
	<div class="course-innertopics-header">
		<div>{{$topic->topic_name}}</div>
		<div class="subopenclose" data-id="{{$j}}" data-topic="{{$topic->id}}"><a href="javascript:;"><i class="las la-plus"></i></a></div>
	</div>
	<div class="course-subtopics subtopic{{$j}}Div" style="display: none;">
		
		<div class="mb-2 d-flex justify-content-end"><a href="javascript:;" class="btn btn-info btn-xs openSubTopicFieldModal" data-bs-toggle="modal" data-id="{{$topic->id}}"><i class="las la-plus"></i> Add Field</a></div>

		<div class="topicFieldTemplate_{{$topic->id}}">
			
		</div>
		
		<!-- <div class="col-md-12">
			<div class="form-group">
				<label class="required form-label">Topic Name</label>
				<input type="text" name="StaffName" class="form-control mb-2" value="{{$topic->topic_name}}">
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label class="required form-label">Title 1</label>
				<input type="text" name="StaffName" class="form-control mb-2" value="The Name India">
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label class="required form-label">Video 1</label>
				<textarea name="description" id="description" class="form-control mb-2" placeholder="Topic Description" rows="3"><iframe src="https://player.vimeo.com/video/434081100" width="640" height="564" align="center" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe></textarea>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label class="required form-label">Title 2</label>
				<input type="text" name="StaffName" class="form-control mb-2" value="The Geography of Bharat">
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label class="required form-label">Video 2</label>
				<textarea name="description" id="description" class="form-control mb-2" placeholder="Topic Description" rows="3"><iframe src="https://player.vimeo.com/video/434081100" width="640" height="564" align="center" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe></textarea>
			</div>
		</div>
		 -->
	</div>
</div>
<?php $j++; ?>
@endforeach