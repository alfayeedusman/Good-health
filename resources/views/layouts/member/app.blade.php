<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="GOODHEALTH">
    <meta name="author" content="Ariel Espiritu">
	<meta name="_token" content="{{ csrf_token() }}">
	<meta property="og:url"                content="<?php 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>" />
	<meta property="og:type"               content="BUSINESS" />
	<meta property="og:title"              content="GOODHEALTH" />
	<meta property="og:description"        content="GOODHEALTH" />
	<meta property="og:image"              content="{{ asset('assets/logo.png') }}" />
    <title>@yield('title')</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" id="bootstrap-css">
	<link href="{{ asset('assets/ass/css/paper-dashboard.css?v=2.0.0') }}" rel="stylesheet" />

	@yield('style')
	<style>
	.flat{
		border-radius:0px;
	}
	</style>
</head>

<body >
	
	<div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
      <div class="logo">
    <center>
        <a href="/" class="simple-text logo-normal">
         <img src="{{ URL::asset('assets/logo.png') }}" alt="logo images" class="img-responsive hidden-xs hidden-sm" style="height:200px; margin-bottom:10px;">
        </a>
    </center>
      </div>

      <div class="sidebar-wrapper" style="background: #208000;">
        <ul class="nav">
          <li >
            <a href="/dashboard">
              <p  style="color: white;">Dashboard</p>
            </a>
          </li>
          <li>
            <a href="/accounts">
              <p style="color: white;">Accounts</p>
            </a>
          </li>
          <li>
            <a href="/profile">
              <p style="color: white;">Profile</p>
            </a>
          </li>
		   <li>
            <a href="/genealogy">
              <p style="color: white;">Genealogy</p>
            </a>
          </li>
		  <li>
            <a href="/unilevel">
              <p style="color: white;">Unilevel</p>
            </a>
          </li>
          <li>
            <a href="/encashments">
              <p style="color: white;">Encashments</p>
            </a>
          </li>
           <li>
            <a href="/encashments/gc">
              <p style="color: white;">GC Withdrawal</p>
            </a>
          </li>
          <li>
            <a href="/logout">
              <p style="color: white;">Logout</p>
            </a>
          </li>

        </ul>
        
        <br><br><br><br><br><br>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top " style="background:#134d00; border-bottom:5px solid black;">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="javascript::void()"><p style="font-size:16px;"> <img src="{{ URL::asset('assets/logo.png') }}" alt="logo images" class="img-responsive" style="height:60px; "> <strong>GOODHEALTH MEMBER PANEL</strong></p></a>
          </div>
          
        </div>
      </nav>
      <!-- End Navbar -->
      <!-- <div class="panel-header panel-header-lg">

  <canvas id="bigDashboardChart"></canvas>


</div> -->
      <div class="content">
        <br>
	     	@yield('content')
      </div>
	  
  
    </div>
  </div>
	
	
	
	
	
	
	
	
	
	


   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
   <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
	

	  <script src="{{ asset('assets/ass/js/core/popper.min.js') }}"></script>
	  <script src="{{ asset('assets/ass/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
	  <script src="{{ asset('assets/ass/js/plugins/chartjs.min.js') }}"></script>
	  <script src="{{ asset('assets/ass/js/plugins/bootstrap-notify.js') }}"></script>
	  <script src="{{ asset('assets/ass/js/paper-dashboard.min.js?v=2.0.0') }}" type="text/javascript"></script>

	
	
	<script>
	$.ajaxSetup({
		headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
	});	
	function myFunction() {
	  var copyText = document.getElementById("myInputLink");
	  copyText.select();
	  document.execCommand("copy");
	  alert("Copied the text: " + copyText.value);
	}

	  
	</script>
	@yield('script')
</body>

</html>
<!-- end document-->
