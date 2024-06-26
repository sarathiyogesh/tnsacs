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
                            <a href="{{ url('/') }}">Home</a>&nbsp;<i class="las la-angle-right"></i>&nbsp;<a href="{{ url('/blog')}}">Blog</a>&nbsp;<i class="las la-angle-right"></i>&nbsp;<span> {!! $blog->title !!}</span>
                        </div>
                    </div>
                </div>

                <div class="row mb-40">
                    <div class="col-md-5">
                        <img src="{{ Media::geturl($blog->feature_image) }}" alt="">
                    </div>
                    <div class="col-md-7">

                        <div class="post-prev-info">
                            {!! date('D F d Y', strtotime($blog->date)) !!}
                        </div>
                        <div class="post-prev-title mb-10 font-alt">
                           {!! $blog->title !!}
                        </div>

                        <div class="post-prev-text">
                           {!! $blog->short_description !!}
                        </div>

                        @if($blog->post_external_link)
                        <div class="post-cta-link mt-20">
                            <a href="{{$blog->post_external_link}}" target="_blank" class="btn btn-mod btn-red btn-circle btn-small">View Details</a>
                        </div>
                        @endif
                    </div>
                </div>

                @if(!$blog->post_external_link)
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-text">
                            {!! $blog->description !!}
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </section>
        @if(count($sugg_blogs) != 0)
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
                    @foreach($sugg_blogs as $blog)
                        <!--Repeat Post-->
                        <div class="col-md-4">
                        <div class="blogPost">
                            <div class="post-prev-img">
                                <a href="/blog/{{$blog->slug}}"><img src="{{ Media::geturl($blog->feature_image) }}" alt="" /></a>
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
                </div>

            </div>
        </section>
        @endif
    </main>
@endsection

@section('navigation')
    @include('frontend.navigation')
@endsection