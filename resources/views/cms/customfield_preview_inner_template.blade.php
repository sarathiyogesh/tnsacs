<?php
    use App\Models\Customfieldsection;
    use App\Models\Customfield;
    use App\Models\Customfieldmeta;
?>
<div class="row">
@foreach($sections->chunk(2) as $secs)
    @foreach($secs as $section)
        @if($section->field_type == 'plain_text' || $section->field_type == 'datepicker' || $section->field_type == 'dateandtime' || $section->field_type == 'phonenumber' || $section->field_type == 'numbers' || $section->field_type == 'amount' || $section->field_type == 'email')
            <div class="col-md-{{$section->column_length}}">
                <div class="form-group">
                    <label>
                        {!! $section->label_name !!} @if($section->is_required == 'yes') <span>*</span> @endif 
                    </label>
                    <input class="form-control" type="text" value='{!! $section->field_value !!}' name="{!! $section->field_slug !!}" placeholder="enter {!! $section->label_name !!}">
                    <a class="text-danger mr-2 copyField" copy-type="text" copy-field="{!! $section->field_slug !!}" href="javascript:;">copy</a>
                </div>
            </div>

        @endif

        @if($section->field_type == 'text_area' || $section->field_type == 'text_editor')
            <div class="col-md-{{$section->column_length}}">
                <div class="form-group">
                    <label>{!! $section->label_name !!} @if($section->is_required == 'yes') <span>*</span> @endif</label>
                    <textarea name="{!! $section->field_slug !!}" class="form-control @if($section->field_type == 'text_editor') custom_field_texteditor ckeditor @endif" rows="3" placeholder="enter {!! $section->label_name !!}">{!! $section->field_value !!}</textarea>
                    <a class="text-danger mr-2 copyField" copy-type="text" copy-field="{!! $section->field_slug !!}" href="javascript:;">copy</a>
                </div>
            </div>
        @endif


        @if($section->field_type == 'single_file_upload' || $section->field_type == 'multiple_file_upload')
            <?php
                $copyType = 'single';
                if($section->field_type == 'multiple_file_upload'){
                    $copyType = 'multiple';
                }
            ?>
            <div class="col-md-{{$section->column_length}}">
                <div class="form-group">
                    <label>{!! $section->label_name !!} @if($section->is_required == 'yes') <span>*</span> @endif</label>
                    @include('media.select_media_template',['options'=>['select'=>'yes','select_type'=>$section->field_type == 'single_file_upload'?'single':'multiple','input_name'=>$section->field_slug,'values'=>$section->field_value]])
                    <a class="text-danger mr-2 copyField" copy-type="{!! $copyType !!}" copy-field="{!! $section->field_slug !!}" href="javascript:;">copy</a>
                </div>
            </div>
        @endif

        <?php
            $section_meta = Customfieldmeta::where('custom_field_id', $section->id)->orderBy('id','ASC')->select('field_value','id')->get();
        ?>
        @if($section->field_type == 'dropdown')
            <div class="col-md-{{$section->column_length}}">
                <div class="form-group">
                    <label>{!! $section->label_name !!} @if($section->is_required == 'yes') <span>*</span> @endif</label>
                    <select class="form-control" name="{!! $section->field_slug !!}">
                        <option value="">--Select--</option>
                        @foreach($section_meta as $meta)
                            <option value="{!! $meta->field_value !!}" @if($meta->field_value == $section->field_value) selected="selected" @endif>{!! $meta->field_value !!}</option>
                        @endforeach
                    </select>
                    <a class="text-danger mr-2 copyField" copy-type="text" copy-field="{!! $section->field_slug !!}" href="javascript:;">copy</a>
                </div>
            </div>
        @endif

        @if($section->field_type == 'checkbox')
            <div class="col-md-{{$section->column_length}}">
                <div class="form-group">
                    <label>{!! $section->label_name !!} @if($section->is_required == 'yes') <span>*</span> @endif</label>
                     <div class="action-icons">
                        <a class="text-success mr-2 editField" field-id="{{encrypt($section->id)}}" href="javascript:;"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                        <a class="text-danger mr-2 removeField" field-id="{{encrypt($section->id)}}" href="javascript:;"><i class="nav-icon i-Close-Window font-weight-bold"></i></a>
                    </div>
                    <div class="form-check-inline">
                        @foreach($section_meta as $meta)
                            <label class="checkbox checkbox-primary mr-3">
                                <input type="checkbox" value="{!! $meta->field_value !!}"><span>{!! $meta->field_value !!}</span><span class="checkmark"></span>
                            </label>
                        @endforeach
                    </div>
                    <a class="text-danger mr-2 copyField" copy-type="text" copy-field="{!! $section->field_slug !!}" href="javascript:;">copy</a>
                </div>
            </div>
        @endif

         @if($section->field_type == 'radio')
            <div class="col-md-{{$section->column_length}}">
                <div class="form-group">
                    <label>{!! $section->label_name !!} @if($section->is_required == 'yes') <span>*</span> @endif</label>
                    <div class="form-check-inline">
                        @foreach($section_meta as $meta)
                            <label class="radio radio-primary mr-3">
                                <input type="radio" name="radio" value="{!! $meta->field_value !!}"><span>{!! $meta->field_value !!}</span><span class="checkmark"></span>
                            </label>
                        @endforeach
                    </div>
                    <a class="text-danger mr-2 copyField" copy-type="text" copy-field="{!! $section->field_slug !!}" href="javascript:;">copy</a>
                </div>
            </div>
        @endif
    @endforeach
@endforeach
</div>