<?php include_once('header.php'); ?>
<?php include_once('nav-inner-admin.php'); ?>

<style type="text/css">
.row {
    margin-left: -15px;
    margin-right: -15px;
}
.col-lg-12 {
    width: 100%;
}
.dashboard-element {
    background-color: #ffffff;
   
    color: #474e5d;
    
    text-align: left;
}
.dashboard-element .nav-tabs {
    background-color: #f7f7f7;
    border-radius: 5px 5px 0 0;
    text-align: center;
}
.nav-tabs {
    border-bottom: 1px solid #dddddd;
}
.nav {
    list-style: outside none none;
    margin-bottom: 0;
    padding-left: 0;
}
.dashboard-element .nav-tabs{ padding:0px;}
.dashboard-element .nav-tabs > li {
    display: inline-block;
    float: none;
}

.dashboard-element .nav-tabs > li a {  border-radius:0;}
.dashboard-element .nav-tabs {
    text-align: center;
}

.element-data {
    text-align: center;
}

audio, canvas, progress, video {
    display: inline-block;
    vertical-align: baseline;
}
.jqplot-xaxis {
    margin-top: 10px;
}
.jqplot-axis {
    font-size: 0.75em;
}

.jqplot-target {
    color: #666666;
    font-family: "Trebuchet MS",Arial,Helvetica,sans-serif;
    font-size: 1em;
    position: relative;
}
.element-chart {
    display: block;
    float: right;
    height: 145px;
    margin-left: 10px;
    position: relative;
}

.dashboard-element {
    color: #474e5d;
    text-align: left;
}

.tab-content > .active {
    display: block;
    visibility: visible;
}

.element-data-message {
    color: #777777;
    font-weight: normal;
    min-height: 247px;
    padding: 113px 0;
    text-align: center;
    white-space: normal;
}

.element-header {
    background: #f7f7f7 none repeat scroll 0 0;
    border-bottom: 1px solid #d6d9e1;
    border-radius: 5px 5px 0 0;
    padding: 10px 13px;
}

.element-header-title {
    color: #474e5d;
    font-size: 16px;
    font-weight: bold;
}
.element-data {
    margin: 0 auto;
    padding: 30px 0 0;
    text-align: center;
}
.element-data-number {
    font-size: 40px;
    font-weight: bold;
	line-height: 1.42857; font-family:Arial, Helvetica, sans-serif;
}

.col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12 {
    float: left;
}
.dashboard-settings .settings-links-grid {
    padding: 21px 15px;
}

 .dashboard-settings .settings-links-grid {
    float: left;
    width: 33.3333%;
}

 .dashboard-settings .element-data-container .settings-links-container .btn {
    display: inline-block;
    height: 150px;
    margin: 30px 0;
    padding: 65px 0;
    width: 150px;
}
.dashboard-settings .settings-links-grid {
    min-height: 1px;
    padding: 15px 30px;
    position: relative;
    text-align: center;
}

.btn-default:hover, .btn-default:focus, .btn-default.focus, .btn-default:active, .btn-default.active, .open > .dropdown-toggle.btn-default {
    background-color: #e6e6e6;
    border-color: #adadad;
    color: #333333;
}

 .dashboard-settings .element-data-container .settings-links-container .btn {
    border-radius: 100px;}
	
