<?php
    use App\Models\Media;
?>
@extends('frontend.master')
@section('maincontent') 
    <main id="main">
        <!-- Fullwidth Slider -->
        <div class="home-section fullwidth-slider" id="home">
            <!-- Slide Item -->
            <section class="home-section bg-scroll fixed-height-small" data-background="{{ asset('frontend/images/home.jpg') }}">
                <div class="js-height-parent container-1400">
                    
                    <!-- Hero Content -->
                    <div class="home-content">
                        <div class="home-text">
                            <div class="row d-flex align-items-center">  
                                <div class="col-12 col-md-7 m-center pt-xs-30">
                                    <div class="hs-line-1 no-transp font-alt mb-30 mb-xs-10">
                                        {!! Helpers::getcontent('section_1_13') !!}
                                    </div>

                                    <div class="banner-desc">
                                        {!! Helpers::getcontent('section_1_14') !!}
                                    </div>
                                    
                                    <div class="local-scroll mt-30">
                                        <a href="{{ url('signup') }}" class="me-3 btn btn-mod btn-red btn-circle btn-medium shadow">Sign up</a>
                                        <a href="{{ url('signin') }}" class="btn btn-mod btn-border btn-circle btn-medium shadow">Login</a>
                                    </div>
                                </div>

                                <div class="col-12 col-md-5 pt-xs-10">
                                    <div class="m-banne-image"><img src="{{ Helpers::getsingleimage('section_1_15') }}"></div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!-- End Hero Content -->
                </div>
            </section>
            <!-- End Slide Item -->
        </div>
        <!-- End Fullwidth Slider -->

        <!-- Spread awareness Section -->
        <section class="small-section bg-gray-lighter">
            <div class="container-1400 relative">
                
                <div class="row d-flex justify-content-center text-center mb-60">
                    <div class="col-md-8">
                        <h2 class="section-title font-alt align-center mb-30 mb-sm-40 wow fadeInDown" data-wow-delay="0.1s">
                            {!! Helpers::getcontent('section_2_16') !!}
                        </h2>
                    </div>
                </div>

                <div class="row d-flex align-items-center">
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="mb-20"><img src="{{ Helpers::getsingleimage('section_2_18') }}"></div>
                            <div class="hs-line-3">{!! Helpers::getcontent('section_2_19') !!}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center"><img src="{{ Helpers::getsingleimage('section_2_17') }}"></div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="mb-20"><img src="{{ Helpers::getsingleimage('section_2_20') }}"></div>
                            <div class="hs-line-3">{!! Helpers::getcontent('section_2_21') !!}</div>
                        </div>
                    </div>
                </div>

                <div class="row d-flex justify-content-center mt-60">
                    <div class="col-md-6">
                        <div class="text-center">
                            <div class="mb-20"><img src="{{ Helpers::getsingleimage('section_2_22') }}"></div>
                            <div class="hs-line-3">{!! Helpers::getcontent('section_2_23') !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Spread awareness Section -->
        
        <!-- Citizens with ease Section -->
        <section class="small-section bg-scroll" data-background="{{ asset('frontend/images/section-bg-02.jpg') }}">
            <div class="container-1400 relative">
                
                <div class="row d-flex justify-content-center text-center mt-60">
                    <div class="col-md-7">
                        <h2 class="section-title white align-center mb-30 mb-sm-40 wow fadeInDown" data-wow-delay="0.1s">
                            {!! Helpers::getcontent('section_3_24') !!}
                        </h2>
                    </div>
                </div>
                
                <div class="text-center">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-7">
                            <img src="{!! Helpers::getsingleimage('section_3_25') !!}" class="img-fluid pull-image">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Citizens with ease Section -->

        <!--Download your shareable-->
        <section class="page-section pt-30 bg-scroll bg-pos-top-right" data-background="{{ asset('frontend/images/section-bg-03.jpg') }}">
            <div class="container-1400 relative">

                <div class="row d-flex justify-content-center text-center mt-60">
                    <div class="col-md-7">
                        <h2 class="section-title align-center mb-30 mb-sm-40 wow fadeInDown" data-wow-delay="0.1s">
                            {!! Helpers::getcontent('section_4_26') !!}
                        </h2>
                    </div>
                </div>

                <div class="row d-flex justify-content-center">
                    <div class="col-md-6">
                        <div class="certificate-container">
                            <div class="mb-20"><img src="{!! Helpers::getsingleimage('section_4_27') !!}"></div>
                            <div class="title">
                                {!! Helpers::getcontent('section_4_28') !!}
                            </div>
                            <div class="downloadable">
                                <a href="{{ url('/modules') }}" class="btn btn-mod btn-red btn-circle btn-medium">Get Your Certificate</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Download your shareable -->
        @if(count($faqs) > 0)
            <!--Frequently Asked questions Section-->
            <section class="small-section bg-gray-lighter pt-0">
                <div class="container-1400 relative">

                    <div class="row d-flex justify-content-center text-center mt-60">
                        <div class="col-md-7">
                            <h2 class="section-title align-center mb-60 mb-sm-40 wow fadeInDown" data-wow-delay="0.1s">
                                Frequently Asked questions
                            </h2>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center">
                        <div class="col-md-6">
                            <!-- Toggle -->
                            <dl class="toggle">
                                <?php $i = 0; ?>
                                @foreach($faqs as $faq)
                                    <dt>
                                        <a href="">{{++$i}}. {!! $faq->question !!}</a>
                                    </dt>
                                    <dd>
                                        {!! $faq->answer !!}
                                    </dd>
                                @endforeach
                            </dl>
                            <!-- End Toggle -->
                        </div>
                    </div>
                </div>
            </section>
            <!--End Frequently Asked questions Section-->
        @endif

        <!--Learn anywhere Anytime Section-->
        <section class="small-section bg-gray-lighter pt-0">
            <div class="container-1400 relative">

                <div class="row d-flex justify-content-center text-center mt-20">
                    <div class="col-md-7">
                        <h2 class="section-title align-center mb-10 mb-sm-40 wow fadeInDown" data-wow-delay="0.1s">
                            {!! Helpers::getcontent('section_5_29') !!}
                        </h2>
                        <div class="subtitle mb-30">{!! Helpers::getcontent('section_5_30') !!}</div>
                    </div>
                </div>

                <div class="d-flex justify-content-center mb-30">
                    <div class="me-2">
                        <a href="javascript:;"><img src="{{ asset('frontend/images/google-play.png') }}"></a>
                    </div>
                    <div>
                        <a href="javascript:;"><img src="{{ asset('frontend/images/apple-store.png') }}"></a>
                    </div>
                </div>

                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <img src="{!! Helpers::getsingleimage('section_5_31') !!}">
                    </div>
                </div>
            </div>
        </section>
        <!--End Learn anywhere Anytime Section-->

        @if(count($blogs) > 0)
            <!--Our blog Section-->
            <section class="small-section bg-gray-lighter pt-0">
                <div class="container relative">

                    <div class="row d-flex justify-content-center text-center mt-20">
                        <div class="col-md-7">
                            <h2 class="section-title align-center mb-60 mb-sm-40 wow fadeInDown" data-wow-delay="0.1s">
                                Our blog
                            </h2>
                        </div>
                    </div>


                    <div class="item-carousel owl-carousel">
                        @foreach($blogs as $blog)
                            <!--Repeat Post-->
                            <div class="blogPost">
                                <div class="post-prev-img">
                                    <a href="javascript:;"><img src="{{ Media::geturl($blog->feature_image) }}" alt="" /></a>
                                </div>
                                <div class="post-prev-title mb-10 font-alt">
                                    {!! $blog->title !!}
                                </div>
                                <div class="post-prev-text">
                                    {!! substr($blog->description, 0, 100) !!}...
                                </div>
                                <div class="post-prev-info">
                                    {!! date('D F d Y', strtotime($blog->date)) !!}
                                </div>
                                <div class="mt-20">
                                    <a href="javascript:;" class="btn btn-mod btn-red btn-circle btn-medium">Read more</a>
                                </div>
                                
                            </div>
                        <!--End Repeat Post-->
                        @endforeach
                    </div>

                    <div class="more-blogs">
                        <a href="{{ url('/blog') }}">View All</a>
                    </div>

                </div>
            </section>
            <!--End Our blog Section-->
        @endif

    </main>
@endsection

@section('navigation')
    @include('frontend.navigation')
@endsection

@section('footer')
    @include('frontend.footer')
@endsection
     