<?php 
    use App\Models\Modules;
    use App\Models\Modulechapter;
    use App\Models\Modulechapterhistory;
     use App\Models\Media;
?>
@extends('frontend.master')
@section('maincontent') 
    <main id="main">

        <!-- Modal -->
        <div class="modal downloadCertificate fade" id="downloadCertificate" tabindex="-1" aria-labelledby="downloadCertificateLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="downloadCertificateLabel">Download your Shareable Certificate</h5>
                <div class="modalClose"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
              </div>
              <div class="modal-body">
                <form class="form" id="certificate_form">
                    <input type="hidden" name="module_id" id="module_id" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="first_name" placeholder="First Name" name="">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="last_name" placeholder="Last Name" name="">
                        </div>
                    </div>

                    <div class="gender">
                        <div class="mb-3"><label>Gender</label></div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="option1">
                          <label class="form-check-label" for="inlineRadio1">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="option2">
                          <label class="form-check-label" for="inlineRadio2">Female</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="gender" id="inlineRadio3" value="option3">
                          <label class="form-check-label" for="inlineRadio3">Others</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" name="address" id="address" placeholder="Address"></textarea>
                    </div>

                    <div class="alert alert-danger errorMessage" style="display:none;"></div>
                    <div class="alert alert-success successMessage" style="display:none;"></div>

                    <div class="mt-20 text-center">
                        <button type="button" id="submit_certificate" class="btn btn-mod btn-red btn-circle btn-medium">Submit</button>
                    </div>
                </form>

                <div id="download_pdf_box" style="display:none;">
                    
                </div>

              </div>
            </div>
          </div>
        </div>

        <div class="small-section">
            <!-- Slide Item -->
            <section class="home-section bg-gray-lighter">
                <div class="container">
                    <div class="row mb-20">
                        <div class="col-md-8">
                            <div class="mod-breadcrumbs">
                                <a href="{{ url('/') }}">Home</a>&nbsp;<i class="las la-angle-right"></i>&nbsp;<span>Modules</span>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center text-center mt-20">
                        <div class="col-md-8">
                            <h2 class="section-title font-alt align-center mb-60 mb-sm-10 wow fadeInDown" data-wow-delay="0.1s">
                                Modules
                            </h2>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($modules as $module)
                        <?php 
                            $totalminutes = Modulechapter::where('status','active')->where('module_id',$module->id)->sum('duration');
                            $total_chapter = Modulechapter::where('status','active')->where('module_id',$module->id)->count();
                            $completed_chapter = Modulechapterhistory::where('user_id',Auth::id())->where('module_id',$module->id)->count();
                            $if_download = 'no';
                            if($total_chapter != 0 && $total_chapter == $completed_chapter){
                                $if_download = 'yes';
                            }
                        ?>
                        <div class="col-md-6 mb-xs-20">
                            <div class="module-list">
                                <div class="row">
                                    <div class="col-md-5 mb-xs-10">
                                        <div class="image-round"><img src="{{ Media::geturl($module->banner_image) }}"></div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="category">{{$module->category}}</div>
                                        <div class="main-title">{{$module->title}}</div>
                                        <div class="description">
                                          {!! substr_replace($module->description, "...", 200)!!}

                                        </div>
                                        <div class="timeline mt-10 mb-10"><b>{{Modules::gethourandmin($totalminutes)}}</b></div>
                                        <div>
                                            <a href="{{ url('module-details/'.$module->slug) }}" class="btn btn-mod btn-red btn-circle btn-small">Start Now</a>

                                            <a href="javascript:;" data-id="{{$module->id}}" id="view_certificate_modal" data-download="{{$if_download}}" class="btn btn-mod btn-border btn-circle btn-small view_certificate_modal">Download Certificate</a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
            <!-- End Slide Item -->
        </div>
        <!-- End Fullwidth Slider -->

    </main>
@endsection

@section('navigation')
    @include('frontend.navigation')
@endsection

@section('scripts')
<link rel="stylesheet" type="text/css" href="{!! asset('css/toastr.min.css') !!}">
<script src="{!! asset('js/toastr.min.js') !!}"></script>
    <script type="text/javascript">
        $(document).on('click', '.view_certificate_modal', function(){
            $('.errorMessage').html('').hide();
            $('.successMessage').html('').hide();
            var module_id = $(this).attr('data-id');
            var download = $(this).attr('data-download');
            if(download != 'yes'){
                error_msg('Please complete all chapter and download certificatie');
                return false;
            }
            $('#certificate_form').show();
            $('#download_pdf_box').html('').hide();
            $('#module_id').val(module_id);
            $('#downloadCertificate').modal('show');
            return false;
        });

        $(document).on('click','.downloadpdflink', function(){
            $('#downloadCertificate').modal('hide');
        });

        $(document).on('click', '#submit_certificate', function(){
            var th = $(this);
            txt = th.text();
            th.text('Processing....').attr("disabled", true);
            var first_name = $('#first_name').val();
            var last_name = $('#last_name').val();
            var gender = $('input[name="gender"]:checked').val();
            var address = $('#address').val();
            var module_id = $('#module_id').val();
            $.ajax({
                url: '/certificatie/post',
                data: { first_name: first_name, last_name: last_name, gender:gender, address: address, module_id: module_id },
                dataType: 'json',
                type: 'GET',
                success: function(res){
                    if(res.status == 'success'){
                        $('#certificate_form')[0].reset();
                        //$('#downloadCertificate').modal('hide');
                        $('#certificate_form').hide();
                        $('#download_pdf_box').html('<a href="'+res.url+'" target="_blank" class="btn btn-primary btn-sm downloadpdflink">Download Certificate</a>').show();
                        th.text(txt).attr("disabled", false);
                        error_msg(res.msg);
                    }else{
                        th.text(txt).attr("disabled", false);
                        $('.errorMessage').html(res.msg).show();
                    }
                }, error: function(e){
                  th.text(txt).attr("disabled", false);
                  console.log(e.responseText());
                }
              });
        });

        function error_msg(msg){
            toastr.clear();
            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": false,
              "positionClass": "toast-bottom-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "1000",
              "hideDuration": "50",
              "timeOut": "3000",
              "extendedTimeOut": "100",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            toastr.error(msg);
        }

    </script>
@endsection