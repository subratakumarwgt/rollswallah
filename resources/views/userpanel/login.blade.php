@extends('userpanel.authentication.master')
@section('title', 'All is Well | Login')

@section('css')
<style>

</style>
@endsection

@section('style')
@endsection

@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-7 order-1"><img class="bg-img-cover bg-center" src="{{asset('assets/images/login/1.png')}}" alt="looginpage"></div>
      <div class="col-xl-5 p-0">
         <div class="login-card">
            <div>
               <div><a class="logo text-start" href="{{ route('auth-login') }}"><img class="img-fluid for-light" width="500px" src="{{asset('assets/images/logo/logo.png')}}" alt="looginpage"><img class="img-fluid for-dark" src="{{asset('assets/images/logo/logo_dark.png')}}" alt="looginpage"></a></div>
               <div class="login-main">
                  <form class="theme-form needs-validation" novalidate="" method="post" action="{{ route('auth-login') }}">
                     @csrf
                     <h4>Sign in to account</h4>
                     <p>Enter your Contact & Password to login</p>
                     @if(Session::has('error'))
                                    <div class="row p-2 justify-content-center">
                                        <div class="alert-danger col-md-6 alert">{{Session::get('error')}}</div>
                                    </div>
                                    @endif
                     <div class="form-group">
                        <label class="col-form-label">Contact No</label>
                        <input id="contact" type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}" required autocomplete="contact" autofocus placeholder="Enter Your Mobile Number">

                        @error('contact')
                        <span class="invalid-feedback text-danger" role="alert">
                           <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                     </div>
                     <div class="form-group">
                        <label class="col-form-label">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter Your Password">

                        @error('password')
                        <span class="invalid-feedback text-danger" role="alert">
                           <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <div class="show-hide"><span class="show"> </span></div>
                     </div>
                     <div class="form-group mb-0">
                        <div class="checkbox p-0">
                           <input id="checkbox1" type="checkbox">
                           <label class="text-muted" for="checkbox1">Remember password</label>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">Sign in</button>
                     </div>
                     <!-- <h6 class="text-muted mt-4 or">Or Sign in with</h6>
                     <div class="social mt-4">
                        <div class="btn-showcase"><a class="btn btn-light" href="https://www.linkedin.com/login" target="_blank"><i class="txt-linkedin" data-feather="linkedin"></i> LinkedIn </a><a class="btn btn-light" href="https://twitter.com/login?lang=en" target="_blank"><i class="txt-twitter" data-feather="twitter"></i>twitter</a><a class="btn btn-light" href="https://www.facebook.com/" target="_blank"><i class="txt-fb" data-feather="facebook"></i>facebook</a></div>
                     </div> -->
                     <p class="mt-4 mb-0">Don't have account?<a class="ms-2" href="{{ route('sign-up') }}">Create Account</a></p>
                     <script>
                        (function() {
                           'use strict';
                           window.addEventListener('load', function() {
                              // Fetch all the forms we want to apply custom Bootstrap validation styles to
                              var forms = document.getElementsByClassName('needs-validation');
                              // Loop over them and prevent submission
                              var validation = Array.prototype.filter.call(forms, function(form) {
                                 form.addEventListener('submit', function(event) {
                                    if (form.checkValidity() === false) {
                                       event.preventDefault();
                                       event.stopPropagation();
                                    }
                                    form.classList.add('was-validated');
                                 }, false);
                              });
                           }, false);
                        })();
                     </script>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('script')
@endsection