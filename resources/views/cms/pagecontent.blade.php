@extends("master")
@section('maincontent')

    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Toolbar-->
        <div class="toolbar" id="kt_toolbar">
            <!--begin::Container-->
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <!--begin::Title-->
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">{!! $page->name !!} CMS</h1>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="javascript:;" id="addTemplate" data-url="{{route('cms.page.template',[$page->id])}}" class="btn btn-sm btn-primary" ><i class="fas fa-user-plus"></i>&nbsp;Add/Edit Template</a>
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Post-->
        
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">
                <div class="card card-flush">
                    <div class="card-body">

                        <div class="row" id="customfieldsTemplate">
                            @include('cms.customfield_preview_template',['asset_master_id' => $page->id,'custom_fields'=>$custom_fields,'template'=>'no'])
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!--end::Post-->
    </div>
    <!--end::Content-->

    <!-- Modal Fullscreen xl -->
     <div class="modal" id="cmsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Update Template</h5>
            <a href="javascript:;" class="btn btn-sm btn-primary" id="closecmsModal">Close</a>
          </div>
          <div class="modal-body" style="height: 600px;">
                <div class="cmscontainer" id="cmsiFrame">
                    <div class="cmsloading" id="cmsiFrameLoading"><img src="{{url('loading.jpg')}}" alt=""></div>
                </div>
          </div>
        </div>
      </div>
    </div>

 <input type="hidden" id="cms_page_id" name="cms_page_id" value="{{$page->id}}">
 <input type="hidden" id="commonCopy" name="commonCopy" value="">
@stop

@section('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('backend/js/media_handler.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.js"></script>
    <script>
        $(".custom_field_texteditor").summernote();
        $('#closecmsModal').on('click', function() {
            $(this).text('Refreshing....');
            location.reload(true);
        });
        $(document).on('click','#addTemplate', function(){
            $('#cmsiFrameLoading').show();
            $('#cmsModal').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#cmsiFrame').find('iframe').remove();
            $('#cmsiFrame').append('<iframe height="100%" width="100%" frameborder="0" src="'+$(this).attr('data-url')+'">Your browser isnt compatible</iframe>');
        });


        $(".image-holder-box").sortable({
            revert: false,
        });

        $(document).on('click','.updateSectionContent', function(){
            var t = $(this);
            var section_id = t.attr('data-sec');
            var d = $('.sectionForm_'+section_id).serialize();
            d = d+'&page_id='+$('#cms_page_id').val()+'&section_id='+section_id;
            t.text('Processing...');
            $.ajax({
                url: '{!! route('cms.page.content.update') !!}',
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'), },
                data: d,
                dataType: 'json',
                type: 'POST',
                success: function(res){
                    t.text('Update');
                    if(res.status == 'success') {
                        success_msg(res.msg);
                    }else{
                        error_msg('Error. Please try again');
                    }
                    return false;
                }, error: function(e){
                    t.text('Update');
                    return false;
                }
            });
        });

        $(document).on('click','.copyField', function(){
            var t = $(this);
            var val = t.attr('copy-field');
            var type = t.attr('copy-type');
            console.log(val);
            console.log(type);
            if(type == 'text'){
                $('#commonCopy').text('{'+'!'+'!'+' Helpers::getcontent("'+val+'") !'+'!'+'}');
            }else if(type == 'single') {
                $('#commonCopy').text('{'+'!'+'!'+' Helpers::getsingleimage("'+val+'") !'+'!'+'}');
            }else if(type == 'multiple'){
                $('#commonCopy').text('Helpers::getmultipleimage("'+val+'")');
            }
            var val = $('#commonCopy').text();
            console.log(val);
            $('input.linkToCopy').val(val).select();
            document.execCommand("copy");
            success_msg('Copied to clipboard');
            $('#commonCopy').text('');
        });
    </script>
@stop
