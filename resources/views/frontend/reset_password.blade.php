@extends('frontend.master')
@section('maincontent') 
    <main id="main">
        <!-- Fullwidth Slider -->
        <div class="home-section fullwidth-slider" id="home">
            <!-- Slide Item -->
            <section class="home-section bg-scroll" data-background="{{ asset('frontend/images/login-bg.jpg') }}">
                <div class="js-height-full container-1400">
                    <!-- Hero Content -->
                    <div class="home-content">
                        <div class="home-text">
                            <div class="row d-flex justify-content-center">  
                                <div class="col-md-4 pt-xs-30">
                                    <div class="login-container">
                                        <div class="mb-20 text-center"><img src="{{ asset('frontend/images/vop.png') }}"></div>

                                        <h3 class="mb-20 font-alt strong text-center">Reset Password</h3>

                                        @if(Session::has('success'))
                                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                                        @endif

                                        @if(Session::has('error'))
                                            <div class="alert alert-danger">{{ Session::get('error') }}</div>
                                        @endif

                                        <form class="form contact-form" action="{{ url('/resetpassword/post') }}" method="POST">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label class="font-alt">Password</label>
                                                <input type="password" name="password" id="password" class="input-md round form-control" placeholder="Enter password">
                                                @if($errors->has("password"))
                                                    <span id="password-error" class="help-block">{!! $errors->first("password") !!}</span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label class="font-alt">Confirm Password</label>
                                                <input type="password" name="confirm_password" id="confirm_password" class="input-md round form-control" placeholder="Enter confirm password">
                                                @if($errors->has("confirm_password"))
                                                    <span id="confirm_password-error" class="help-block">{!! $errors->first("confirm_password") !!}</span>
                                                @endif
                                            </div>

                                            <input type="hidden" name="verify_token" id="verify_token" value="{{$user->verify_token}}">

                                            <div>
                                                <button type="submit" onclick="$(this).text('Processing...')" class="btn btn-mod btn-red btn-circle btn-medium w-100">Submit</button>
                                            </div>
                                        </form>
                                    </div>
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
    </main>
@endsection