.btn-default {
    background-color: #ffffff;
    border-color: #cccccc;
    color: #333333;
}	
.element-data-container{  height:298px; position:relative}
.element-data-container  ul {  position:absolute; bottom:0;}
.element-data-container{  height:298px; position:relative}
.element-data-container .position-bottom {  position:absolute; bottom:0;}
.element-data-container .position-bottom ul {  padding:0px; width:100%; text-align:center; border-top:1px solid #eee;}
.element-data-container .position-bottom ul li {  list-style:none; display:inline-block; padding:0 2%; font-size:10px; }
.small-element {
    border-radius: 5px;
    margin-bottom: 15px;
    min-height: 185px;
}
.element-data-small {
    margin: 42px 0;
    text-align: center;
}
.element-data-small-number {
    font-size: 25px;
    font-weight: bold;
}
.element-data-small {
    text-align: center;
}
.element-listing-views ul {
    list-style: outside none none;
    margin-bottom: 0;
    margin-left: 0;
    padding: 0 13px;
}
.element-listing-views ul li {
    padding-top: 10px;
}
.element-listing-views-label {
    font-weight: normal;
}

</style>

<article>
	<div class="container">
		<h1>Dashboard</h1>
		<div class="crow">
			<div class="content chartContainer">
				<div class="row">
        <div class="col-lg-12">
            <div class="dashboard-element large-element">
                <ul id="graphTabs" role="tablist" class="nav nav-tabs">
                    
                    <li class="active" id="DashboardPlaceHolder_GraphSalesTab"><a data-toggle="tab" role="tab" href=".graph_pane_sales">
                        Sales Volume
</a></li>
                </ul>
                <div class="tab-content">
                    <div id="graph_pane_buybox" class="tab-pane active">
                        
                    </div>

                    <div class="tab-pane graph_pane_sales active" id="DashboardPlaceHolder_graph_pane_sales">
                        <div id="DashboardPlaceHolder_SalesPanel">
	
                            

                            <div class="element-data-message" id="DashboardPlaceHolder_divSalesMsg">
                                No sales data available.

                            </div>
                        
</div>
                    </div>
                </div>
            </div>



        </div>
    </div>
			</div>
		</div>
		<div class="crow">
			
            <div class="content box-graph">
				<div class="element-data-container">

                    <div class="element-header">
                        <div class="element-header-title">
                            Repricing Overview
                        </div>
                    </div>

                    <div id="DashboardPlaceHolder_RepricingPanel">
	

                        <!-- Loading Div -->
                        
                        <!-- End Loading Div -->

                        <div class="divRepricingOverview-Content" id="divRepricingOverview-Content">
                            <div class="row" >

                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="element-data">
                                        <div class="element-data-number">
                                        <span class="lblBuyBoxPercentage" id="DashboardPlaceHolder_lblBuyBoxPercentage"><?php echo $downership;?></span>

                                        </div>
                                        <div class="element-data-label">
                                            Buy Box Ownership

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="element-data">
                                        <div class="element-data-number">
                                            <span class="lblReprice" id="DashboardPlaceHolder_lblReprice">0</span>
                                        </div>
                                        <div class="element-data-label">
                                            Price Changes

                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 position-bottom">
                                     <ul>
                                       <li>11 AM </li>
                                       <li>12 AM </li>
                                       <li>1 AM </li>
                                       <li>2 AM </li>
                                       <li>3 AM </li>
                                       <li>4 AM </li>
                                       <li>5 AM </li>
                                       <li>6 AM </li>
                                       <li>7 AM </li>
                                       <li>8 AM </li>
                                       <li>9 AM </li>
                                     </ul>
                                </div>

                            </div>
                        </div>

                    
</div>

                    
                </div>
			</div>
			
            
            
            <div class="content box-graph">
				<div class="dashboard-settings">
            <div class="dashboard-element large-element settings-links">
                <div class="element-data-container">
                    <div class="element-header">
                        <div class="element-header-title">
                            Manage

                        </div>
                    </div>
                    <div class="settings-links-container">
                        <div class="row">
                            <div class="settings-links-grid">
                                <a href="#"><div class="btn btn-default btn-block">Strategies</div></a>
                            </div>
                            <div class="settings-links-grid">
                                <a href="#"><div class="btn btn-default btn-block">Uploads</div></a>
                            </div>
                            <div class="settings-links-grid">
                                <a href="#"><div class="btn btn-default btn-block">Marketplaces</div></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
			</div>
		</div>
      
		<div class="row">
          <div class="crow">
        

        <div class=" col-lg-4 ">
            <div class="content">
            <div id="listing_counts_container" class="dashboard-element small-element">
                <div class="element-header">
                    <div class="element-header-title">
                        Listing Counts

                    </div>
                </div>
                <!-- Loading Div -->
                
                <!-- End Loading Div -->
                <div class="divListingCounts-Content" id="divListingCounts-Content">
                    <div class="row">

                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="element-data-small">
                                <div class="element-data-small-number">
                                <span class="lblLiveListings" id="DashboardPlaceHolder_lblLiveListings"><?php echo $dactive.' / '.$dtotal;?></span>
                                </div>
                                <div class="element-data-small-label">
                                    <div>Live / Total</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="element-data-small">
                                <div class="element-data-small-number">
                                <span class="lblManagedListings" id="DashboardPlaceHolder_lblManagedListings"><?php echo $dactive;?> / Unlimited</span>
                                </div>
                                <div class="element-data-small-label">
                                    <div>Active / Limit</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            </div>
        </div>
     
        <div class="col-lg-4 ">
           <div class="content">
            <div class="dashboard-element small-element">

                <div class="element-header">
                    <div class="element-header-title">
                        Subscription Details

                        
                    </div>
                </div>

                <div class="element-listing-views">
                    <ul>
                        <span id="DashboardPlaceHolder_lblSubscriptionContent"><li><span class="element-listing-views-label">Plan:</span>
 <strong>Pro Plan ,Unlimited listings</strong></li><li><span class="element-listing-views-label">Rate:</span> <strong>Full 3 month free trial</strong></li>
<li><span class="element-listing-views-label">Next Billing Date:</span>
<!-- <strong>12/30/2015</strong>-->
</li></span>
                        <li></li>
                    </ul>
                </div>

            </div>
            </div>
        </div>

        <div class="col-lg-4 ">
         <div class="content">
            <div id="listing_views_container" class="dashboard-element small-element">
                <div class="element-header">
                    <div class="element-header-title">
                        Listing Views

                    </div>
                </div>
                <div class="element-listing-views">

                    <!-- Loading Div -->
                    
                    <!-- End Loading Div -->

                    <div class="divListingViews-Content">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <ul>
                                  <!--  <span class="lbllvLeft" id="DashboardPlaceHolder_lbllvLeft"><li><a href="listings?filter=1">Inactive <strong>(5)</strong></a></li><li><a href="listings?filter=12">Non Buy Boxes <strong>(8)</strong></a></li><li><a href="listings?filter=15">No Min Price <strong>(8)</strong></a></li><li><a href="listings?filter=10">Manual Prices <strong>(1)</strong></a></li></span> -->
                                  <span class="lbllvLeft" id="DashboardPlaceHolder_lbllvLeft"><li><a href="#">Inactive <strong>(<?php echo $dinactive;?>)</strong></a></li><li><a href="#">Non Buy Boxes <strong>(<?php echo $dnobb;?>)</strong></a></li><li><a href="#">No Min Price <strong>(<?php echo $dnomin;?>)</strong></a></li>
<!--<li><a href="#">Manual Prices <strong>(1)</strong></a></li>-->
</span>
                                </ul>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <ul>
                                    <span class="lbllvRight" id="DashboardPlaceHolder_lbllvRight"></span>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </div></div>
	</div>
</article>
<script language="javascript" type="text/javascript" src="<?=base_url();?>/asset/js_d/chart/chart.min.js"></script> 
<script language="javascript" type="text/javascript" src="<?=base_url();?>/asset/js_d/chart/knockout-3.0.0.js"></script> 
<script language="javascript" type="text/javascript" src="<?=base_url();?>/asset/js_d/chart/globalize.min.js"></script> 
<script language="javascript" type="text/javascript" src="<?=base_url();?>/asset/js_d/chart/dx.chartjs.js"></script> 
<script language="javascript" type="text/javascript">
	var barChartData = {
		labels : ["January","February","March","April","May","June","July"],
		datasets : [
			{
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,1)",
				data : [65,59,90,81,56,55,40]
			},
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,1)",
				data : [28,48,40,19,96,27,100]
			}
			]
		}
	var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Bar(barChartData);
	var myLine = new Chart(document.getElementById("canvas-1").getContext("2d")).Bar(barChartData);
	
	$(function ()  
				{
   var dataSource = [
  { state: "China", oil: 4.95, gas: 2.85, coal: 45.56 },
  { state: "Russia", oil: 12.94, gas: 17.66, coal: 4.13 },
  { state: "USA", oil: 8.51, gas: 19.87, coal: 15.84 },
  { state: "Iran", oil: 5.3, gas: 4.39 },
  { state: "Canada", oil: 4.08, gas: 5.4 },
  { state: "Saudi Arabia", oil: 12.03 },
  { state: "Mexico", oil: 3.86 }
];
$("#chartContainer").dxChart({
    equalBarWidth: false,
    dataSource: dataSource,
    commonSeriesSettings: {
        argumentField: "state",
        type: "bar"
    },
    series: [
        { valueField: "oil", name: "Oil Production" },
        { valueField: "gas", name: "Gas Production" },
        { valueField: "coal", name: "Coal Production" }
    ],
    legend: {
        verticalAlignment: "bottom",
        horizontalAlignment: "center"
    },
    //title: "Percent of Total Energy Production"
});
}

			);
</script>
<?php include_once('footer.php'); ?>
