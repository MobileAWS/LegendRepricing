                      
<body class="custom">
<!-- bootstrap responsive multi-level dropdown menu -->
<!-- global errors -->
  <div class='notifications top-right'></div>
<div class="container">            
  <div class="alert alert-danger hide">
    <strong>Danger!</strong> This alert box could indicate a dangerous or potentially negative action.
  </div>
  </div>

<!-- global errors end -->
<nav class="navbar navbar-inverse" role="navigation">
  <div class="container-fluid">
    <!-- header -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#multi-level-dropdown">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?=base_url();?>"><?php echo $title;?></a>
<br/>
<br/>
<br/>
<p></p>
    </div>
    <!-- menus -->
    <div class="collapse navbar-collapse" id="multi-level-dropdown">
      <ul class="nav navbar-nav navbar-left">
      <li><a href="<?=base_url();?>content/listings">Listings</a></li>
<!--      <li><a href="<?=base_url();?>content/dashboard">Dashboard</a></li>-->
      <li><a href="<?=base_url();?>content/subscriptions">Subscriptions</a></li>
      <li><a href="<?=base_url();?>content/profiles">Profiles</a></li>
      <li><a href="<?=base_url();?>content/settings">Settings</a></li>
      <li><a href="<?=base_url();?>content/qtysync">Link eBay and Amazon FBA</a></li>
      <li><a href="<?=base_url();?>content/reports">Reports</a></li>
      <li><a href="<?=base_url();?>content/activity">Activity</a></li>
      </ul>
  <form class="navbar-form navbar-right" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search listings">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
      <li><span class="label label-primary"> Hi <?php echo $this->session->userdata('logged_in')?></span></li>
        <li><a  href="<?=base_url();?>logout">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>         
             <div class="container">            
             <img id="loading" src="<?= base_url('asset/images/ajax-loader.gif');?>" class="ajax-loader"  style="display:none" />
  </div>

     <div class="container alert " id="formAlert">
  <div class="alert alert-danger <?php if (!$this->session->flashdata('info_messages_1')){  echo 'hide';} ?> ">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong><?php  echo $this->session->flashdata('info_messages_1'); ?></strong>
  </div>
  <div class="alert alert-info <?php if (!$this->session->flashdata('info_messages_2')){  echo 'hide';} ?> ">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong><?php  echo $this->session->flashdata('info_messages_2'); ?></strong>
  </div>  
  <div class="alert alert-danger <?php if (!$this->session->flashdata('error_messages_red')){  echo 'hide';} ?> ">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong><?php  echo $this->session->flashdata('error_messages_red'); ?></strong>
  </div>      
  <div class="alert alert-info <?php if (!$this->session->flashdata('error_messages_1')){  echo 'hide';} ?> ">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong><?php  echo $this->session->flashdata('error_messages_1'); ?></strong>
  </div>          
  <div class="alert alert-info <?php if (!$this->session->flashdata('error_messages_2')){  echo 'hide';} ?> ">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong><?php  echo $this->session->flashdata('error_messages_2'); ?></strong>
  </div>            
</div>              

<!-- for flashing info messages -->
 

