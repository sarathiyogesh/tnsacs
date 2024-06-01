<?php 
    use App\Models\Modules;
    use App\Models\Modulechapter;
    use App\Models\Media;
?>
@extends('frontend.master')
@section('maincontent') 
    <main id="main">
        <section class="small-section">
            <div class="container relative">
                <div class="row mb-40">
                    <div class="col-md-8">
                        <div class="mod-breadcrumbs">
                            <a href="{{ url('/') }}">Home</a>&nbsp;<i class="las la-angle-right"></i>&nbsp;<a href="{{ url('modules') }}">Modules</a>&nbsp;<i class="las la-angle-right"></i>&nbsp;<a href="{{ url('module-details/'.$module->slug) }}">{{$module->title}}</a>&nbsp;<i class="las la-angle-right"></i>&nbsp;<span>{{$chapter->title}}</span>
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
                        <div class="category-title mb-10">{{$module->category}}</div>
                        <h2 class="section-title font-alt align-left mb-30 mb-sm-10 wow fadeInDown" data-wow-delay="0.1s">
                            {{$module->title}}
                        </h2>

                        <div class="section-text">
                          {!! $module->description !!}
                        </div>

                        <div class="mt-30"><a href="{{ url('modules') }}" class="btn btn-mod btn-red btn-circle btn-medium">Back to Modules</a></div>
                    </div>
                    <div class="col-md-6">
                        <div class="video-list">
                        <ul>
                            <?php 
                                $i = 1;
                            ?>
                            @foreach($chapters as $chap)
                            <li class="@if($chap->id == $chapter->id) active @endif">
                                <a href="{{ url('module-chapter/'.$module->slug.'/'.$chap->id) }}">
                                    <div>
                                        <div class="alt-service-item">
                                            <div class="alt-service-icon">
                                                <img src="{{ asset('frontend/images/play.svg') }}">
                                            </div>
                                            <h3 class="alt-services-title font-alt">{{$chap->title}}</h3>
                                            Chapter - {{$i}} <span class="px-3">{{Modules::gethourandmin($chap->duration)}}</span>
                                        </div>
                                    </div>

                                    <div>
                                        <img src="{{ asset('frontend/images/right-arrow.svg') }}">
                                    </div>
                                </a>
                            </li>
                            <?php 
                                $i++;
                            ?>
                            @endforeach
                    
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection