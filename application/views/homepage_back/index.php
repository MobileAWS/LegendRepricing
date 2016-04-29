<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>Legend Pricing- Ultimate repricer for Amazon US marketplace</title>

<link rel="shortcut icon" href="img/favicon.ico" />
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="css/business-casual.css" rel="stylesheet">

<!-- Fonts -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<style>
.modal-open .modal,a:focus{
      outline:none!important
}
</style>

</head>

<body>

<div class="brand">Legend Pricing</div>
<div class="address-bar">3481 Melrose Place | Beverly Hills, CA 90210 | 123.456.7890</div>

<!-- Navigation -->
<nav class="navbar navbar-default" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!-- navbar-brand is hidden on larger screens, but visible when the menu is collapsed -->
      <a class="navbar-brand" href="index.html">Legend Pricing</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li>
        <a href="index.html">Home</a>
        </li>
        <li>
        <a href="about.html">About</a>
        </li>
        <!--                    <li>
                        <a href="blog.html">Blog</a>
                    </li> -->
        <li>
        <a href="contact.html">Contact</a>
        </li>
        <li>
        <a href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static">Login</a>
        </li>
        <li>
        <a href="#myModal" data-toggle="modal" data-target="#myModalSignup" data-backdrop="static">Signup</a>
        </li>
      </ul>

    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container -->
</nav>

<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="padding:35px 50px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4><span class="glyphicon glyphicon-lock"></span> Login</h4>
      </div>
      <div class="modal-body" style="padding:40px 50px;">
        <form role="form">
          <div class="form-group">
            <label for="usrname"><span class="glyphicon glyphicon-user"></span> Username</label>
            <input type="text" class="form-control" id="usrname" placeholder="Enter email">
          </div>
          <div class="form-group">
            <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
            <input type="text" class="form-control" id="psw" placeholder="Enter password">
          </div>
          <div class="checkbox">
            <label><input type="checkbox" value="" checked>Remember me</label>
          </div>
          <button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Login</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
        <p>Not a member? <a href="#">Sign Up</a></p>
        <p>Forgot <a href="#">Password?</a></p>
      </div>
    </div>

  </div>
</div> 


 <div class="modal fade" id="myModalSignup">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Signup</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Email address</label>
          <input class="form-control" id="exampleInputEmail1" placeholder="Enter email" type="email">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input class="form-control" id="exampleInputPassword1" placeholder="Password" type="password">
        </div>
        <p class="text-right"><strong> A confirmation link will be sent to your email adddress</strong></p>
      </div>
      <div class="modal-footer">
        <a href="#" data-dismiss="modal" class="btn">Close</a>
        <a href="#" class="btn btn-primary">Signup</a>
      </div>
    </div>
  </div>
</div> 
<!--
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Login</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Email address</label>
          <input class="form-control" id="exampleInputEmail1" placeholder="Enter email" type="email">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input class="form-control" id="exampleInputPassword1" placeholder="Password" type="password">
        </div>
        <p class="text-right"><a href="#">Forgot password?</a></p>
      </div>
      <div class="modal-footer">
        <a href="#" data-dismiss="modal" class="btn">Close</a>
        <a href="#" class="btn btn-primary">Login</a>
      </div>
    </div>
  </div>
</div>
-->
<div class="container">

  <div class="row">
    <div class="box">
      <div class="col-lg-12 text-center">
        <div id="carousel-example-generic" class="carousel slide">
          <!-- Indicators -->
          <ol class="carousel-indicators hidden-xs">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
          </ol>

          <!-- Wrapper for slides -->
          <div class="carousel-inner">
            <div class="item active">
              <img class="img-responsive img-full" src="img/slide-1.jpg" alt="">
            </div>
            <div class="item">
              <img class="img-responsive img-full" src="img/slide-2.jpg" alt="">
            </div>
            <div class="item">
              <img class="img-responsive img-full" src="img/slide-3.jpg" alt="">
            </div>
          </div>

          <!-- Controls -->
          <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
            <span class="icon-prev"></span>
          </a>
          <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
            <span class="icon-next"></span>
          </a>
        </div>
        <h2 class="brand-before">
          <small>Welcome to</small>
        </h2>
        <h1 class="brand-name">Legend Pricing</h1>
        <hr class="tagline-divider">
        <h2>
          <small>Powered By
            <strong>Amazon APis</strong>
          </small>
        </h2>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="box">
      <div class="col-lg-12">
        <hr>
        <h2 class="intro-text text-center">Repricing
          <strong>worth trying</strong>
        </h2>
        <hr>
        <img class="img-responsive img-border img-left" src="img/intro-pic.jpg" alt="">
        <hr class="visible-xs">
        <p>The boxes used in this template are nested inbetween a normal Bootstrap row and the start of your column layout. The boxes will be full-width boxes, so if you want to make them smaller then you will need to customize.</p>
        <p>A huge thanks to <a href="http://join.deathtothestockphoto.com/" target="_blank">Death to the Stock Photo</a> for allowing us to use the beautiful photos that make this template really come to life. When using this template, make sure your photos are decent. Also make sure that the file size on your photos is kept to a minumum to keep load times to a minimum.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc placerat diam quis nisl vestibulum dignissim. In hac habitasse platea dictumst. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="box">
      <div class="col-lg-12">
        <hr>
        <h2 class="intro-text text-center">Beautiful boxes
          <strong>to showcase your content</strong>
        </h2>
        <hr>
        <p>Use as many boxes as you like, and put anything you want in them! They are great for just about anything, the sky's the limit!</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc placerat diam quis nisl vestibulum dignissim. In hac habitasse platea dictumst. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
      </div>
    </div>
  </div>

</div>
<!-- /.container -->

<footer>
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <p>Copyright &copy; Legend Pricing 2015</p>
      </div>
    </div>
  </div>
</footer>

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Script to Activate the Carousel -->
<script>
$('.carousel').carousel({
interval: 5000 //changes the speed
})
</script>

</body>

</html>
