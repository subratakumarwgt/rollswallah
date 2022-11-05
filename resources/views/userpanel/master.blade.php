<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="All Is Well is solution for all of your medical queries including checkup, appointments, diagnosis medicine and non medical supliments at one roof">
    <meta name="keywords" content="All Is Well is solution for all of your medical queries including checkup, appointments, diagnosis medicine and non medical supliments at one roof">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{asset('/assets/images/favico.ico')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('/assets/images/favico.ico')}}" type="image/x-icon">
    <title>Rolls Wallah | Have some rolls... </title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    @include('userpanel.css')

    @yield('style')
    <style>
    .error{
       margin:1px;
       color:red;     
    }
</style>

  </head>
  <body @if(Route::current()->getName() == 'index') onload="startTime()" @endif>
    @if(Route::current()->getName() == 'user-dashboard') 
      <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
          <defs></defs>
          <filter id="goo">
            <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
            <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"> </fecolormatrix>
          </filter>
        </svg>
      </div>
     @endif
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
      @include('userpanel.header')
      <!-- Page Header Ends  -->
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        @include('userpanel.sidebar')
        <!-- Page Sidebar Ends-->
        <div class="page-body p-0">
        <!-- <div class="container-fluid">        
            <div class="page-title">
              <div class="row p-2">
                <div class="col-6">
                  @yield('breadcrumb-title')
                </div>
                <div class="col-6">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('/') }}"> <i data-feather="home"></i></a></li>
                    @yield('breadcrumb-items')
                  </ol>
                </div>
              </div>
            </div>
          </div> -->
        <!-- <div class="container-fluid">         -->
         @yield('banner')
          <!-- </div> -->

          <!-- Container-fluid starts-->
          <div class="row justify-content-center">
            <div class="col-md-11">
            @if (session('message'))
                        <div class="alert alert-info" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
         
            </div>
          </div>
          
          @yield('content')
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        @include('userpanel.footer') 
        
      </div>
    </div>
    <!-- latest jquery-->
    @include('userpanel.script')  
  
  </body>
</html>