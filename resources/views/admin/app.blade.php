<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<meta name="_token" content="{!! csrf_token() !!}"/>
<link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
<title>@yield('title')</title>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<link href="{{ asset('assets/member/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/member/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/member/plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
<!--<link href="{{ asset('assets/member/plugins/bower_components/morrisjs/morris.css') }}" rel="stylesheet">-->
<link href="{{ asset('assets/member/css/animate.css') }}" rel="stylesheet">
<link href="{{ asset('assets/member/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('assets/member/css/colors/blue-dark.css') }}" id="theme" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.bootstrap.min.css">
@yield('head')
<style>.fb-livechat,.fb-widget{display:none}.ctrlq.fb-button,.ctrlq.fb-close{position:fixed;right:24px;cursor:pointer}.ctrlq.fb-button{z-index:1;background:url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDEyOCAxMjgiIGhlaWdodD0iMTI4cHgiIGlkPSJMYXllcl8xIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAxMjggMTI4IiB3aWR0aD0iMTI4cHgiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxnPjxyZWN0IGZpbGw9IiMwMDg0RkYiIGhlaWdodD0iMTI4IiB3aWR0aD0iMTI4Ii8+PC9nPjxwYXRoIGQ9Ik02NCwxNy41MzFjLTI1LjQwNSwwLTQ2LDE5LjI1OS00Niw0My4wMTVjMCwxMy41MTUsNi42NjUsMjUuNTc0LDE3LjA4OSwzMy40NnYxNi40NjIgIGwxNS42OTgtOC43MDdjNC4xODYsMS4xNzEsOC42MjEsMS44LDEzLjIxMywxLjhjMjUuNDA1LDAsNDYtMTkuMjU4LDQ2LTQzLjAxNUMxMTAsMzYuNzksODkuNDA1LDE3LjUzMSw2NCwxNy41MzF6IE02OC44NDUsNzUuMjE0ICBMNTYuOTQ3LDYyLjg1NUwzNC4wMzUsNzUuNTI0bDI1LjEyLTI2LjY1N2wxMS44OTgsMTIuMzU5bDIyLjkxLTEyLjY3TDY4Ljg0NSw3NS4yMTR6IiBmaWxsPSIjRkZGRkZGIiBpZD0iQnViYmxlX1NoYXBlIi8+PC9zdmc+) center no-repeat #0084ff;width:60px;height:60px;text-align:center;bottom:24px;border:0;outline:0;border-radius:60px;-webkit-border-radius:60px;-moz-border-radius:60px;-ms-border-radius:60px;-o-border-radius:60px;box-shadow:0 1px 6px rgba(0,0,0,.06),0 2px 32px rgba(0,0,0,.16);-webkit-transition:box-shadow .2s ease;background-size:80%;transition:all .2s ease-in-out}.ctrlq.fb-button:focus,.ctrlq.fb-button:hover{transform:scale(1.1);box-shadow:0 2px 8px rgba(0,0,0,.09),0 4px 40px rgba(0,0,0,.24)}.fb-widget{background:#fff;z-index:2;position:fixed;width:360px;height:435px;overflow:hidden;opacity:0;bottom:0;right:24px;border-radius:6px;-o-border-radius:6px;-webkit-border-radius:6px;box-shadow:0 5px 40px rgba(0,0,0,.16);-webkit-box-shadow:0 5px 40px rgba(0,0,0,.16);-moz-box-shadow:0 5px 40px rgba(0,0,0,.16);-o-box-shadow:0 5px 40px rgba(0,0,0,.16)}.fb-credit{text-align:center;margin-top:8px}.fb-credit a{transition:none;color:#bec2c9;font-family:Helvetica,Arial,sans-serif;font-size:12px;text-decoration:none;border:0;font-weight:400}.ctrlq.fb-overlay{z-index:0;position:fixed;height:100vh;width:100vw;-webkit-transition:opacity .4s,visibility .4s;transition:opacity .4s,visibility .4s;top:0;left:0;background:rgba(0,0,0,.05);display:none}.ctrlq.fb-close{z-index:4;padding:0 6px;background:#365899;font-weight:700;font-size:11px;color:#fff;margin:8px;border-radius:3px}.ctrlq.fb-close::after{content:'x';font-family:sans-serif}</style>
<style>
.cards-row{padding-top:40px; padding-bottom:20px; background:#eee}
.thumbnail{padding:0; border-radius:0; border:none; box-shadow:0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12)}
.thumbnail>img{width:100%; display:block}
.thumbnail h3{font-size:26px}
.thumbnail h3,.card-description{margin:0; padding:8px 0; border-bottom:solid 1px #eee; text-align:justify}
.thumbnail p{padding-top:8px; font-size:20px}
.thumbnail .btn{border-radius:0; box-shadow:0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12); font-size:20px}
</style>
</head>

<body>
<div id="fb-root"></div>
<script>

