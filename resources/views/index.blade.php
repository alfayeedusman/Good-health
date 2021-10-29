<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<title>GOODHEALTH</title>
<meta name="description" content="">  
<meta name="author" content="">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">



<link rel="stylesheet" href="{{ URL::asset('assets/page/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/page/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/page/css/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/page/css/core.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/page/css/shortcode/shortcodes.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/page/css/style.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/page/css/responsive.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/page/css/custom.css') }}">
<script src="{{ URL::asset('assets/page/js/vendor/modernizr-3.5.0.min.js') }}"></script>

<style>
.parallax {
  /* The image used */
  background-image: url("{{ URL::asset('assets/page/wellness.jpg') }}");

  /* Set a specific height */
  height: 800px;

  /* Create the parallax scrolling effect */
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

.parallax2 {
  /* The image used */
  background-image: url("{{ URL::asset('assets/page/health.jpg') }}");

  /* Set a specific height */

  /* Create the parallax scrolling effect */
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}
</style>
</head>
<body  data-spy="scroll" data-target=".main__menu" data-offset="0">
   
<!-- Body main wrapper start -->
    <div class="wrapper">
        <!-- Start Header Style -->
        <header id="htc__header" class="htc__header__area header--one " style="background:#2db300; ">
            <!-- Start Mainmenu Area -->
			
            <div id="sticky-header-with-topbar" class="mainmenu__wrap sticky__header" style="background:#2db300;">
			<div class="col-lg-12 " style="height:30px; background:black;"> 
			</div>
                <div class="container">
                    <div class="row">
                        <div class="menumenu__container clearfix">
                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5"> 
                                <div class="logo">
                                     <a href=""><img src="{{ URL::asset('assets/logo.png') }}" alt="logo images" class="img-responsive" style="height:120px; margin-top:10px;"> </a> 
                                </div>
                            </div>
                            <div class="col-md-5 col-lg-8 col-sm-5 col-xs-3">
                                <nav class="main__menu__nav hidden-xs hidden-sm" id="nav1" >
                                    <ul class="main__menu">
                                        <li class="drop" ><a href="#home" style="color:white;">Home</a></li>
                                        <li ><a href="#products" style="color:white;">Products</a></li>
										<li ><a href="#mission" style="color:white;">Mission/Vision</a></li>
										<li ><a href="#aboutus" style="color:white;">About Us</a></li>
                                        <li ><a href="#contact" style="color:white;">Contact</a></li>
                                    </ul>
                                </nav>

                                <div class="mobile-menu clearfix visible-xs visible-sm" >
                                    <nav id="mobile_dropdown" >
                                        <ul >
                                            <li><a href="#home">Home</a></li>
                                            <li><a href="#products">Products</a></li>
											<li><a href="#mission">Mission/Vision</a></li>
											<li><a href="#aboutus">About Us</a></li>
                                            <li><a href="#contact">Contact</a></li>
                                        </ul>
                                    </nav>
                                </div>  
                            </div>
                            <div class="col-md-3 col-lg-2 col-sm-4 col-xs-4">
                                <div class="header__right">
                                     <!--<div class="header__search search search__open">
                                        <a href="#" ><i class="icon-magnifier icons" style="color:white;"></i></a>
                                    </div>-->
                                    <div class="header__account">
                                        <a href="/login"><i class="icon-user icons" style="color:white;"></i></a>
                                    </div>
                                    <div class="htc__shopping__cart">
                                        <a class="cart__menu" href="#"><i class="icon-handbag icons" style="color:white;"></i></a>
                                        <a href="#"><span class="htc__qua">0</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mobile-menu-area"></div>
                </div>
            </div>
            <!-- End Mainmenu Area -->
        </header>
        <!-- End Header Area -->

        <div class="body__overlay"></div>
        <!-- Start Offset Wrapper -->
        <div class="offset__wrapper">
            <!-- 
            <div class="search__area">
                <div class="container" >
                    <div class="row" >
                        <div class="col-md-12" >
                            <div class="search__inner">
                                <form action="#" method="get">
                                    <input placeholder="Search here... " type="text">
                                    <button type="submit"></button>
                                </form>
                                <div class="search__close__btn">
                                    <span class="search__close__btn_icon"><i class="zmdi zmdi-close"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
            <!-- End Search Popap -->
            <!-- Start Cart Panel -->
            <!--<div class="shopping__cart">
                <div class="shopping__cart__inner">
                    <div class="offsetmenu__close__btn">
                        <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                    <div class="shp__cart__wrap">
                        <div class="shp__single__product">
                            <div class="shp__pro__thumb">
                                <a href="#">
                                    <img src="{{ URL::asset('assets/page/product/1.jpg') }}" alt="product images">
                                </a>
                            </div>
                            <div class="shp__pro__details">
                                <h2><a href="">Product 1</a></h2>
                                <span class="quantity">QTY: 1</span>
                                <span class="shp__price">P0.00</span>
                            </div>
                            <div class="remove__btn">
                                <a href="#" title="Remove this item"><i class="zmdi zmdi-close"></i></a>
                            </div>
                        </div>

                    </div>
                    <ul class="shoping__total">
                        <li class="subtotal">Subtotal:</li>
                        <li class="total__price">$130.00</li>
                    </ul>
                    <ul class="shopping__btn">
                        <li><a href="cart.html">View Cart</a></li>
                        <li class="shp__checkout"><a href="">Checkout</a></li>
                    </ul>
                </div>
            </div>-->
            <!-- End Cart Panel -->
        </div>
        <!-- End Offset Wrapper -->
        <!-- Start Slider Area -->
        <div class="slider__container slider--one bg__cat--3 parallax" id="home">
            <div class="slide__container slider__activation__wrap owl-carousel">
                
				@for( $x=1; $x<9; $x++)
                <div class="single__slide animation__style01 slider__fixed--height">
                    <div class="container">
                        <div class="row align-items__center">
                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                <div class="slide">
                                    <div class="slider__inner">
										@if($x==1)
									
											<h2>TRIM AND SLIM</h2>
											<h1>20 in 1 Coffee Herbal Mix</h1>
											<?php $style =  'height:90%; width:90%;';?>
										@elseif($x==2)
											<h2></h2>
											<h1>20 in 1 Herbal Juice</h1>
											<?php $style =  'height:90%; width:90%;';?>
										@elseif($x==3)
											<h2>TRIM AND SLIM</h2>
											<h1>Milk Tea</h1>
											<?php $style =  'height:90%; width:90%;';?>
										@elseif($x==4)
				
											<h1>Protect Cee Plus</h1>
											<?php $style =  'height:90%; width:90%;';?>
										@elseif($x==5)
											<h2>Aroma</h2>
											<h1>Herbal Oil</h1>
											<?php $style =  'height:90%; width:90%;';?>
										@elseif($x==6)
											<h2>Premium</h2>
											<h1>Whitening Loation</h1>
											<?php $style =  'height:90%; width:90%;';?>
										@elseif($x==7)
											<h2>3 IN 1 Premium</h2>
											<h1>Whitening Soap</h1>
											<?php $style =  'height:90%; width:90%;';?>
                                        @elseif($x==8)
                                            <h2>Herbal Supliment</h2>
                                            <h1>Serpentina</h1>
                                            <?php $style =  'height:90%; width:90%;';?>
										@endif
                                        
                                    </div>
                                </div>
                            </div>
                              <div class="col-sm-12 col-xs-12 col-md-8 col-lg-8">
                            	
                                <div class="slide__thumb">
                                	<center>
                                    <img src="{{ URL::asset('assets/page/slides/'.$x.'.jpg') }}" style="{{$style}}" alt="slider images">
                                    </center>
                                </div>
                            	
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
               
            </div>
        </div>
        <!-- Start Slider Area -->
        <!-- Start Category Area -->
        <section class="htc__category__area ptb--100" id="products">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="section__title--2 text-center">
                            <h2 class="title__line">Products</h2>
                        </div>
                    </div>
                </div>
                <div class="htc__product__container">
                    <div class="row">
                        <div class="product__list clearfix mt--30">
                            <!-- Start Single Category -->
							
							
                            <div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="">
                                            <img src="{{ URL::asset('assets/page/product/1.jpg') }}" alt="product images">
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="">
                                            <img src="{{ URL::asset('assets/page/product/2.jpg') }}" alt="product images">
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="">
                                            <img src="{{ URL::asset('assets/page/product/3.jpg') }}" alt="product images">
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="">
                                            <img src="{{ URL::asset('assets/page/product/4.jpg') }}" alt="product images">
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-3 col-lg-4 col-sm-12 col-xs-12">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="">
                                            <img src="{{ URL::asset('assets/page/product/5.jpg') }}" alt="product images">
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="">
                                            <img src="{{ URL::asset('assets/page/product/6.jpg') }}" alt="product images">
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="">
                                            <img src="{{ URL::asset('assets/page/product/7.jpg') }}" alt="product images">
                                        </a>
                                    </div>

                                </div>
                            </div>
                            
			                 <div class="col-md-12">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="">
                                            <img src="{{ URL::asset('assets/page/1.jpg') }}" alt="product images">
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="category">
                                    <div class="ht__cat__thumb">
                                        <a href="">
                                            <img src="{{ URL::asset('assets/page/3.jpg') }}" alt="product images">
                                        </a>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Category Area -->
        <!-- Start Prize Good Area -->
        <section class=" parallax2"  id="mission">
            <div class="container">
                <div class="row">
                	<div class="col-md-12">
					<div class="section__title--2 text-center">
							<br><br>
							<h2 class="title__line">Mission / Vision</h2>
					</div>
					</div>
                    <div class="col-md-12">
                        <center>
                        <br><br><br>
						<img src="{{ URL::asset('assets/page/mission.jpg') }}" alt="ceo" style="height:70%; width:70%;" class="img-responsive"><br>
						<br><br><br>
						</center>
                    </div>

					
                </div>
            </div>
        </section>

		<section class="htc__category__area ptb--100" id="aboutus">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
				<div class="section__title--2 text-center">
						<h2 class="title__line">About Us</h2>
						<br><br>
				</div>
				</div>
				<div class="col-12 col-md-6 col-lg-6">
					<div >
					<center>
						<img src="{{ URL::asset('assets/page/People.jpg') }}" alt="ceo" style="height:100%; width:100%;" class="img-responsive"><br>
						<br>
					</center>
					</div>
				</div>
				<div class="col-12 col-md-6 col-lg-6">
					<div >
					<center>
						<img src="{{ URL::asset('assets/page/profile.jpg') }}" alt="ceo" style="height:100%; width:100%;" class="img-responsive"><br>
						<br>
					</center>
					</div>
				</div>
			</div>
		  
		</div>
		</section>
        <section class="htc__category__area " id="contact">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="section__title--2 text-center">
						<h2 class="title__line">Contact</h2>
						<br><br>
					</div>
					 <div class="address">
                            <div class="address__icon">
                                <i class="icon-location-pin icons"></i>
                            </div>
                            <div class="address__details">
                                <h2 class="ct__title">our address</h2>
                                <h5>Mabini St., Lucina Bldg., 1st floor, Catbangen, San Fernando City, La Union</h5>
                            </div>
                        </div>
                        <div class="address">
                            <div class="address__icon">
                                <i class="icon-envelope icons"></i>
                            </div>
                            <div class="address__details">
                                <h2 class="ct__title">opening hour</h2>
                                <h5>9am to 6pm (Monday to Saturday)<br>
1pm to 6pm ( Sunday)</h5>
                            </div>
                        </div>

                        <div class="address">
                            <div class="address__icon">
                                <i class="icon-phone icons"></i>
                            </div>
                            <div class="address__details">
                                <h2 class="ct__title">Phone Number</h2>
                                <h5>
								(072) 619-3233</h5>
                            </div>
                        </div>
				</div>
			</div>
		  
		</div>
		</section>
		
	

        
            <!-- Start Copyright Area -->
            <div class="htc__copyright bg__cat--5">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div style="height:50px;">
							<center>
							
                                <h5 style="color: white; margin-top:20px;">Copyright© Goodhealth 2018.. All rights reserved Terms of use | Privacy policy </h5>
                             </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Copyright Area -->
        </footer>
        <!-- End Footer Style -->
    </div>
    <!-- Body main wrapper end -->
 

   
   
   



<script src="{{ URL::asset('assets/page/js/vendor/jquery-3.2.1.min.js') }}"></script>
<script src="{{ URL::asset('assets/page/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('assets/page/js/plugins.js') }}"></script>
<script src="{{ URL::asset('assets/page/js/slick.min.js') }}"></script>
<script src="{{ URL::asset('assets/page/js/owl.carousel.min.js') }}"></script>
<script src="{{ URL::asset('assets/page/js/waypoints.min.js') }}"></script>
<script src="{{ URL::asset('assets/page/js/main.js') }}"></script>

<script>

</script>

</body>
</html>