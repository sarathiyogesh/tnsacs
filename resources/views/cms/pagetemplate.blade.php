<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{!! csrf_token() !!}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.3.2/jquery-migrate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
  </head>
  <body>
	<!-- BEGIN CONTENT-->
	 <div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="mb-2">
                        <div class="row d-flex justify-content-between">
                            <div class="col col-6">
                                <h3>Custom Fields ({!! $pages->name !!})</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="customfieldsTemplate">
                        Loading...
                    </div>
                    <input type="hidden" id="cms_page_id" name="cms_page_id" value="{{$pages->id}}">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card mb-4">
                                <div class="card-header">Add New Section</div>
                                <div class="card-body">
                                    <div class="form-group mb-0">
                                        <label>Section Name <span>*</span></label>
                                        <input class="form-control" type="text" id="sectionName" placeholder="enter Section Name">
                                    </div>
                                </div>

                                <div class="card-body">
                                    <a href="javascript:;" id="addNewSectionBtn" class="btn btn-primary">Add</a>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="customizer" id="customizerField">
                        <div class="customizer-body" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                            <div class="handle"><i class="far fa-times-circle"></i></div>
                            <div class="card">
                                <div class="card-header">Custom Fields</div>
                                <div class="card-body">
                                    <input type="hidden" name="section_id" id="section_id" value="">
                                    <input type="hidden" name="add_type" id="add_type" value="">
                                    <input type="hidden" name="update_field_id" id="update_field_id" value="">
                                    <div class="form-group" id="existSectionName">
                                        <label>Section Name:</label>
                                        <b id="selectedSectionName">Select</b>
                                    </div>

                                    <div class="form-group" id="fieldTypeBox">
                                        <label>Select Field Type <span>*</span></label>
                                        <select class="form-control" id="fieldType">
                                            <option value="">--Choose--</option>
                                            <option value="plain_text">Plain Text</option>
                                            <option value="text_area">Textarea</option>
                                            <option value="text_editor">Text Editor</option>
                                            <option value="single_file_upload">Single File Upload</option>
                                            <option value="multiple_file_upload">Multiple File Upload</option>
                                            <option value="dropdown">Dropdown</option>
                                            {{-- <option value="checkbox">Checkbox</option>
                                            <option value="radio">Radio</option>
                                            <option value="datepicker">Date Picker</option>
                                            <option value="dateandtime">Date & Time</option>
                                            <option value="phonenumber">Phone</option>
                                            <option value="numbers">Number</option>
                                            <option value="amount">Amount</option>
                                            <option value="email">Email</option> --}}
                                        </select>
                                    </div>

                                    <div class="bx-2 mb-2">
                                        <div class="form-group" id="labelBox" style="display: none;">
                                            <label>Label <span>*</span></label>
                                            <input class="form-control" type="text" id="labelName" placeholder="enter label name">
                                        </div>

                                        <div class="form-group" id="propertyBox" style="display: none;">
                                            <label>Options <span>*</span></label>
                                            <ul id="sortable">
                                              
                                            </ul>
                                            <div class="input-group mb-3">
                                              <input type="text" class="form-control" placeholder="add new option" id="addOption">
                                              <div class="input-group-append">
                                                <a href="javascript:;" id="addOptionBtn" class="btn btn-primary">Add</a>
                                              </div>
                                            </div> 

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Slug</label>
                                        <input type="text" name="field_slug" id="field_slug" value="" placeholder="Slug" class="form-control">
                                        <em>auto-generated if empty</em>
                                    </div>

                                    <div class="form-group">
                                        <label>Select Column Length <span>*</span></label>
                                        <select class="form-control" id="field_column_length">
                                            <option value="">--Choose--</option>
                                            <option value="12" selected="selected">Col-md-12</option>
                                            <option value="8">col-md-8</option>
                                            <option value="6">col-md-6</option>
                                            <option value="4">col-md-4</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="checkbox checkbox-primary">
                                            <input type="checkbox" id="is_required"><span>&nbsp;&nbsp;Required Field?</span><span class="checkmark"></span>
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <a href="javascript:;" id="addCustomField" class="btn btn-primary">Add</a>
                                        <a href="javascript:;" id="cancelCustomField" class="btn btn-default">Cancel</a>
                                        <div id="error_msg"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    			</div>
			</div>
	</div><!--end #content-->
	<!-- END CONTENT -->
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
    <script type="text/javascript">
        window.parent.$('#cmsiFrameLoading').hide();
        $('#fieldType').on('change', function(){
            $('#labelBox').hide();
            $('#propertyBox').hide();
            var tval = $(this).val();
            if(tval == ''){
                return false;
            }
            if(tval == 'dropdown' || tval == 'checkbox' || tval == 'radio'){
                $('#labelBox').show();
                $('#propertyBox').show();
            }else{
                $('#labelBox').show();
            }
        });

        $("#sortable").sortable({
            revert: false,
        });

        $('#addOptionBtn').on('click', function(){
            var v = $('#addOption').val();
            if($.trim(v) == '' || v == undefined){
                $('#addOption').focus();
                return false;
            }
            $('#sortable').append('<li class="ui-state-default option_field_txt">'+$.trim(v)+' <span class="removeOption"><i class="nav-icon i-Close-Window font-weight-bold"></i></span></li>');
            $('#addOption').val('');
        });

        $(document).on('click', '.removeOption', function(){
            $(this).closest('li').remove();
        });

        function resetform(){
            $('#fieldType').val('').change();
            $('#labelName').val('');
            $('.option_field_txt').remove();
            $('#addOption').val('');
            $('#labelBox').hide();
            $('#propertyBox').hide();
            $('#addCustomField').text('Add');
            $('#add_type').val('add');
            $('#update_field_id').val('');
            $('#field_slug').val('');
            $('#field_column_length').val('12');
        }

        $('#cancelCustomField').on('click', function(){
            resetform();
        });

        getcustomfieldtemplate();

        function getcustomfieldtemplate(){
             $.ajax({
                url: '{!! route('cms.page.contenttemplate') !!}',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), },
                data: { cms_page_id: $('#cms_page_id').val() },
                dataType: 'json',
                type: 'POST',
                success: function(res){
                    $('#loadingbox').hide();
                    if(res.status == 'success'){
                        $('#customfieldsTemplate').html(res.template);

                        $("#customfieldsTemplate tbody").sortable({
                            revert: false,
                            update: function(event, ui) {
                                var t = $(this).find('tr');
                                var sec_pos = $(this).attr('section_pos');
                                var neworder = [];
                                t.each(function() {    
                                    var id  = $(this).attr("field_pos");
                                    neworder.push(id);
                                });
                                setTimeout(() => { updatefieldposition(sec_pos,neworder); }, 2000);
                            },
                        });
                    }else{
                        bootbox.alert(res.msg);
                    }
                    return false;
                }, error: function(e){
                    bootbox.alert(e.responseText);
                    return false;
                }
            });
        }


        function updatefieldposition(sec_id,positions) {
            $.ajax({
                url: '{!! route('cms.page.contenttemplate.updateposition') !!}',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), },
                data: { sec_id,positions },
                dataType: 'json',
                type: 'POST',
                success: function(res){
                    if(res.status == 'success'){
                       //bootbox.alert('Position updated');
                    }else{
                        bootbox.alert(res.msg);
                    }
                    return false;
                }, error: function(e){
                    bootbox.alert(e.responseText);
                    return false;
                }
            });
        }

        $('#addCustomField').on('click', function(){
            var t = $(this);
            $('.validate').remove();
            var add_type = $('#add_type').val();
            var update_field_id = $('#update_field_id').val();
            var section_id = $('#section_id').val();
            var field_type = $('#fieldType').val();
            var label_name = $('#labelName').val();
            var field_slug = $('#field_slug').val();
            var field_column_length = $('#field_column_length').val();
            if(add_type == ''){ bootbox.alert('Select action (add,edit)'); return false; }
            if(section_id == ''){ bootbox.alert('Section not found'); return false; }
            if(field_type == ''){ console.log('asdfasf'); $('#fieldType').focus(); return false; }
            if(label_name == ''){ $('#labelName').focus(); return false; }
            is_required = 'no';
            if($('#is_required').prop('checked') == true){
                is_required = 'yes';
            }
            var options = [];
            if(field_type == 'dropdown' || field_type == 'checkbox' || field_type == 'radio'){
                $('.option_field_txt').each(function(){
                    options.push($(this).text());
                });
                if(options.length == 0){ $('#addOption').focus(); return false; }
            }
            options = JSON.stringify(options);
            datas = { add_type:add_type,update_field_id:update_field_id,section_id:section_id,field_type:field_type,label_name:label_name,is_required:is_required,options:options,field_slug:field_slug,field_column_length:field_column_length,cms_page_id: $('#cms_page_id').val() };
            t.text('Processing...').attr('disabled', true);
            $.ajax({
                url: '{!! route('cms.page.addcustomfields') !!}',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), },
                data: datas,
                dataType: 'json',
                type: 'POST',
                success: function(res){
                    t.text('Add').attr('disabled', false);
                    $('.validate').remove();
                    if(res.status == 'validation'){
                        $.each(res.validation, function(k,v){
                            $('#error_msg').append('<span class="validate">'+v+'</span>');
                        });
                    }else if(res.status == 'success'){
                        resetform();
                        getcustomfieldtemplate();
                    }else{
                        bootbox.alert(res.msg);
                    }
                    return false;
                }, error: function(e){
                    t.text('Add').attr('disabled', false);
                    $('.validate').remove();
                    bootbox.alert(e.responseText);
                    return false;
                }
            });
        });

        $(document).on('click', '.addCustomFieldBtn', function(){
            resetform();
            var t = $(this);
            var sec_id = t.attr('sec-id');
            var txt = t.attr('data-txt');
            $('#selectedSectionName').text(txt);
            var type = 'add';
            var update_field_id = '';
            $('#update_field_id').val(update_field_id);
            $('#add_type').val(type);
            $('#section_id').val(sec_id);
            $('#customizerField').removeClass('open').addClass('open');
            $('#fieldType').focus();
        });

        $('#addNewSectionBtn').on('click', function(){
            var t = $(this);
            var sec_name = $('#sectionName').val();
            if($.trim(sec_name) == ''){
                $('#sectionName').focus();
                return false;
            }
            t.text('Processing...').attr('disabled', true);
            $.ajax({
                url: '{!! route('cms.page.addcustomfieldssection') !!}',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), },
                data: { sec_name:sec_name,cms_page_id: $('#cms_page_id').val() },
                dataType: 'json',
                type: 'POST',
                success: function(res){
                    t.text('Add').attr('disabled', false);
                    if(res.status == 'success'){
                        //bootbox.alert(res.msg);
                        getcustomfieldtemplate();
                        $('#sectionName').val('');
                    }else{
                        bootbox.alert(res.msg);
                    }
                    return false;
                }, error: function(e){
                    t.text('Add').attr('disabled', false);
                    bootbox.alert(e.responseText);
                    return false;
                }
            });
        });

        $(document).on('click', '.removeSectionBtn', function(){
            var t = $(this);
            var sec_id = t.attr('sec-id');
            bootbox.confirm("Do you want to remove this section?", function(result){
                if(result){
                    $.ajax({
                        url: '{!! route('cms.page.removecustomfieldssection') !!}',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), },
                        data: { sec_id:sec_id,cms_page_id: $('#cms_page_id').val() },
                        dataType: 'json',
                        type: 'POST',
                        success: function(res){
                            if(res.status == 'success'){
                                getcustomfieldtemplate();
                            }else{
                                bootbox.alert(res.msg);
                            }
                            return false;
                        }, error: function(e){
                            bootbox.alert(e.responseText);
                            return false;
                        }
                    });
                }
            });
        });

        $(document).on('click' ,'.removeField', function(){
            var t = $(this);
            var field_id = t.attr('field-id');
            bootbox.confirm("Do you want to remove this field?", function(result){
                if(result){
                    $.ajax({
                        url: '{!! route('cms.page.removecustomfieldssingle') !!}',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), },
                        data: { field_id:field_id,cms_page_id: $('#cms_page_id').val() },
                        dataType: 'json',
                        type: 'POST',
                        success: function(res){
                            if(res.status == 'success'){
                                getcustomfieldtemplate();
                            }else{
                                bootbox.alert(res.msg);
                            }
                            return false;
                        }, error: function(e){
                            bootbox.alert(e.responseText);
                            return false;
                        }
                    });
                }
            });
        });

        $(document).on('click' ,'.editField', function(){
            resetform();
            var t = $(this);
            var field_id = t.attr('field-id');
            $.ajax({
                url: '{!! route('cms.page.editcustomfieldssingle') !!}',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), },
                data: { field_id:field_id,cms_page_id: $('#cms_page_id').val() },
                dataType: 'json',
                type: 'POST',
                success: function(res){
                    if(res.status == 'success'){
                        //getcustomfieldtemplate();
                        info = res.info;
                        $('#selectedSectionName').text(info.section_name);
                        $('#fieldType').val(info.field_type).change();
                        $('#labelName').val(info.label_name);
                        $('#field_column_length').val(info.column_length);
                        if(info.is_required == 'yes'){
                            $('#is_required').prop('checked', true);
                        }else{
                            $('#is_required').prop('checked', false);
                        }
                        if(info.field_type == 'dropdown' || info.field_type == 'checkbox' || info.field_type == 'radio'){
                            $.each(info.options, function(k,v){
                                $('#sortable').append('<li class="ui-state-default option_field_txt">'+$.trim(v)+' <span style="color:red; cursor:pointer;" class="removeOption"><i class="fas fa-trash-alt"></i></span></li>');
                            });
                        }else{
                            $('.option_field_txt').remove();
                        }
                        $('#update_field_id').val(info.update_field_id);
                        $('#add_type').val('edit');
                        $('#section_id').val(info.sec_id);
                        $('#customizerField').removeClass('open').addClass('open');
                        $('#addCustomField').text('Update');
                    }else{
                        bootbox.alert(res.msg);
                    }
                    return false;
                }, error: function(e){
                    bootbox.alert(e.responseText);
                    return false;
                }
            });
        });

    </script>
  </body>
</html>