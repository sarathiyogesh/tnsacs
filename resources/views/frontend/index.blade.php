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
                                        Virtual outreach platform
                                    </div>

                                    <div class="banner-desc">
                                        Get to learn things which are often<br>not discussed.
                                    </div>
                                    
                                    <div class="local-scroll mt-30">
                                        <a href="{{ url('signup') }}" class="me-3 btn btn-mod btn-red btn-circle btn-medium shadow">Sign up</a>
                                        <a href="{{ url('signin') }}" class="btn btn-mod btn-border btn-circle btn-medium shadow">Login</a>
                                    </div>
                                </div>

                                <div class="col-12 col-md-5 pt-xs-10">
                                    <div class="m-banne-image"><img src="{{ asset('frontend/images/avatar.png') }}"></div>
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
                            Unite against AIDS: Spread awareness, end stigma, empower all.
                        </h2>
                    </div>
                </div>

                <div class="row d-flex align-items-center">
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="mb-20"><img src="{{ asset('frontend/images/icon-01.svg') }}"></div>
                            <div class="hs-line-3">Safer communities - transformation through engagement</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center"><img src="{{ asset('frontend/images/spread-awareness.png') }}"></div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="mb-20"><img src="{{ asset('frontend/images/icon-01.svg') }}"></div>
                            <div class="hs-line-3">Improve knowledge and response to violence against women and children</div>
                        </div>
                    </div>
                </div>

                <div class="row d-flex justify-content-center mt-60">
                    <div class="col-md-6">
                        <div class="text-center">
                            <div class="mb-20"><img src="{{ asset('frontend/images/icon-01.svg') }}"></div>
                            <div class="hs-line-3">Police Force - seasoning</div>
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
                            An all new platform designed to serve Citizens with ease
                        </h2>
                    </div>
                </div>
                
                <div class="text-center">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-7">
                            <img src="{{ asset('frontend/images/img-02.png') }}" class="img-fluid pull-image">
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
                            Download your shareable<br>Certificate
                        </h2>
                    </div>
                </div>

                <div class="row d-flex justify-content-center">
                    <div class="col-md-6">
                        <div class="certificate-container">
                            <div class="mb-20"><img src="{{ asset('frontend/images/certificate.jpg') }}"></div>
                            <div class="title">
                                Collect your downloadable certificates after completing each module.
                            </div>
                            <div class="downloadable">
                                <a href="javascript:;" class="btn btn-mod btn-red btn-circle btn-medium">Get Your Certificate</a>
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
                            Learn anywhere Anytime
                        </h2>
                        <div class="subtitle mb-30">Download now to start learning...</div>
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
                        <img src="{{ asset('frontend/images/img-03.png') }}">
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

                    <div class="row d-flex justify-content-between">
                        @foreach($blogs as $blog)
                            <!--Repeat Post-->
                            <div class="col-md-3">
                                <div class="blogPost">
                                    <a href="javascript:;">
                                        <div class="post-prev-img">
                                            <img src="{{ Media::geturl($blog->feature_image) }}" alt="" />
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
                                    </a>
                                </div>
                            </div>
                            <!--End Repeat Post-->
                        @endforeach
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
     