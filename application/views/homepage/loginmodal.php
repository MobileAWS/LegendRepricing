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
        <p><a href="<?php echo base_url(); ?>home/forgot_pass" title="Forgot Password?" class="link-forgotPassword">Forgot Password?</a></p>
      </div>
    </div>

  </div>
</div>        
