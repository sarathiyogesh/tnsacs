@extends('frontend.master')
@section('maincontent') 
    <main id="main">
        <section class="small-section">
            <div class="container relative">
                <div class="row mb-40">
                    <div class="col-md-8">
                        <div class="mod-breadcrumbs">
                            <a href="{{ url('/') }}">Home</a>&nbsp;<i class="las la-angle-right"></i>&nbsp;<a href="{{ url('modules') }}">Modules</a>&nbsp;<i class="las la-angle-right"></i>&nbsp;<a href="{{ url('module-details') }}">Intersectionality</a>&nbsp;<i class="las la-angle-right"></i>&nbsp;<span>Introduction</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-50">
                    <div class="col-md-12">
                        <img src="{{ asset('frontend/images/player-placeholder.png') }}" class="img-fluid">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="category-title mb-10">Wellbeing</div>
                        <h2 class="section-title font-alt align-left mb-30 mb-sm-10 wow fadeInDown" data-wow-delay="0.1s">
                            Intersectionality
                        </h2>

                        <div class="section-text">
                            Intersectionality is an analytical framework for understanding how individuals' various social and political identities result in unique combinations of discrimination and privilege. Intersectionality identifies multiple factors of advantages and disadvantages. These factors include gender, caste, sex, race, ethnicity, class, sexuality, religion, disability, weight, and physical appcategory-titleearance. These intersecting and overlapping social identities may be both empowering and oppressing.
                        </div>

                        <div class="mt-30"><a href="{{ url('modules') }}" class="btn btn-mod btn-red btn-circle btn-medium">Back to Modules</a></div>
                    </div>
                    <div class="col-md-6">
                        <div class="video-list">
                        <ul>
                            <li class="active">
                                <a href="javascript:;">
                                    <div>
                                        <div class="alt-service-item">
                                            <div class="alt-service-icon">
                                                <img src="{{ asset('frontend/images/play.svg') }}">
                                            </div>
                                            <h3 class="alt-services-title font-alt">Introduction</h3>
                                            Chapter - 1 <span class="px-3">20 mins, 26 secs</span>
                                        </div>
                                    </div>

                                    <div>
                                        <img src="{{ asset('frontend/images/right-arrow.svg') }}">
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:;">
                                    <div>
                                        <div class="alt-service-item">
                                            <div class="alt-service-icon">
                                                <img src="{{ asset('frontend/images/play.svg') }}">
                                            </div>
                                            <h3 class="alt-services-title font-alt">Embracing diversity</h3>
                                            Chapter - 2 <span class="px-3">20 mins, 26 secs</span>
                                        </div>
                                    </div>

                                    <div>
                                        <img src="{{ asset('frontend/images/right-arrow.svg') }}">
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:;">
                                    <div>
                                        <div class="alt-service-item">
                                            <div class="alt-service-icon">
                                                <img src="{{ asset('frontend/images/play.svg') }}">
                                            </div>
                                            <h3 class="alt-services-title font-alt">Advancing LGBTQA + Rights</h3>
                                            Chapter - 3 <span class="px-3">20 mins, 26 secs</span>
                                        </div>
                                    </div>

                                    <div>
                                        <img src="{{ asset('frontend/images/right-arrow.svg') }}">
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:;">
                                    <div>
                                        <div class="alt-service-item">
                                            <div class="alt-service-icon">
                                                <img src="{{ asset('frontend/images/play.svg') }}">
                                            </div>
                                            <h3 class="alt-services-title font-alt">Chapter 4 main heading</h3>
                                            Chapter - 4 <span class="px-3">20 mins, 26 secs</span>
                                        </div>
                                    </div>

                                    <div>
                                        <img src="{{ asset('frontend/images/right-arrow.svg') }}">
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:;">
                                    <div>
                                        <div class="alt-service-item">
                                            <div class="alt-service-icon">
                                                <img src="{{ asset('frontend/images/play.svg') }}">
                                            </div>
                                            <h3 class="alt-services-title font-alt">Chapter 5 main heading</h3>
                                            Chapter - 5 <span class="px-3">20 mins, 26 secs</span>
                                        </div>
                                    </div>

                                    <div>
                                        <img src="{{ asset('frontend/images/right-arrow.svg') }}">
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:;">
                                    <div>
                                        <div class="alt-service-item">
                                            <div class="alt-service-icon">
                                                <img src="{{ asset('frontend/images/play.svg') }}">
                                            </div>
                                            <h3 class="alt-services-title font-alt">Chapter 6 main headings</h3>
                                            Chapter - 6 <span class="px-3">20 mins, 26 secs</span>
                                        </div>
                                    </div>

                                    <div>
                                        <img src="{{ asset('frontend/images/right-arrow.svg') }}">
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection