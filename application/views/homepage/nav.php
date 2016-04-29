<body>
<header id="home">
	<div id="navigation-bar">
		<div class="container">
		<h1 id="logo"><a href="<?=base_url();?>" title="Legend Repricing"><img src="<?=base_url();?>/asset/images_d/logo-legendRepricing.png" alt="" title="" /></a></h1>
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="glyphicon glyphicon-align-justify"></span> Menu</button>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navigation">
					<li class="active"><a href="<?=base_url();?>" title="Home"><span>Home</span></a></li>
					<li><a href="<?=base_url();?>home/about" title="About"><span>About</span></a></li>
					<li><a href="<?=base_url();?>home/pricing" title="Pricing"><span>Pricing</span></a></li>
					<li><a href="<?=base_url();?>home/contact" title="Contact"><span>Contact</span></a></li>
					<li><a href="<?=base_url();?>blog" title="Blog"><span>Blog</span></a></li>
<!--					<li><a href="<?=base_url();?>home/privacy" title="Privacy"><span>Privacy</span></a></li>
					<li><a href="<?=base_url();?>home/tos" title="TOS"><span>TOS</span></a></li>-->
					<!--<li><a href="#" title="Login"><span>Login</span></a></li>-->
					<li>        <a href="#login" data-toggle="modal" data-target="#myModal" data-backdrop="static"><span>Login</span></a></li>
					<!--<li><a href="#" title="Sign Up" class="btn"><span>Try Legend Repricing for Fre<i class="fa fa-user"></i> </span></a></li>-->
					<!--<li><a href="#" data-toggle="modal" data-target="#myModalSignupfree" data-backdrop="static"><span>Try Legend Repricing for Free<i class="fa fa-user"></i> </span></a></li>-->
					<li><a class="btn" href="#signup" data-toggle="modal" data-target="#myModalSignupfree" data-backdrop="static"><span>Try Legend Repricing for Free</span></a></li>
				</ul>
			</div>
		</div>
	</div>

<?php include_once('signupmodal.php');?>
<?php include_once('loginmodal.php');?>
<div class="modal fade" id="verifymsg" role="dialog"> 
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Information</h4>
      </div>
      <div class="modal-body">
       <strong><?php  echo $this->session->flashdata('errors'); ?></strong> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="box-bannerImg">
	<div class="banner-content">
		<div class="container">	 
      <h1 class="heading-banner repricing">
		        <span class="rotate1">THE </span>
				<span class="rotate2" style="color: #4DFFFF">GENEROUS,INSIGHTFUL,AUTOMATED,INTELLIGENT,RESOURCEFUL,FLEXIBLE,RELIABLE,EFFECTIVE,INTUITIVE,POWERFUL,INDEPENDENT,
				NIMBLE,COMPETITIVE,DECISIVE,ANALYTICAL,ALGORITHMIC,FAST,COMMUNICATIVE,BRAINY,DILIGENT
				</span>
			    <span class="breakline" style="display: none;"> <br> </span>
				<span class="rotate3"> REPRICING FIRM </span>
	             </h1>
</div>
	</div>
	<div class="banner-bottom-content">	
		<div class="container">	 	
      <h3>Try Legend Repricing FREE FOR 3 MONTHS - NO CREDIT CARD REQUIRED <a class="btn btn-xl"   href="#" data-toggle="modal" data-target="#myModalSignupfree" data-backdrop="static">Sign Up Now</a></h3>
    </div>
	</div>	
	</div></header>
<!--	<div class="flexslider">
		<ul class="slides">-->
<!--			<img src="<?=base_url();?>/asset/images_d/img-banner.jpg" alt="" title="" />-->
<!--			<li><img src="<?=base_url();?>/asset/images_d/img-banner.jpg" alt="" title="" /></li>
		</ul>
	</div>
</header>       -->
<div class="modal fade" id="premiumSignup" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Signup</h4>
      </div>
      <form role="form" action="<?php echo base_url("signup") ?>" method="post">  
        <div class="modal-body">
          <p><strong> Get Started with a Free 3 month PREMIUM version Trial</strong></p>
          <div class="form-group">
           		<label for="exampleInputEmail1">Email address</label>
							<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user"></i></span>             
									<input name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" type="email" data-error="Bruh, that email address is invalid" required>
  						</div>
							<div class="help-block with-errors"></div>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <label for="exapmppleinfo">Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters</label>
           	<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>  
									<input name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" type="password" required>
            </div>
						<div class="help-block with-errors"></div>	
          </div>
          <p><strong> A confirmation link will be sent to your email adddress</strong></p>
        </div>
        <div class="modal-footer">
          <a href="#" data-dismiss="modal" class="btn"><span class="glyphicon glyphicon-remove"></span> Close</a>
          <button type="submit" class="btn"><span class="glyphicon glyphicon-off"></span> Signup</button>
        </div>
      </form>
    </div>
  </div>
</div>  
    
<div class="modal fade" id="myModalSignup" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Signup</h4>
      </div>
      <form role="form" id="" action="" method="post">  
        <div class="modal-body">
          <p><strong> Get Started with a Free 3 month BASIC version Trial</strong></p>
          <div class="form-group">
           		<label for="exampleInputEmail1">Email address</label>
							<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user"></i></span>             
									<input name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" type="email" data-error="Bruh, that email address is invalid" required>
  						</div>
							<div class="help-block with-errors"></div>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
           	<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>  
									<input name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" type="password" required>
            </div>
						<div class="help-block with-errors"></div>	
          </div>
          <p><strong> A confirmation link will be sent to your email adddress</strong></p>
        </div>
        <div class="modal-footer">
          <a href="#" data-dismiss="modal" class="btn"><span class="glyphicon glyphicon-remove"></span> Close</a>
          <button type="submit" id="" class="btn"><span class="glyphicon glyphicon-off"></span> Signup</button>
        </div>
      </form>
    </div>
  </div>
</div>   


