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
          <p><strong> A verification link will be sent to your email adddress</strong></p>
<?php echo $widget;?>
<?php echo $script;?>
        </div>
        <div class="modal-footer">
          <a href="#" data-dismiss="modal" class="btn"><span class="glyphicon glyphicon-remove"></span> Close</a>
          <button id="signup_settings" type="submit" class="btn"><span class="glyphicon glyphicon-off"></span> Signup</button>
        </div>
      </form>
    </div>
  </div>
</div>   
         
