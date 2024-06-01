@extends('frontend.master')
@section('maincontent') 
    <main id="main">
        <section class="small-section">
            <div class="container relative">
                <div class="row mb-40">
                    <div class="col-md-8">
                        <div class="mod-breadcrumbs">
                            <a href="{{ url('/') }}">Home</a>&nbsp;<i class="las la-angle-right"></i>&nbsp;<a href="{{ url('modules') }}">Modules</a>&nbsp;<i class="las la-angle-right"></i>&nbsp;<span>Intersectionality</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="category-title mb-10">Wellbeing</div>
                        <h2 class="section-title font-alt align-left mb-30 mb-sm-10 wow fadeInDown" data-wow-delay="0.1s">
                            Intersectionality
                        </h2>

                        <div class="section-text">
                            Intersectionality is an analytical framework for understanding how individuals' various social and political identities result in unique combinations of discrimination and privilege. Intersectionality identifies multiple factors of advantages and disadvantages. These factors include gender, caste, sex, race, ethnicity, class, sexuality, religion, disability, weight, and physical appcategory-titleearance. These intersecting and overlapping social identities may be both empowering and oppressing.
                        </div>

                        <div class="timer mt-20 mb-20"><b>1hr 25 mins</b></div>
                        <div><a href="javascript:;" class="btn btn-mod btn-red btn-circle btn-medium">Start Now</a></div>


                        <div class="bg-card mt-30">
                            <!-- Nav Tabs -->                                
                            <ul class="nav nav-tabs tpl-tabs animate" role="tablist">
                                
                                <li class="nav-item">
                                    <a href="#contents" aria-controls="contents" class="nav-link active" data-bs-toggle="tab"  role="tab" aria-selected="true">Contents</a>
                                </li>
                                
                                <li class="nav-item">
                                    <a href="#bookmarks" aria-controls="bookmarks" class="nav-link" data-bs-toggle="tab" role="tab" aria-selected="false">Bookmarks</a>
                                </li>
                                
                                <li class="nav-item">
                                    <a href="#forums" aria-controls="forums" class="nav-link" data-bs-toggle="tab" role="tab" aria-selected="false">Forum</a>
                                </li>
                                
                            </ul>                                
                            <!-- End Nav Tabs -->
                            
                            <!-- Tab panes -->
                            <div class="tab-content tpl-tabs-cont section-text">
                                
                                <div class="tab-pane fade show active" id="contents" role="tabpanel">
                                    <div class="video-list">
                                        <ul>
                                            <li>
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
                                
                                <div class="tab-pane fade" id="bookmarks" role="tabpanel">
                                    Nam porta elementum tortor, eget tempor orci ullamcorper eget. Aliquam fermentum sem non vulputate dapibus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla at porttitor massa.
                                    Aliquam tortor leo, pharetra non congue sit amet pharetra non congue sit amet, bibendum sit amet enim.
                                </div>
                                
                                <div class="tab-pane fade" id="forums" role="tabpanel">
                                    Pellentesque sed vehicula velit, vitae vulputate velit. Morbi nec porta augue, et dignissim enim. Vivamusere suscipit, lorem vitae rhoncus pharetra, erat nisl scelerisque magna, ut mollis dui eros eget libero. Vivamus ut ornare tellus.
                                    Aliquam tortor leo, pharetra pharetra non congue sit amet non congue sit amet, bibendum sit amet enim.
                                </div>
                                
                            </div>
                            <!-- End Tab panes -->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="image-round"><img src="{{ asset('frontend/images/intersectionality_01.jpg') }}"></div>

                        <div class="bg-card mt-30">
                            <h4 class="mb-10"><b>Stats & Properties</b></h4>

                            <table class="table">
                                <tr>
                                    <th>Total Duration</th>
                                    <td>02 hrs, 56 min’s</td>
                                </tr>
                                <tr>
                                    <th>Smallest Chapter</th>
                                    <td>30 mins, 20sec’s</td>
                                </tr>
                                <tr>
                                    <th>Largest Chapter</th>
                                    <td>1 hr, 20 min’s</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection