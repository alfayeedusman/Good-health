<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Blog | Landing page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link href="{{URL::asset('/css/landing/magnific-popup/magnific-popup.css')}}" rel="stylesheet">
    <link href="{{URL::asset('/css/landing/creative.min.css')}}" rel="stylesheet">
</head>
<body id="page-top">
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">Blog</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#about">How</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="{{route('login')}}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="{{route('register')}}">Sign Up</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<header class="masthead text-center text-white d-flex">
    <div class="container my-auto" id="page-top">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <h1 class="text-uppercase">
                    <strong>Blog Spot Title</strong>
                </h1>
                <hr>
            </div>
            <div class="col-lg-8 mx-auto">
                <p class="text-faded mb-5">Want extra income ?</p>
                <a class="btn btn-primary btn-xl js-scroll-trigger" href="#about">I WANT !!!</a>
            </div>
        </div>
    </div>
</header>
<section class="bg-primary" id="about">
    <div class="container" style="color:white">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">How to ?</h2>
            </div>
        </div>
    </div>
    <div class="container" style="color:white">
        <div class="row">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto" >
                    <i class="fa fa-4x fa-money mb-3 sr-icons" ></i>
                    <h3 class="mb-3">No Entry Payment</h3>
                    <p class="mb-0">No payment required.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fa fa-4x fa-users  mb-3 sr-icons"></i>
                    <h3 class="mb-3">No Invites</h3>
                    <p class="mb-0">No more Invites to earn</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fa fa-4x fa-rub  mb-3 sr-icons"></i>
                    <h3 class="mb-3">Unli Income</h3>
                    <p class="mb-0">Unlimited extra income.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fa fa-4x fa-newspaper-o  mb-3 sr-icons"></i>
                    <h3 class="mb-3">Post and Earn</h3>
                    <p class="mb-0">Post more earn more</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="services">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">At Your Service</h2>
                <hr class="my-4">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fa fa-4x fa-diamond text-primary mb-3 sr-icons"></i>
                    <h3 class="mb-3">Sturdy Templates</h3>
                    <p class="text-muted mb-0">Our templates are updated regularly so they don't break.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fa fa-4x fa-paper-plane text-primary mb-3 sr-icons"></i>
                    <h3 class="mb-3">Ready to Ship</h3>
                    <p class="text-muted mb-0">You can use this theme as is, or you can make changes!</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fa fa-4x fa-newspaper-o text-primary mb-3 sr-icons"></i>
                    <h3 class="mb-3">Up to Date</h3>
                    <p class="text-muted mb-0">We update dependencies to keep things fresh.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="service-box mt-5 mx-auto">
                    <i class="fa fa-4x fa-heart text-primary mb-3 sr-icons"></i>
                    <h3 class="mb-3">Made with Love</h3>
                    <p class="text-muted mb-0">You have to make your websites with love these days!</p>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{URL::asset('/js/landing/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="{{URL::asset('/js/landing/jquery-easing/jquery.easing.min.js')}}"></script>
<script src="{{URL::asset('/js/landing/scrollreveal/scrollreveal.min.js')}}"></script>
<script src="{{URL::asset('/js/landing/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
<script src="{{URL::asset('/js/landing/creative.min.js')}}"></script>
</body>
</html>
