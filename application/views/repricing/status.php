<?php include_once('header.php'); ?>
<?php include_once('nav-inner-admin.php'); ?>
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="//bootswatch.com/yeti/bootstrap.min.css" rel="stylesheet" type="text/css" />
<div class="container">
  <div class="well">
      <div class="row">
        <div class="col-md-12">
          <h1>Status Page</h1>
        </div>
      </div>
      <div class="row clearfix">
        <div class="col-md-12 column">
          <div class="panel panel-success">
            <div class="panel-heading">
              <h3 class="panel-title">
                All Systems Operational
                <small class="pull-right">Refreshed 39 minutes ago</small>
              </h3>
            </div>                
          </div>


          <div class="row clearfix">
            <div class="col-md-12 column">
              <div class="list-group">

                <div class="list-group-item">
                  <h4 class="list-group-item-heading">
                    Website and API 
                    <a href="#"  data-toggle="tooltip" data-placement="bottom" title="Access website and use site API">
                      <i class="fa fa-question-circle"></i>
                    </a>
                  </h4>
                  <p class="list-group-item-text">
                  <span class="label label-success">Operational</span>
                  </p>
                </div>

                <div class="list-group-item">
                  <h4 class="list-group-item-heading">
                    SSH 
                    <a href="#"  data-toggle="tooltip" data-placement="bottom" title="Access site using SSH terminal">
                      <i class="fa fa-question-circle"></i>
                    </a>
                  </h4>
                  <p class="list-group-item-text">
                  <span class="label label-success">Operational</span>
                  </p>
                </div>

                <div class="list-group-item">
                  <h4 class="list-group-item-heading">
                    Database Server 
                    <a href="#"  data-toggle="tooltip" data-placement="bottom" title="Access database server and execute queries">
                      <i class="fa fa-question-circle"></i>
                    </a>
                  </h4>
                  <p class="list-group-item-text">
                  <span class="label label-success">Operational</span>
                  </p>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>


<?php include_once('footer.php'); ?>
