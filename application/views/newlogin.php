<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="asset/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="asset/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">


    <!-- Custom CSS -->
    <link href="asset/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="asset/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->                          
  <script src="asset/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="asset/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="asset/bower_components/metisMenu/dist/metisMenu.min.js"></script>

      <script src="https://www.google.com/recaptcha/api.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="asset/dist/js/sb-admin-2.js"></script> 
 <style>
     .error{
      color:red;
     }
    </style>

</head>

<body>
              
<div class="container">
     <div class="row">
         <div class="col-md-6">
             <div class="row">
                 <div class="col-md-8">
                     <h3>Login In</h3>
                     <form method="post" action="<?= base_url()?>">                                             
                     <div class="error"><strong><?php if ($this->session->flashdata('error') !== FALSE) { echo $this->session->flashdata('error'); } ?></strong></div>
                      <div class="form-group">                       
                       <label for="userName">Username</label> <input type="text" class="form-control" id="userName" name="userName" value="">                                              
       </div>       
       <div class="form-group">
        <label for="password"> Password </label> <input type="password" class="form-control" id="password" name="password" value="">               
       </div>
       <div class="g-recaptcha" data-sitekey="6Lf2XQoTAAAAAPEP9D7JeEf2zqZT3Pvywk_WriXE"></div>                   
                   </br>
                   <button class="btn btn-success" type="submit">Login</button>      
      </form>
     </div>
             </div>
         </div>               
     </div>
 </div>        

    <!-- jQuery -->


</body>

</html>
