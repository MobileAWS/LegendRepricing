<body class="innerPage">
	<header id="home">
	<div id="navigation-bar">
		<div class="container">
			<h1 id="logo"><a href="<?=base_url();?>" title="Legend Repricing"><img src="<?=base_url();?>/asset/images_d/logo-legendRepricing.png" alt="" title="" /></a></h1>
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="glyphicon glyphicon-align-justify"></span> Menu</button>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navigation">
				 
					<li class="<?php if ( strpos($_SERVER['REQUEST_URI'],'content/settings') ){ echo 'active';}?>"><a href="<?=base_url();?>content/settings" title="Settings"><span>Settings</span></a></li>
					<li class="<?php if ( strpos($_SERVER['REQUEST_URI'] , 'content/dashboard') ){ echo 'active';}?>"><a href="<?=base_url();?>content/dashboard" title="Dashboard"><span>Dashboard</span></a></li>
					<li class="<?php if ( strpos($_SERVER['REQUEST_URI'] , 'content/listings') ){ echo 'active';}?>"><a href="<?=base_url();?>content/listings" title="Listings"><span>Listings</span></a></li>
                    <li class="<?php if ( strpos($_SERVER['REQUEST_URI'] , 'content/insight') ){ echo 'active';}?>"><a href="<?=base_url();?>content/insight" title="Insight"><span>Insight</span></a></li>
					<li class="<?php if ( strpos($_SERVER['REQUEST_URI'] , 'content/manage' )){ echo 'active';}?>"><a href="<?=base_url();?>content/manage" title="Manage"><span>Manage</span></a></li>
					<li class="<?php if ( strpos($_SERVER['REQUEST_URI'] , 'content/status') ){ echo 'active';}?>"><a href="<?=base_url();?>content/status" title="Status Page"><span>Status Page</span></a></li>
					<!--<li><a href="#" title="Login"><span>Login</span></a></li>-->
				   <!--<li><a href="#" title="Sign Up" class="btn"><span>Sign Up <i class="fa fa-user"></i> </span></a></li>-->
<!--               	<li>   <a href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static"><span>Logout <i class="fa fa-sign-out"></i> </span></a></li>-->
 <li><a  href="<?=base_url();?>logout">Logout</a></li>
				
				</ul>
			</div>
		</div>
	</div>
</header>
	    
     
      

