<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--<meta name="description" content="Legend Repricing is a competitive amazon repricer software that helps third party amazon merchants increase their sales and profits by automatically repricing amazon inventory.">
<meta name="author" content="">-->
<!-- Search engines -->
<meta name="description" content="Legendrepricing.com Amazon Repricer Legend Repricing is an amazon repricer software that helps third party amazon merchants increase their sales and profits by automatically repricing their inventory">
<!-- Google Plus -->
<!-- Update your html tag to include the itemscope and itemtype
     attributes. -->
<!-- html itemscope itemtype="http://schema.org/{CONTENT_TYPE}" -->
<meta itemprop="name" content="Legendrepricing.com Amazon Repricer">
<meta itemprop="description" content="Legendrepricing.com Amazon Repricer Legend Repricing is an amazon repricer software that helps third party amazon merchants increase their sales and profits by automatically repricing their inventory">
<meta itemprop="image" content="https://legendrepricing.com/asset/images_d/logo-legendRepricing.png">
<!-- Twitter -->
<meta name="twitter:card" content="Legendrepricing.com">
<meta name="twitter:site" content="@legendrepricing">
<meta name="twitter:title" content="Legendrepricing.com Amazon Repricer">
<meta name="twitter:description" content="Legendrepricing.com Amazon Repricer Legend Repricing is an amazon repricer software that helps third party amazon merchants increase their sales and profits by automatically repricing their inventory">
<meta name="twitter:creator" content="@legendrepricing">
<meta name="twitter:image:src" content="https://legendrepricing.com/asset/images_d/logo-legendRepricing.png">
<meta name="twitter:player" content="">
<!-- Open Graph General (Facebook & Pinterest) -->
<meta property="og:url" content="https://www.legendrepricing.com">
<meta property="og:title" content="Legendrepricing.com Amazon Repricer">
<meta property="og:description" content="Legendrepricing.com Amazon Repricer Legend Repricing is an amazon repricer software that helps third party amazon merchants increase their sales and profits by automatically repricing their inventory">
 <meta property="og:site_name" content="Legend Repricing Amazon Repricer">
<meta property="og:image" content="https://legendrepricing.com/asset/images_d/logo-legendRepricing.png">
<meta property="fb:admins" content="vmavani">
<meta property="fb:app_id" content="442670775936840">
<meta property="og:type" content="article">
<meta property="og:locale" content="en_US">
<meta property="og:audio" content="">
<meta property="og:video" content="">
<!-- Open Graph Article (Facebook & Pinterest) -->
<!--
<meta property="article:author" content="legendrepricing.com">
<meta property="article:section" content="Technology">
<meta property="article:tag" content="article">
<meta property="article:published_time" content="">
<meta property="article:modified_time" content="">
<meta property="article:expiration_time" content="">  -->
<title>Legend Repricing</title>
<link href="<?=base_url();?>asset/css_d/default.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="javascript" src="<?=base_url();?>asset/js_d/jquery.min.js"></script>
<!--<script type="text/javascript"> //<![CDATA[ 
var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.comodo.com/" : "http://www.trustlogo.com/");
document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
//]]>
</script>   -->
<script src="<?=base_url();?>asset/js_d/toastr.js"></script>    
<link href="<?=base_url();?>asset/css_d/toastr.css" rel="stylesheet">   
</head>
<script>
//shortcut for $(document).ready
$(function(){
  if(window.location.hash) {
    var hash = window.location.hash;
//    alert(hash);
    $(hash).modal('toggle');
  }
});
</script>
<script>
function isValidEmailAddress(emailAddress) {
  var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
  return pattern.test(emailAddress);
};

