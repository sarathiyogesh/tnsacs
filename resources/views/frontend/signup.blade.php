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

                                        <h3 class="mb-20 font-alt strong text-center">Sign Up to your account</h3>

                                        <form class="form contact-form" action="{{ url('signup/post') }}" method="POST">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label class="font-alt">Full Name</label>
                                                <input type="text" name="fullname" id="fullname" class="input-md round form-control" placeholder="Enter full name" value="{{ old('fullname') }}">
                                                @if($errors->has("fullname"))
                                                    <span id="fullname-error" class="help-block">{!! $errors->first("fullname") !!}</span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label class="font-alt">Email Address</label>
                                                <input type="text" name="email" id="email" class="input-md round form-control" placeholder="Enter email address" value="{{ old('email') }}">
                                                @if($errors->has("email"))
                                                    <span id="email-error" class="help-block">{!! $errors->first("email") !!}</span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label class="font-alt">Password</label>
                                                <input type="password" name="password" id="password" class="input-md round form-control" placeholder="Enter Password">
                                                @if($errors->has("password"))
                                                    <span id="password-error" class="help-block">{!! $errors->first("password") !!}</span>
                                                @endif
                                            </div>

                                            <div>
                                                <button type="submit" class="btn btn-mod btn-red btn-circle btn-medium w-100">Signup</button>
                                            </div>

                                            <div class="mt-20 text-center">
                                                Already have an Account? <a href="{{ url('signin') }}" class="text-red">Login</a>
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