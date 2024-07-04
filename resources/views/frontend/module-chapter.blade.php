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

                <input type="hidden" name="chapter_id" id="chapter_id" value="{{encrypt($chapter->id)}}">
                <input type="hidden" name="module_id" id="module_id" value="{{encrypt($module->id)}}">

                <div class="row mb-50">
                    <div class="col-md-12">
                        @if($chapter->video_url)
                        <video
                    id="my-video"
                    class="video-js"
                    controls
                    width="1200"
                    height="600"
                    data-setup="{}"
                  >
                    <source src="{{$chapter->video_url}}" type="video/mp4" />
                  </video>
                  @endif

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="category-title mb-10">{{$module->category}} <i class="las la-angle-right"></i> {{$module->title}}</div>
                        <h2 class="hs-line-4 font-alt align-left mb-30 mb-sm-10 wow fadeInDown" data-wow-delay="0.1s">
                            {{$chapter->title}}
                        </h2>

                        @if($chapter->description)
                            <div class="section-text">
                              {!! $chapter->description !!}
                            </div>
                        @else
                            <div class="section-text">
                              {!! $module->description !!}
                            </div>
                        @endif
                        

                        <div class="mt-30 mb-xs-20"><a href="{{ url('modules') }}" class="btn btn-mod btn-red btn-circle btn-medium">Back to Modules</a></div>
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

@section('scripts')
    <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
    <script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>

    <script type="text/javascript">
         @if($chapter->video_url)
         var myPlayer = videojs('my-video');
         myPlayer.options({ enableSmoothSeeking: true, disablePictureInPicture: true });
        var interval;
        interval = setInterval(function(){
            var totalTime = myPlayer.duration();
            var currentTime = myPlayer.currentTime();
            var remainTime = totalTime - currentTime;
            if(remainTime <= 25){
                clearInterval(interval);
                updatechapterhistory();

            }
        }, 2000);

        function updatechapterhistory(totalTime){
            var module_id = $('#module_id').val();
            var chapter_id = $('#chapter_id').val();
            $.ajax({
               url:"{{ url('module/chapter/history/update') }}",
               data: { module_id: module_id, chapter_id: chapter_id,duration: totalTime  },
               type:"POST",
               headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),},
                success: function(res){
                   
                },error: function(e){
                    
                }
           });
        }
        @endif
    </script>
@endsection