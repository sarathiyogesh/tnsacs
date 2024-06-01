<?php 
    use App\Models\Modules;
    use App\Models\Modulechapter;
     use App\Models\Media;
?>
@extends('frontend.master')
@section('maincontent') 
            <main id="main">
                <!-- Fullwidth Slider -->
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
                                                        <div><a href="{{ url('module-details/'.$module->slug) }}" class="btn btn-mod btn-red btn-circle btn-medium">Start Now</a></div>
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