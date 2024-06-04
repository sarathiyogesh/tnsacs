<?php 
    use App\Models\Modules;
    use App\Models\Modulechapter;
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
                        <form class="form">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="First Name" name="">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Last Name" name="">
                                </div>
                            </div>

                            <div class="gender">
                                <div class="mb-3"><label>Gender</label></div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                  <label class="form-check-label" for="inlineRadio1">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                  <label class="form-check-label" for="inlineRadio2">Female</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                                  <label class="form-check-label" for="inlineRadio3">Others</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <textarea class="form-control" placeholder="Address"></textarea>
                            </div>

                            <div class="mt-20 text-center">
                                <button type="button" class="btn btn-mod btn-red btn-circle btn-medium">Submit</button>
                            </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="home-section fullwidth-slider" id="home">
                    <!-- Slide Item -->
                    <section class="home-section bg-gray-lighter">
                        <div class="js-height-full container">
                            <!-- Hero Content -->
                            <div class="home-content">
                                <div class="home-text">
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
                                        ?>
                                        <div class="col-md-6">
                                            <div class="module-list">
                                                <div class="row">
                                                    <div class="col-md-5">
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
                                                            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#downloadCertificate" class="btn btn-mod btn-border btn-circle btn-small">Download Certificate</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- End Hero Content -->
                        </div>
                    </section>
                    <!-- End Slide Item -->
                </div>
                <!-- End Fullwidth Slider -->

            </main>
@endsection