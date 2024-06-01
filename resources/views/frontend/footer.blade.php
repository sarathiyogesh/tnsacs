<!-- Footer -->
<footer class="small-section bg-gray bg-scroll footer pb-60 bg-pos-top" data-background="{{ asset('frontend/images/footer-bg.jpg') }}">
    <div class="container">
        <div class="row d-flex align-items-end">
            <div class="col-md-4">
                <div class="widget">
                    <div class="widget-title">Address</div>
                    {{ Helpers::getcontent('footer_5') }}
                </div>
            </div>

            <div class="col-md-4">
                <div class="text-center">
                    <div class="mb-20"><img src="{{ Helpers::getsingleimage('footer_6') }}"></div>

                    <div class="widget-title">
                        {{ Helpers::getcontent('footer_7') }} 
                    </div>
                    <div class="white">{{ Helpers::getcontent('footer_8') }}</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="inner-left">
                    <div class="widget-title">Connect with us</div>
                    <div class="social-icons">
                        <ul>
                            <?php
                                $facebook = Helpers::getcontent('footer_9');
                                $instagram = Helpers::getcontent('footer_10');
                                $youtube = Helpers::getcontent('footer_11');
                                $twitter = Helpers::getcontent('footer_12');
                            ?>
                            @if($facebook)
                                <li><a href="{{ $facebook }}"><img src="{{ asset('frontend/images/facebook.svg') }}"></a></li>
                            @endif
                            @if($instagram)
                                <li><a href="{{ $instagram }}"><img src="{{ asset('frontend/images/instagram.svg') }}"></a></li>
                            @endif
                            @if($youtube)
                                <li><a href="{{ $youtube }}"><img src="{{ asset('frontend/images/youtube.svg') }}"></a></li>
                            @endif
                            @if($twitter)
                                <li><a href="{{ $twitter }}"><img src="{{ asset('frontend/images/twitter.svg') }}"></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
     </div>
     
     
     <!-- Top Link -->
     <div class="local-scroll">
         <a href="#top" class="link-to-top"><i class="fa fa-caret-up"></i></a>
     </div>
     <!-- End Top Link -->
     
</footer>
<!-- End Footer -->