jQuery(document).ready(function() {        

  $(document).on('click', function(e) {

    //clear 
    toastr.clear();
  });


  toastr.options = {
    "closeButton": true,
      "debug": false,
      "newestOnTop": true,
      "progressBar": false,
      "positionClass": "toast-top-center",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "3000",
      "hideDuration": "1000",
      "timeOut": "0",
      "extendedTimeOut": "0",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
  }
  $(document).on('click','#signup_settings',function(e){
    e.stopPropagation();
    e.preventDefault();
    var pass=$('#signuppass').val();
    var email=$('#signupemail').val();
    if( !isValidEmailAddress( email ) )
    {
      toastr.error("Invalid email address");
      return;
    }
    if(!pass.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/))
    {
      toastr.error("Password must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters");
    }
    else
    {          
      var datastring = $("#signup_form").serialize();
    {                   
      //      $('#loading').show();
      $.ajax({
        url: "<?= site_url('signup');?>",
          type: "POST",
          data: datastring,
          cache :false,
          success : function(response) {
            if(response.match(/Success/))
            {
              $('#myModalSignupfree').modal('hide');
              toastr.options.positionClass='toast-top-full-width';
              toastr.success('You have successfully started your sign up to Legend Pricing, please check your email for further details and steps');
            }
            else
            {
                toastr.error(response);
            }
          }
      });
      //    $('#loading').hide();
    }
    }
  }); 
  $(document).on('click','#login_settings',function(e){
    e.stopPropagation();
    e.preventDefault();      
    var email=$('#username').val();
    var pass=$('#password').val();
    if( !isValidEmailAddress( email ) )
    {
      toastr.error("Invalid email address");
      return;
    }
    if(!pass.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/))
    {
  //    toastr.error("Password must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters");
    //  return;
    }                            
    {          
      var datastring = $("#login_form").serialize();
    {                   
      //      $('#loading').show();
      $.ajax({
        url: "<?= site_url('login');?>",
          type: "POST",
          data: datastring,
          cache :false,
          success : function(response) {
            if(response.match(/Success/))
            {
              var newdata = "<?php echo site_url('content');?>";
              window.location.assign(newdata);
            }
            else
            {
            toastr.error(response);
            }
          }
      });
      //    $('#loading').hide();
    }
    }
  });    
  $(document).on('click','#feedback_button',function(e){
    e.stopPropagation();
    e.preventDefault();      
    var email=$('#feedback_email').val();
    if( !isValidEmailAddress( email ) )
    {
      toastr.error("Invalid email address");
      return;
    }
    {          
      var datastring = $("#feedback_form").serialize();
    {                   
      //      $('#loading').show();
      $.ajax({
        url: "<?= site_url('home/feedback');?>",
          type: "POST",
          data: datastring,
          cache :false,
          success : function(response) {
            if(response.match(/success/))
            {
              toastr.success('Thank You!!');
            }
            else
            {
              toastr.error('Please try after some time..');
            }
          }
      });
      //    $('#loading').hide();
    }
    }
  });    
  $(document).on('click','#send_reset',function(e){
      var me = $(this);
    e.stopPropagation();
    e.preventDefault();      

        if ( me.data('requestRunning') ) {
                  return;
                      }

     me.data('requestRunning', true);
    var email=$('#emailInput').val();
    if( !isValidEmailAddress( email ) )
    {
      toastr.error("Invalid email address");
                         me.data('requestRunning', false);
      return;
    }
    var pass1 = $("#npassword").val();   
    if(!pass1.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/))
    {
      toastr.error("Password must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters");
                         me.data('requestRunning', false);
      return false;
    }               
    var pass2 = $("#cpassword").val();
    if (pass1 != pass2)
    {
      alert("Passwords do not match");
                         me.data('requestRunning', false);
      return false;
    }
    else
    {
    //  $( "#reset" ).submit();
    }
    {          
      var datastring = $("#reset_password").serialize();
    {                   
      //      $('#loading').show();
      $.ajax({
        url: "<?= site_url('home/sendMail_reset');?>",
          type: "POST",
          data: datastring,
          cache :false,
          success : function(response) {
            if(response.match(/successfully/))
            {
              toastr.success('Succesfully updated .');
             //    $('#send_reset').attr('value','Please check your email');
                 $('#send_reset').attr('disabled','disabled');
              var newurl="<?php echo base_url('#myModal');?>";
              window.location.assign(newurl);
            }
            else
            {
            //  toastr.error('Failed to update the password ..');
              toastr.error(response);
            }
          },
           complete: function() {
                         me.data('requestRunning', false);
                                 }
      });
      //    $('#loading').hide();
    }
    }
  });                             
  $(document).on('click','#send_forgot',function(e){
     var me = $(this);
    e.stopPropagation();
    e.preventDefault();      

        if ( me.data('requestRunning') ) {
                  return;
                      }

        me.data('requestRunning', true);

    var email=$('#emailInput').val();
    if( !isValidEmailAddress( email ) )
    {
      toastr.error("Invalid email address");
                         me.data('requestRunning', false);
      return;
    }
    {          
      var datastring = $("#forgot_password").serialize();
    {                   
      //      $('#loading').show();
      $.ajax({
        url: "<?= site_url('home/sendMail_forgot');?>",
          type: "POST",
          data: {email:email},
          cache :false,
          success : function(response) {
            if(response.match(/successfully/))
            {
              toastr.success('Succesfully updated .Please check your email');
                 $('#send_forgot').attr('value','Please check your email');
                 $('#send_forgot').attr('disabled','disabled');
            }
            else
            {
              toastr.error('Failed to update the password ..');
            }
          },
         complete: function() {
                       me.data('requestRunning', false);
                               }
      });
      //    $('#loading').hide();
    }
    }
  });                                                                              
  // $('#myTable').dataTable({  "iDisplayLength": 25, responsive: true});
});
</script>

