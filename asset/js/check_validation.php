<script language="javascript" type="text/javascript">
function checkcurrent_password(){
	if(!document.getElementById('current_password').value){
	//alert('Username can not be blank!');
	document.getElementById('msbox').innerHTML="Current password can not be blank!";
	}else{
		var current_password = document.getElementById('current_password').value;
		var params	= 'current_password='+current_password;
		$.ajax({type: "get",url:"<?php echo site_url();?>admin/admin/changepassword",data: params,success: oncheckcurrent_password});
	}
}
function oncheckcurrent_password(res)
{
   if(res==1)
   {
	   userFlag = 1; 
	   document.getElementById('msbox').innerHTML=" ";
	   //alert("This Username is not available");
   }
   else
   {
	   userFlag = 0; 
	   document.getElementById('msbox').innerHTML="<font style=color:#FF0000;>This Username is not available!</font>";
	   //alert("This Username is not available");
   }
}

function validate()
 {
      if(!document.getElementById('txtusername').value)
      {
		//document.getElementById('msbox').innerHTML='E-mail should be as: example@yourschool.com!';
		//alert("Username Can not Be Blank!");
      	document.getElementById('msbox').innerHTML="<font style=color:#FF0000;>Username can not be blank!</font>";
		document.getElementById('txtusername').focus();
      	return false;     
      }
	  if(!document.getElementById('txtemail').value.match(RE_EMAIL))
      {
		//document.getElementById('msbox').innerHTML='E-mail should be as: example@yourschool.com!';
		//alert("E-mail should be as: example@yourschool.com!");
		document.getElementById('msbox').innerHTML="<font style=color:#FF0000;>E-mail should be as: example@yourschool.com!</font>";
      	document.getElementById('txtemail').focus();
      	return false;     
      }
	  if(document.getElementById('txtreemail').value!=document.getElementById('txtemail').value)
      {
		//document.getElementById('msbox').innerHTML='E-mail did not match!';	
		//alert("E-mail did not match!");	
		document.getElementById('msbox').innerHTML="<font style=color:#FF0000;>E-mail did not match!</font>";
      	document.getElementById('txtreemail').focus();
      	return false;     
      }
	  if(!document.getElementById('txtpass').value)
      {
		//document.getElementById('msbox').innerHTML='Password Can not Be Blank!';
		//alert("Password Can not Be Blank!");
		document.getElementById('msbox').innerHTML="<font style=color:#FF0000;>Password Can not Be Blank!</font>";
      	document.getElementById('txtpass').focus();
      	return false;     
      }
	  if(document.getElementById('txtpass').value!=document.getElementById('txtrepass').value)
      {
		//document.getElementById('msbox').innerHTML='Password did not match!';	
		//alert("Password did not match!");
		document.getElementById('msbox').innerHTML="<font style=color:#FF0000;>Password did not match!</font>";
      	document.getElementById('txtrepass').focus();
      	return false;     
      }
	  if(!userFlag)
	  {
		//document.getElementById('msbox').innerHTML='E-mail should be as: example@yourschool.com!';
		//alert("Username is not available!");
		document.getElementById('msbox').innerHTML="<font style=color:#FF0000;>Username is not available!</font>";
		return false;
	  }
	  if(emailFlag == 0)
	  {
		//document.getElementById('msbox').innerHTML='E-mail should be as: example@yourschool.com!';
		//alert("E-mail should be as: example@yourschool.com!");
		document.getElementById('msbox').innerHTML="<font style=color:#FF0000;>E-mail should be as: example@yourschool.com!</font>";
		return false;
	  }
	  if(emailFlag == 2)
	  {
		//document.getElementById('msbox').innerHTML='This e-mail is not available!';
		//alert("This e-mail is not available!");
		document.getElementById('msbox').innerHTML="<font style=color:#FF0000;>This e-mail is not available!</font>";
		return false;
	  }
}
</script>