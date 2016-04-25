<?php
/**
* The Header for our theme.
*
* Displays all of the <head> section and everything up till <main id="main">
*
* @package GeneratePress
*/
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<script type="text/javascript"> //<![CDATA[ 
var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.comodo.com/" : "http://www.trustlogo.com/");
document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
//]]>
</script>
<?php wp_head(); ?>
</head>

<body <?php generate_body_schema();?> <?php body_class(); ?>>
<?php do_action( 'generate_before_header' ); ?>
<a class="screen-reader-text skip-link" href="#content" title="<?php esc_attr_e( 'Skip to content', 'generate' ); ?>"><?php _e( 'Skip to content', 'generate' ); ?></a>
<header id="home">



  <div id="navigation-bar">
    <div class="container">
      <h1 id="logo"><a href="#" title="Legend Repricing"><img src="<?php echo site_url(); ?>/wp-content/themes/generatepress/images/logo-legendRepricing.png" alt="Legend Repricing" title="Legend Repricing" /></a></h1>

      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="glyphicon glyphicon-align-justify"></span> Menu</button>
      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav navigation">
          <li class="active"><a href="<?=site_url('../');?>" title="Home"><span>Home</span></a></li>
          <li><a href="<?=site_url('../home/about');?>" title="About"><span>About</span></a></li>
          <li><a href="<?=site_url('../home/pricing');?>" title="Pricing"><span>Pricing</span></a></li>
          <li><a href="<?=site_url('../home/contact');?>" title="Contact"><span>Contact</span></a></li>
          <li><a href="<?=site_url('../blog');?>" title="Blog"><span>Blog</span></a></li>
          <!--					<li><a href="<?=site_url();?>home/privacy" title="Privacy"><span>Privacy</span></a></li>
                    <li><a href="<?=site_url();?>home/tos" title="TOS"><span>TOS</span></a></li>-->
          <!--<li><a href="#" title="Login"><span>Login</span></a></li>-->
          <li>        <a href="https://legendrepricing.com/#myModal" ><span>Login</span></a></li>
          <!--<li><a href="#" title="Sign Up" class="btn"><span>Try Legend Repricing for Fre<i class="fa fa-user"></i> </span></a></li>-->
          <!--<li><a href="#" data-toggle="modal" data-target="#myModalSignupfree" data-backdrop="static"><span>Try Legend Repricing for Free<i class="fa fa-user"></i> </span></a></li>-->
          <li><a class="btn" href="https://legendrepricing.com/#myModalSignupfree"><span>Try Legend Repricing for Free</span></a></li>
        </ul>
      </div>
    </div>
  </div>
</header>
<script type="text/javascript" language="javascript" src="https://legendrepricing.com/asset/js_d/bootstrap/bootstrap.min.js"></script> 
<div class="modal fade" id="myModalSignupfree" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Try Legend for free for 3 months</h4>
      </div>
      <form role="form" id="signup_form" action="#" method="post">  
        <div class="modal-body">
          <p><strong> Get Started with a FREE Fully Loaded 3 MONTH Trial !</strong></p>
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-user"></i></span>             
              <input name="email" class="form-control" id="signupemail" placeholder="Enter email" type="email" data-error="Bruh, that email address is invalid" required>
            </div>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <label for="exapmppleinfo" class="text-danger"><strong>Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters</strong></label>
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>  
              <input name="password" class="form-control" id="signuppass" placeholder="Password" type="password" required>
            </div>
            <div class="help-block with-errors"></div>  
          </div>
          <p><strong> A confirmation link will be sent to your email adddress</strong></p>
        </div>
        <div class="modal-footer">
          <a href="#" data-dismiss="modal" class="btn"><span class="glyphicon glyphicon-remove"></span> Close</a>
          <button id="signup_settings" type="submit" class="btn"><span class="glyphicon glyphicon-off"></span> Signup</button>
        </div>
      </form>
    </div>
  </div>
</div>   

<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4>Login</h4>
      </div>
      <div class="modal-body">
        <form role="form" id="login_form" action="#" method="post">
          <div class="form-group">
            <label for="usrname">Username/Email address</label>
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-user"></i></span> 
              <input name="email" type="email" class="form-control" id="username" placeholder="Enter email" data-error="Bruh, that email address is invalid" required>
            </div>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group">
            <label for="psw">Password</label>
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
              <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required>
            </div>
            <div class="help-block with-errors"></div>
          </div>
          <div class="checkbox">
            <label><input type="checkbox" value="" checked>Remember me</label>
          </div>
          <button id="login_settings" type="submit" class="btn btn-block" ><span class="glyphicon glyphicon-off"></span> Login</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
        <!--    <p>Not a member? <a href="#">Sign Up</a></p>-->
        <p><a href="<?php echo site_url('../home/forgot_pass');?>" title="Forgot Password?" class="link-forgotPassword">Forgot Password?</a></p>
      </div>
    </div>

  </div>
</div>        
<?php /*?><header itemtype="http://schema.org/WPHeader" itemscope="itemscope" id="masthead" <?php generate_header_class(); ?>>
  <div <?php generate_inside_header_class(); ?>>
    <?php do_action( 'generate_before_header_content'); ?>
    <?php generate_header_items(); ?>
    <?php do_action( 'generate_after_header_content'); ?>
  </div><!-- .inside-header -->
</header><?php */?><!-- #masthead -->
<?php do_action( 'generate_after_header' ); ?>

<div id="page" class="hfeed site grid-container container grid-parent">
  <div id="content" class="site-content">
    <?php do_action('generate_inside_container'); ?>
