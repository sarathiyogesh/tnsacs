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
                            <a href="{{ url('/') }}">Home</a>&nbsp;<i class="las la-angle-right"></i>&nbsp;<span>Blog</span>
                        </div>
                    </div>
                </div>

                <div class="row d-flex justify-content-center text-center mt-20">
                    <div class="col-md-7">
                        <h2 class="section-title align-center mb-60 mb-sm-40 wow fadeInDown" data-wow-delay="0.1s">
                            Our blog
                        </h2>
                    </div>
                </div>


                <div class="row">

                    @foreach($blogs as $blog)
                            <!--Repeat Post-->
                            <div class="col-md-4">
                            <div class="blogPost">
                                <div class="post-prev-img">
                                    <a href="javascript:;"><img src="{{ Media::geturl($blog->feature_image) }}" alt="" /></a>
                                </div>
                                <div class="post-prev-title mb-10 font-alt">
                                    {!! $blog->title !!}
                                </div>
                                <div class="post-prev-text">
                                    {!! substr($blog->short_description, 0, 100) !!}...
                                </div>
                                <div class="post-prev-info">
                                    {!! date('D F d Y', strtotime($blog->date)) !!}
                                </div>
                                <div class="mt-20">
                                    <a href="/blog/{{$blog->slug}}" class="btn btn-mod btn-red btn-circle btn-medium">Read more</a>
                                </div>
                            </div>
                        </div>
                        <!--End Repeat Post-->
                        @endforeach

                  <!--   <div class="col-md-4">
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
                    </div> -->
                </div>

            </div>
        </section>
    </main>
@endsection

@section('navigation')
    @include('frontend.navigation')
@endsection