</script>	
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header" style="background:#652a76;"> 
				<a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars fa-fw"></i> <span> <b>TAPDONATE</b></span></a>
                <div class="top-left-part"><a class="logo" href="/"><b class="hidden-xs hidden-sm">&nbsp;&nbsp;&nbsp;&nbsp;TAPANDWIN</b></a></div>
                <ul class="nav navbar-top-links navbar-right pull-right">
					
					<li>
						<a class="profile-pic" href="#"> <img src="{{ URL::asset(imagePathUser('assets/member/img/profile/'.encryptor( 'encrypt', Auth::user()->id ) )) }}" alt="user-img" width="36" height="36" class="img-circle"><b >{{Auth::user()->name}}</b> </a>
					</li>
					<li>
						<a href="{{ route('logout') }}"
							onclick="event.preventDefault();
									 document.getElementById('logout-form').submit();">
							<b><i class="fas fa-sign-out-alt"></i></b> 
						</a>

						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
					</li>
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation" style="background:#652a76;">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
                    <!--<li style="padding: 10px 0 0;">
                        <a href="{{ route('admin.dashboard') }}" class="waves-effect"><i class="fa fa-clock-o fa-fw" aria-hidden="true"></i><span class="hide-menu">Dashboard</span></a>
                    </li>-->
                    <li>
                        <a href="{{ route('admin.tap') }}" class="waves-effect"><i class="far fa-hand-point-up fa-fw"></i><span class="hide-menu">Tap List</span></a>
                    </li>
					<li>
                        <a href="{{ route('admin.tap.history') }}" class="waves-effect"><i class="far fa-clock fa-fw"></i><span class="hide-menu">Tap History</span></a>
                    </li>
					<!--<li>
                        <a href="" class="waves-effect"><i class="fa fa-times-circle fa-fw" aria-hidden="true"></i><span class="hide-menu">Survey</span></a>
                    </li>
					<li>
                        <a href="/invites" class="waves-effect"><i class="fa fa-times-circle fa-fw" aria-hidden="true"></i><span class="hide-menu">Free Online Shop</span></a>
                    </li>-->
				</ul>	
    
            </div>
        </div>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
			
			
				<!--<div class="fb-livechat">
					<div class="ctrlq fb-overlay"></div>
						<div class="fb-widget">
							<div class="ctrlq fb-close"></div>
							<div class="fb-page" data-href="https://web.facebook.com/filipinoiseOfficial/" data-tabs="messages" data-width="360" data-height="400" data-small-header="true" data-hide-cover="true" data-show-facepile="false">
								<blockquote cite="https://web.facebook.com/filipinoiseOfficial/" class="fb-xfbml-parse-ignore"> </blockquote>
							</div>
							<div class="fb-credit"> 
								<a href="/" target="_blank">Facebook Chat Widget</a>
							</div>
							<div id="fb-root"></div>
						</div>
					<a href="/" title="Send us a message on Facebook" class="ctrlq fb-button"></a> 
				</div>-->
				
		
                @yield('content')
				<div id="modaldetails" class="modal fade " role="dialog">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-body">
								<div class="row">	
									<div class="col-md-12" id="loaddiv">	
									</div> 	
								</div> 
							</div>
						</div>
					</div>
				</div>
            </div>
			
		
	
           <!-- /.container-fluid -->
            <footer class="footer text-center"> </footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
	<script src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script>$(document).ready(function(){var t={delay:125,overlay:$(".fb-overlay"),widget:$(".fb-widget"),button:$(".fb-button")};setTimeout(function(){$("div.fb-livechat").fadeIn()},8*t.delay),$(".ctrlq").on("click",function(e){e.preventDefault(),t.overlay.is(":visible")?(t.overlay.fadeOut(t.delay),t.widget.stop().animate({bottom:0,opacity:0},2*t.delay,function(){$(this).hide("slow"),t.button.show()})):t.button.fadeOut("medium",function(){t.widget.stop().show().animate({bottom:"30px",opacity:1},2*t.delay),t.overlay.fadeIn(t.delay)})})});</script>
	 
	
    <!-- /#wrapper -->
    <!-- jQuery -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('assets/member/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('assets/member/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{ asset('assets/member/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
    <!--slimscroll JavaScript -->
    <script src="{{ asset('assets/member/js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('assets/member/js/waves.js') }}"></script>
    <!--Counter js -->
    <script src="{{ asset('assets/member/plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>
    <script src="{{ asset('assets/member/plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>
    <!--Morris JavaScript -->
    <!--<script src="{{ asset('assets/member/plugins/bower_components/raphael/raphael-min.js') }}"></script>-->
    <!--<script src="{{ asset('assets/member/plugins/bower_components/morrisjs/morris.js') }}"></script>-->
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('assets/member/js/custom.min.js') }}"></script>
    <!--<script src="{{ asset('assets/member/js/dashboard1.js') }}"></script>-->
    <script src="{{ asset('assets/member/plugins/bower_components/toast-master/js/jquery.toast.js') }}"></script>
	<script src="{{ URL::asset('js/jquery.iframetracker.js') }}"></script>
	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
	<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
	<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
	<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>
	<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.colVis.min.js"></script>
    <script type="text/javascript">
	$.ajaxSetup({
		headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
	});	
	function toastMessage(data){
		$.toast({
            heading: '<h3 style="color:white;"><strong>Success</strong></h3>',
            text: "<strong>"+data[0]+"</strong>",
            position: 'top-right',
            loaderBg: '#ffffff',
            icon: 'success',
            hideAfter: 5000,
            stack: 6
         })
	}
	function toastMessageError(data){
		$.toast({
            heading: 'Error',
            text: data[0],
            position: 'top-right',
            loaderBg: '#ffffff',
            icon: 'error',
            hideAfter: 5000,
            stack: 6
         })
	}
	function viewWinners(id){
		document.getElementById("loaddiv").innerHTML = '<center><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><center>';
		$("#loaddiv").empty();
		$("#loaddiv").load('/load/tap-winners/'+id);
		$('#modaldetails').modal();
		}
		$('#modaldetails').on('hidden.bs.modal', function () {
		   $("#loaddiv").empty();
		})
    </script>
	@yield('script')
</body>

</html>
