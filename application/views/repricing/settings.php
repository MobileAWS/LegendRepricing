<style>
table{width:100%}

</style>

<?php include_once('header.php'); ?>
<?php include_once('nav-inner-admin.php'); ?>
<br />
<br />
<br />
<div class="container">

  <div class="panel panel-default">
    <div class="panel-heading">
      <p>  <label for="text" class="col-sm-2 control-label">
        <h1>  Add/Update Amazon Accounts
  <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo">Add more</button>
        </h1>

      </label>
      </p>
    </div>
<div id="demo" class="collapse">
    <div class="well well-lg">
      <p><strong>Important:</strong> Please use the following instructions to integrate Legend Repricing with your Amazon seller account.</p>
      <ul>
        <li>
        <div>1. Click here to sign up for Amazon MWS: <a href="https://sellercentral.amazon.com/gp/mws/registration/register.html?*Version*=1&amp;*entries*=0&amp;ie=UTF8&amp;signInPageDisplayed=1&amp;" target="_blank">Amazon Seller Central</a></div>
        </li>
        <li>2. Select <strong>&ldquo;I want to use an application to access my Amazon seller account with MWS&rdquo;</strong> and enter the following information:
        <ul>
          <li>Application Name:&nbsp;legend repricing</li>
          <li>Developer Account Number:&nbsp;191298344797</li>
        </ul>
        </li>
        <li>3. Enter your information in the fields below.</li>
      </ul>
    </div>


    <div class="panel-body">
      <div class="row">
        <div class="col-md-12">
          <form class="form-horizontal" role="form" id="form_settings" action="" autocomplete="off">
            <div class="form-group">

              <label for="inputsellerid" class="col-sm-2 control-label">
                Seller id *
              </label>
              <div class="col-sm-4">
                <input maxlength="30" name="sellerid" type="text" class="form-control" title="14 characters" id="inputsellerid" value="" />
              </div>
            </div>                                    
            <div class="form-group">

              <label for="inputnickname" class="col-sm-2 control-label">
                Seller Nick Name*
              </label>
              <div class="col-sm-4">
                <input  maxlength="64" name="nickname" type="text" class="form-control" title="any nickname used to identify yourself" id="inputnickname" value="" />
              </div>
            </div>                                      
            <div class="form-group">

              <label for="inputmpi" class="col-sm-2 control-label">
                Market place *
              </label>
              <div class="col-sm-4">
                <input style="display:none;" type="text" name="somefakename" />
                <input style="display:none;" type="password" name="anotherfakename" />
                <!--     <input name="marketplaceid" type="text" class="form-control" title="13 characters" id="inputmpid" value="" autocomplete="off"  />        -->
                <select class="form-control" name="marketplaceid" id="inputmpid">
                  <option value='ATVPDKIKX0DER' selected  >Amazon.com</option>
                  <option value='A2EUQ1WTGCTBG2'  >Amazon.ca</option>
                  <option value='A1AM78C64UM0Y8' disabled >Amazon.com.mx</option>
                </select>                                                                             
              </div>
            </div>           
            <div class="form-group">

              <label for="inputoken" class="col-sm-2 control-label">
                MWs auth token *
              </label>
              <div class="col-sm-4">
                <input maxlength="50"  type="password" name="mwsauthtoken" class="form-control" title="45 characters" id="inputmwstoken" value="" autocomplete="off"  />                       
              </div>
            </div> 
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">
                GLOBAL BEAT SETTING (GBS)
              </label>
              <div class="col-sm-2 col-xs-2">     
                <select class="form-control" name="gbs" id="gbs">
                  <option value='formula' selected  >Formula</option>
                  <option value='beatby'  >beatby</option>
                  <option value='beatmeby'>beatmeby</option>
                  <option value='matchprice' >matchprice</option>
                </select>                            
              </div>
              <div class="col-sm-2 col-xs-2">     
                <input type="text" disabled value="Use our secret formula" name="gbs_beatby" class="form-control" id="gbs_beatby" placeholder="0.0"/>
              </div>
            </div>

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Exclude seller id : (Optional)</label>      
              <div class="col-sm-4">       
                <textarea name="exclude_seller" class="form-control" rows="3" placeholder="Enter seller ids separated by semicolon"></textarea> </div>
            </div>

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Include seller id : (Optional)</label>
              <div class="col-sm-4">       
                <textarea class="form-control" name="include_seller" rows="3"  placeholder="Enter seller ids  separated by semicolon"></textarea>
              </div>
            </div>

            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Generate reports email (Optional)</label>
              <div class="col-sm-4">        
                <select class="form-control" name="reports" id="sel1">
                  <option value='None' >None</option>
                  <option value='hourly'>Hourly</option>
                  <option value='daily' >Daily</option>
                  <option value='monthly' >monthly</option>
                </select>
              </div>
            </div>


            <hr style="height:1px;border:none;color:#333;background-color:#333;" />

            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">

                <button id="submit_settings" type="button" class="btn btn-primary btn-lg pull-right">
                  Save Changes
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once('accounts.php'); ?>
<?php include_once('edit_settings.php'); ?>
<?php include_once('footer.php'); ?>
