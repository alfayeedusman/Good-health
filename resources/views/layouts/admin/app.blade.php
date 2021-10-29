<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

     <title>@yield('title')</title>

    <!-- Bootstrap Core CSS -->
	<link href="{{ URL::asset('assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ URL::asset('assets/admin/dist/css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link href="{{ URL::asset('assets/admin/bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.bootstrap.min.css">
	@yield('head')
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Super Admin</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
              
                   
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
						<li>
                            <a href="{{ route('admin.members') }}"><i class="fa fa-users fa-fw"></i> Members</a>
                        </li>
						@if(isPermitted()==true)
						<li>
                            <a href="{{ route('admin.activation.codes') }}"><i class="far fa-dot-circle fa-fw"></i> Activation Codes</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.unilevel.codes') }}"><i class="far fa-dot-circle fa-fw"></i> Unilevel Codes</a>
                        </li>
						@endif
			
						
						<li>
                            <a href="{{ route('admin.accounts') }}"><i class="fa fa-users fa-fw"></i> Accounts</a>
                        </li>
						<li>
                            <a href="{{ route('admin.genealogy', ['account' => 'admin' ]) }}"><i class="fas fa-bezier-curve fa-fw"></i> Genealogy</a>
                        </li>

                        <li>
                            <a href="{{ route('admin.encashments') }}"><i class="fas fa-money"></i> Encashments</a>
                        </li>
                         <li>
                            <a href="{{ route('admin.encashmentsgc') }}"><i class="fas fa-money"></i>GC Withdrawals</a>
                        </li>
						@if(isPermitted()==true)
						<li>
                            <a href="{{ route('admin.admin.users') }}"><i class="fa fa-cog fa-fw"></i> Admin Users</a>
                        </li>
						@endif
						
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
           @yield('content')
		   <br>
			<br>
			<br>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="{{ URL::asset('assets/admin/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

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
	
	@yield('page-script')

</body>

</html>
