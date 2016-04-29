
<div class="container-fluid">
  <p>  <label for="text" class="col-sm-2 control-label">
   Confirmation Payment  Info

  </label>
  </p>
  <hr style="height:1px;border:none;color:#333;background-color:#333;">


  <div class="row">
    <div class="col-md-12">
    <form class="form-horizontal" role="form" method="post" id="form_settings" action="<?php echo base_url('mypaypal/recurring_payment');?>">
        <div class="form-group">

          <label for="inputsellerid" class="col-sm-2 control-label">
            Name
          </label>
          <div class="col-sm-4">
          <input name="name" type="text" class="form-control" id="inputsellerid" value="<?php echo isset($paypal_settings['name'])?$paypal_settings['name']:'none' ?>" readonly/>
          </div>
        </div>
        <div class="form-group">

          <label for="inputmpi" class="col-sm-2 control-label">
            Email
          </label>
          <div class="col-sm-4">
          <input type="email" name="email" class="form-control" id="inputmpid" value="<?php echo  isset($paypal_settings['email'])?$paypal_settings['email']:'none'?>" readonly/>
          </div>
        </div>           

        <hr style="height:1px;border:none;color:#333;background-color:#333;" />

        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">

            <button id="submit_review" type="submit" class="btn btn-primary btn-lg pull-right">
              Confirm Changes
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
