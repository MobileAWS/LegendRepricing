<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="es" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="es" > <!--<![endif]-->

  <head>  	
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
	<meta name="description" content="SoloParadECK"/>
	<meta name="keywords" content="Solo Para Deck, Solo, Para, Deck, SPD, soloparadeck.com" />
	<meta name="author" content="Juanito Villa"/>
    <link rel="shortcut icon" href="favicon.png"> 
    
	<title><?php array_shift(explode(".",$_SERVER['HTTP_HOST'])); ?></title>
    <!-- Bootstrap core CSS -->
    <link href="asset/login/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="asset/login/css/login.css" rel="stylesheet">
    <link href="asset/login/css/animate-custom.css" rel="stylesheet">
   

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
    
     <script src="asset/login/js/custom.modernizr.js" type="text/javascript" ></script>
   
  </head>
    <body>
    	<!-- start Login box -->
    	<div class="container" id="login-block">
    		<div class="row">
			    <div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
			    	<h3 class="animated bounceInDown">Entrar</h3>
			       <div class="login-box clearfix animated flipInY">
			        	<div class="login-logo">
			        		<a href="#"><img src="asset/login/img/login-logo.png" alt="Company Logo" /></a>
			        	</div> 
			        	<hr />
			        	<div class="login-form">
			        		<!-- Start Error box -->
			        		<div class="alert alert-danger hide">
								  <button type="button" class="close" data-dismiss="alert"> &times;</button>
								  <h4>Error!</h4>
								  
							</div> <!-- End Error box -->
							
			        		<form action="<?= base_url()?>" method="post"  >
						   		 <input type="text" name="username" <?= isset($_POST['username'])?$_POST['username']:''?> placeholder="Usuario" required/> 
						   		 <input type="password" name="password"  placeholder="Contrase&ntilde;a" required/> 
						   		 <button type="submit" value="Login" class="btn btn-red">Entrar</button> 
							</form>	
							<div class="login-links"> 
								<a href="#">
					              <strong>NING&Uacute;N DECK EST&Aacute; EN VENTA, EST&Aacute; PROHIBIDO VENDER O CAMBIAR CUALQUIER DECK.</strong>
					            </a>
					            <br />
								<a href="#">
					              <strong>Nadie debe pedirte tu contrase&ntilde;a de Twitter para usar SPD.</strong>
					            </a>
					            <br />
					            <a href="http://soloparadeck.com">
					             <u>No tienes deck SPD? <strong>Pidelo dando click aqui</strong></u>
					            </a>
							</div>      		
			        	</div> 			        	
			       </div>
			  	   	

			    </div>
			</div>
    	</div>
     
      	<!-- End Login box -->
     	<footer class="container">
     		<p id="footer-text"><small>Copyright &copy; 2014 <a href="http://soloparadeck.com/">SoloParaDeck.com</a></small></p>
     	</footer>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/jquery-1.9.1.min.js"><\/script>')</script> 
        <script src="js/bootstrap.min.js"></script> 
        <script src="js/placeholder-shim.min.js"></script>        
        <script src="js/custom.js"></script>
    </body>
</html>
