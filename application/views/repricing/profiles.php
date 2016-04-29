  <div class="container-fluid">

<form class="form-horizontal" role="form" method="post" action="#" id="form_profiles">
<div class="form-group">
<p>
   <label for="text" class="col-sm-2">
  <h1>  Account Info </h1>

  </label>
</p>
  <hr style="height:1px;border:none;color:#333;background-color:#333;"/>
</div> 
<div class="form-group">
  <label for="name" class="col-sm-2 control-label">Name</label>
  <div class="col-sm-4">
    <!--<input type="text" class="form-control" id="name" name="name" placeholder="First & Last Name" value="<?php 
//echo explode("@",$user_profiles['email'])[0]; ?>"
required >-->
    <input type="text" class="form-control" id="name" name="name" placeholder="First & Last Name" value="<?php echo htmlspecialchars($user_profiles['name']); ?>" required >
    <?php echo "<p class='text-danger'>".(isset($errName)?$errName:'')."</p>";?>
  </div>
</div>
<div class="form-group">
  <label for="email" class="col-sm-2 control-label">Email</label>
  <div class="col-sm-4">
    <input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" value="<?php echo htmlspecialchars($user_profiles['email']); ?>" required readonly>
    <?php echo "<p class='text-danger'>".(isset($errEmail)?$errEmail:'')."</p>";?>
  </div>
</div>
               <div class="form-group">
  <label for="email" class="col-sm-2 control-label">password</label>
  <div class="col-sm-4">
    <input type="password" class="form-control" id="mypassword" name="password" placeholder="we will not display password here" value="static" required>
    <?php echo "<p class='text-danger'>".(isset($errEmail)?$errEmail:'')."</p>";?>
  </div>
</div>          
<div class="form-group">
  <label for="human" class="col-sm-2 control-label">Confirm password</label>
  <div class="col-sm-4">
    <input type="password" class="form-control" id="mycpassword" name="cpassword" placeholder="we will not display password here" value="static" required>
    <?php echo "<p class='text-danger'>".(isset($errHuman)?$errHuman:'')."</p>";?>
  </div>
</div>
<div class="form-group">
  <p>  <label for="text" class="col-sm-2">
<h1>   Company Info
</h1>

  </label>
  </p>        
  <hr style="height:1px;border:none;color:#333;background-color:#333;" />
</div>
<div class="form-group">
  <label for="human" class="col-sm-2 control-label">Company name  : (Optional)</label>
  <div class="col-sm-4">
  <input type="name" class="form-control" id="human" name="companyname" placeholder="Your Answer" value="<?php echo isset($user_profiles['companyname'])?$user_profiles['companyname']:'none'?>">
    <?php echo "<p class='text-danger'>".(isset($errHuman)?$errHuman:'')."</p>";?>
  </div>
</div>        
 <div class="form-group">
  <label for="human" class="col-sm-2 control-label">Phone Number  : (Optional)</label>
  <div class="col-sm-4">
  <input type="text" class="form-control" id="human" name="phone" placeholder="Your Answer" value="<?php echo isset($user_profiles['phone'])?$user_profiles['phone']:'none'?>">
    <?php echo "<p class='text-danger'>".(isset($errHuman)?$errHuman:'')."</p>";?>
  </div>
</div>                            
<div class="form-group pull-right">
  <div class="col-sm-4 col-sm-offset-0">
    <input id="submit_profiles" name="submit" type="submit" value="Save Changes" class="btn btn-primary">
  </div>
</div>
<div class="form-group">
  <div class="col-sm-4 col-sm-offset-2">
    <?php echo isset($result)?$result:''; ?>    
  </div>
</div>

                                                                                                                                                                          </form>
</div>
