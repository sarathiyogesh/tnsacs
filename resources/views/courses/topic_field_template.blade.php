<form id="fieldForm_{{$topic_id}}">
@foreach($topic_fields as $field)
	<p>{{ $field->field_title }}</p>
	@if($field->field_type == 'text-area')
		<div class="col-md-12">
			<div class="form-group">
				<label class="required form-label">Normal Text</label>
				<textarea name="fv_{{$field->id}}" id="fv_{{$field->id}}" class="form-control mb-2" placeholder="Content" rows="3">{!! $field->field_value !!}</textarea>
			</div>
		</div>
	@endif
	@if($field->field_type == 'text-editor')
		<div class="col-md-12">
			<div class="form-group">
				<label class="required form-label">Text Editor</label>
				<textarea name="fv_{{$field->id}}" id="fv_{{$field->id}}" class="form-control mb-2 summernote" placeholder="Content" rows="3">{!! $field->field_value !!}</textarea>
			</div>
		</div>
	@endif
	@if($field->field_type == 'audio')
		<div class="col-md-12">
			<div class="form-group">
				<label class="required form-label">Audio Link</label>
				<textarea name="fv_{{$field->id}}" id="fv_{{$field->id}}" class="form-control mb-2" placeholder="Audio Link" rows="3">{!! $field->field_value !!}</textarea>
			</div>
		</div>
	@endif
	@if($field->field_type == 'video')
		<div class="col-md-12">
			<div class="form-group">
				<label class="required form-label">Video Link</label>
				<textarea name="fv_{{$field->id}}" id="fv_{{$field->id}}" class="form-control mb-2" placeholder="Video Link" rows="3">{!! $field->field_value !!}</textarea>
			</div>
		</div>
	@endif
	@if($field->field_type == 'iframe')
		<div class="col-md-12">
			<div class="form-group">
				<label class="required form-label">IFrame</label>
				<textarea name="fv_{{$field->id}}" id="fv_{{$field->id}}" class="form-control mb-2" placeholder="Iframe" rows="3">{!! $field->field_value !!}</textarea>
			</div>
		</div>
	@endif
	@if($field->field_type == 'pdf')
		<div class="col-md-12">
			<div class="form-group">
				<label class="required form-label">PDF Link</label>
				<textarea name="fv_{{$field->id}}" id="fv_{{$field->id}}" class="form-control mb-2" placeholder="PDF Link" rows="3">{!! $field->field_value !!}</textarea>
			</div>
		</div>
	@endif
	<br><br>
@endforeach
</form>
@if(count($topic_fields))
<div class="mb-2 d-flex justify-content-end"><a href="javascript:;" class="btn btn-success btn-xs updateSubTopicFieldBtn" data-id="{{$topic_id}}">Update</a></div>
@endif