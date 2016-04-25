<div class="container-fluid">     
  <div class="panel panel-default">
    <div class="panel-heading">
      <h2 class="panel-title"><b>Manage</b></h2>
    </div>  
    <br/>
    <div class="row">
      <div class="col-md-2">
        <ul class="nav nav-pills nav-stacked">
          <li class="active"><a href="<?php echo base_url("content/profiles");?>" >Profile</a></li>
          <li><a href="<?php echo base_url("content/subscriptions");?>">Subscription</a></li>
          <li><a href="<?php echo base_url("content/addons");?>" >Addons</a></li>
        </ul>
      </div>
      <div class="col-md-9">
        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="row">
              <div class="col-md-9">
                <h3 class="panel-title">Account info</h3>
              </div>
              <div class="col-md-3">
                <div class="pull-right">
                  <!-- <span class="glyphicon glyphicon-download-alt"></span>    -->
                </div>
              </div>
            </div>
          </div>
          <div class="panel-body">
            <h3>Account Info</h3>
            <hr />       
            <form role="form">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" class="form-control" id="email">
                  </div>
                </div>   
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="email">Time Zone:</label>
                    <input type="email" class="form-control" id="email">
                  </div>
                </div> 
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" id="pwd">
                    <p class="help-block">6 characters or long</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="pwd">Confirm Password:</label>
                    <input type="password" class="form-control" id="pwd">
                  </div>
                </div>
              </div>
              <br/>
              <br/>
              <br/>
              <h3>Company Info</h3>
              <hr />         
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="pwd">First Name:</label>
                    <input type="password" class="form-control" id="pwd">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="pwd">Last Name:</label>
                    <input type="password" class="form-control" id="pwd">
                  </div>
                </div>
              </div>            
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="pwd">Company Name:</label>
                    <input type="password" class="form-control" id="pwd">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="pwd">VAT Number:</label>
                    <input type="password" class="form-control" id="pwd">
                  </div>
                </div>
              </div>         
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="pwd">Street Address:</label>
                    <input type="password" class="form-control" id="pwd">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="pwd">Apartment:</label>
                    <input type="password" class="form-control" id="pwd">
                  </div>
                </div>
              </div>                  
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="pwd">City:</label>
                    <input type="password" class="form-control" id="pwd">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="pwd">State:</label>
                    <input type="password" class="form-control" id="pwd">
                  </div>
                </div>
              </div>                
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="pwd">Country:</label>
                    <input type="password" class="form-control" id="pwd">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="pwd">Postal Code</label>
                    <input type="password" class="form-control" id="pwd">
                  </div>
                </div>
              </div>                        
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="pwd">Phone:</label>
                    <input type="password" class="form-control" id="pwd">
                  </div>
                </div>
              </div> 
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
<button type="submit" class="btn btn-lg btn-primary pull-right">Save Changes</button>
                  </div>
                </div>
              </div>                                                                                                                      
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
