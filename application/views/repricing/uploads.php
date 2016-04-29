<div class="container-fluid">     
  <div class="panel panel-default">
    <div class="panel-heading">
      <h2 class="panel-title"><b>Manage</b></h2>
    </div>  
    <br/>
    <div class="row">
      <div class="col-md-2">
        <ul class="nav nav-pills nav-stacked">
          <li><a  href="<?php echo base_url('content/strategies');?>" >Strategies</a></li>
          <li><a  href="<?php echo base_url("content/marketplaces");?>">Marketplaces</a></li>
          <li class="active"><a  href="<?php echo base_url("content/uploads");?>" >Uploads</a></li>
          <li><a  href="<?php echo base_url("content/settings");?>">Settings</a></li>
        </ul>
      </div>
      <div class="col-md-9">
        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="row">
              <div class="col-md-9">
                <h3 class="panel-title">Uploads Status</h3>
              </div>
              <div class="col-md-3">
                <div class="pull-right">
                  <!-- <span class="glyphicon glyphicon-download-alt"></span>    -->
                </div>
              </div>
            </div>
          </div>
          <div class="panel-body">
            <div class="row-fluid">
              <div class="col-xs-12 col-md-12">
<div class="alert alert-info empty-states" role="alert"><span class="glyphicon glyphicon-warning-sign"></span>You haven’t uploaded any files yet.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
