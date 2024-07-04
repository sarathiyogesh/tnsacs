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

                                        <h3 class="mb-20 font-alt strong text-center">Forgot Password</h3>

                                        @if(Session::has('success'))
                                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                                        @endif

                                        @if(Session::has('error'))
                                            <div class="alert alert-danger">{{ Session::get('error') }}</div>
                                        @endif

                                        <form class="form contact-form" action="{{ url('/forgotpassword/post') }}" method="POST">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label class="font-alt">Email Address</label>
                                                <input type="text" name="email" id="email" class="input-md round form-control" placeholder="Enter email address">
                                                @if($errors->has("email"))
                                                    <span id="email-error" class="help-block">{!! $errors->first("email") !!}</span>
                                                @endif
                                            </div>

                                            <div>
                                                <button type="submit" onclick="$(this).text('Processing...')" class="btn btn-mod btn-red btn-circle btn-medium w-100">Submit</button>
                                            </div>

                                            <div class="mt-20 text-center">
                                                Do you remember password? <a href="{{ url('signin') }}" class="text-red">Login</a>
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