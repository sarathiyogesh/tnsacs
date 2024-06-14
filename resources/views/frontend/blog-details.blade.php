<?php 
    use App\Models\Media;
?>
@extends('frontend.master')
@section('maincontent') 
    <main id="main">
        <section class="small-section pt-10 blogListing">
            <div class="container relative">
                <div class="row mb-40">
                    <div class="col-md-8">
                        <div class="mod-breadcrumbs">
                            <a href="{{ url('/') }}">Home</a>&nbsp;<i class="las la-angle-right"></i>&nbsp;<a href="{{ url('/blog')}}">Blog</a>&nbsp;<i class="las la-angle-right"></i>&nbsp;<span>Ending HIV</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-40">
                    <div class="col-md-5">
                        <img src="http://tnsacs.test/backend/uploads/media/blog_01.jpg" alt="">
                    </div>
                    <div class="col-md-7">

                        <div class="post-prev-info">
                            Thu June 06 2024
                        </div>
                        <div class="post-prev-title mb-10 font-alt">
                            Ending HIV
                        </div>

                        <div class="post-prev-text">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="section-text">
                            <p>Intersectionality is an analytical framework for understanding how individuals' various social and political identities result in unique combinations of discrimination and privilege. Intersectionality identifies multiple factors of advantages and disadvantages. These factors include gender, caste, sex, race, ethnicity, class, sexuality, religion, disability, weight, and physical appearance. These intersecting and overlapping social identities may be both empowering and oppressing.</p>

                            <p>Intersectionality is an analytical framework for understanding how individuals' various social and political identities result in unique combinations of discrimination and privilege. Intersectionality identifies multiple factors of advantages and disadvantages. These factors include gender, caste, sex, race, ethnicity, class, sexuality, religion, disability, weight, and physical appearance. These intersecting and overlapping social identities may be both empowering and oppressing. Intersectionality is an analytical framework for understanding how individuals' various social and political identities result in unique combinations of discrimination and privilege. Intersectionality identifies multiple factors of advantages and disadvantages. These factors include gender, caste, sex, race, ethnicity, class, sexuality, religion, disability, weight, and physical appearance. These intersecting and overlapping social identities may be both empowering and oppressing. Intersectionality is an analytical framework for understanding how individuals' various social and political identities result in unique combinations of discrimination and privilege. Intersectionality identifies multiple factors of advantages and disadvantages. These factors include gender, caste, sex, race, ethnicity, class, sexuality, religion, disability, weight, and physical appearance. These intersecting and overlapping social identities may be both empowering and oppressing.</p>

                            <p>Intersectionality is an analytical framework for understanding how individuals' various social and political identities result in unique combinations of discrimination and privilege. Intersectionality identifies multiple factors of advantages and disadvantages. These factors include gender, caste, sex, race, ethnicity, class, sexuality, religion, disability, weight, and physical appearance. These intersecting and overlapping social identities may be both empowering and oppressing.</p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section class="small-section pt-10 blogListing">
            <div class="container relative">

                <div class="row d-flex justify-content-center text-center mt-20">
                    <div class="col-md-7">
                        <h2 class="section-title align-center mb-60 mb-sm-40 wow fadeInDown" data-wow-delay="0.1s">
                            Suggested blogs
                        </h2>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <div class="blogPost">
                            <div class="post-prev-img">
                                <a href="javascript:;"><img src="http://tnsacs.test/backend/uploads/media/blog_01.jpg" alt=""></a>
                            </div>
                            <div class="post-prev-title mb-10 font-alt">
                                Ending HIV
                            </div>
                            <div class="post-prev-text">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been t...</p>
                            </div>
                            <div class="post-prev-info">
                                Thu June 06 2024
                            </div>

                            <div class="mt-20">
                                <a href="javascript:;" class="btn btn-mod btn-red btn-circle btn-medium" tabindex="0">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="blogPost">
                            <div class="post-prev-img">
                                <a href="javascript:;"><img src="http://tnsacs.test/backend/uploads/media/blog_02.jpg" alt=""></a>
                            </div>
                            <div class="post-prev-title mb-10 font-alt">
                                Ending HIV
                            </div>
                            <div class="post-prev-text">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been t...</p>
                            </div>
                            <div class="post-prev-info">
                                Thu June 06 2024
                            </div>

                            <div class="mt-20">
                                <a href="javascript:;" class="btn btn-mod btn-red btn-circle btn-medium" tabindex="0">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="blogPost">
                            <div class="post-prev-img">
                                <a href="javascript:;"><img src="http://tnsacs.test/backend/uploads/media/blog_03.jpg" alt=""></a>
                            </div>
                            <div class="post-prev-title mb-10 font-alt">
                                Ending HIV
                            </div>
                            <div class="post-prev-text">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been t...</p>
                            </div>
                            <div class="post-prev-info">
                                Thu June 06 2024
                            </div>

                            <div class="mt-20">
                                <a href="javascript:;" class="btn btn-mod btn-red btn-circle btn-medium" tabindex="0">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>
@endsection

@section('navigation')
    @include('frontend.navigation')
@endsection