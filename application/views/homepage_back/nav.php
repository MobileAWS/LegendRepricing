<body>
<header id="home">
	<div id="navigation-bar">
		<div class="container">
			<h1 id="logo"><a href="#" title="Legend Repricing">Legend Repricing</a></h1>
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="glyphicon glyphicon-align-justify"></span> Menu</button>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navigation">
					<li class="active"><a href="#" title="Home"><span>Home</span></a></li>
					<li><a href="#" title="About"><span>About</span></a></li>
					<li><a href="#" title="Contact"><span>Contact</span></a></li>
					<!--<li><a href="#" title="Login"><span>Login</span></a></li>-->
					<li>        <a href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static"><span>Login</span></a></li>
					<!--<li><a href="#" title="Sign Up" class="btn"><span>Sign Up <i class="fa fa-user"></i> </span></a></li>-->
					<li><a href="#" data-toggle="modal" data-target="#myModalSignup" data-backdrop="static"><span>Sign Up <i class="fa fa-user"></i> </span></a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="flexslider">
		<ul class="slides">
			<li><img src="<?=base_url();?>/asset/images_d/img-banner.jpg" alt="" title="" /></li>
			<li><img src="<?=base_url();?>/asset/images_d/img-banner.jpg" alt="" title="" /></li>
		</ul>
	</div>
</header>
<div class="modal fade" id="myModalSignup" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Signup</h4>
      </div>
      <form role="form" action="<?php echo base_url("signup") ?>" method="post">  
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" type="email" data-error="Bruh, that email address is invalid" required>
              <div class="help-block with-errors"></div>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" type="password" required>
              <div class="help-block with-errors"></div>
          </div>
          <p class="text-right"><strong> A confirmation link will be sent to your email adddress</strong></p>
        </div>
        <div class="modal-footer">
          <a href="#" data-dismiss="modal" class="btn">Close</a>
          <button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Signup</button>
        </div>
      </form>
    </div>
  </div>
</div>   
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="padding:35px 50px;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4><span class="glyphicon glyphicon-lock"></span> Login</h4>
      </div>
      <div class="modal-body" style="padding:40px 50px;">
        <form role="form" action="<?php echo base_url() ?>login" method="post">
          <div class="form-group">
            <label for="usrname"><span class="glyphicon glyphicon-user"></span> Username/Email address</label>
            <input name="email" type="email" class="form-control" id="usrname" placeholder="Enter email" data-error="Bruh, that email address is invalid" required>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group">
            <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
            <input type="password" name="password" class="form-control" id="psw" placeholder="Enter password" required>
            <div class="help-block with-errors"></div>
          </div>
          <div class="checkbox">
            <label><input type="checkbox" value="" checked>Remember me</label>
          </div>
          <button type="submit" class="btn btn-success btn-block" ><span class="glyphicon glyphicon-off"></span> Login</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
        <!--    <p>Not a member? <a href="#">Sign Up</a></p>-->
        <p><a href="<?php echo base_url(); ?>home/forgot_pass">Forgot Password?</a></p>
      </div>
    </div>

  </div>
</div> 

