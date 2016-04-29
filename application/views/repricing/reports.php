 
<?php include_once('header.php'); ?>
<?php include_once('nav-inner-admin.php'); ?>
<style type="text/css">
.border-buttom {  border-bottom:1px solid #eee;}
body {  font-family:Arial, Helvetica, sans-serif;}
ul#nested-master-menu li.active a, ul#nested-master-menu li a:hover {
    box-shadow: 5px 0 0 #229dd8 inset;
    color: #229dd8;
}

ul#nested-master-menu li a {
    color: #154f7d;
    display: block;
    font-family: "klavika-web","Helvetica Neue",Helvetica,Arial,sans-serif;
    font-style: normal;
    font-weight: 400;
    line-height: 0.6;
    outline: medium none;
    padding: 15px 0 15px 15px;
    text-decoration: none;
    text-transform: uppercase;
}
ul#nested-master-menu {
    list-style: outside none none;
    margin: 15px 0 0;
    padding: 0;
}
.settings-nav {
    float: left;
    width: 16.6667%;
}
.settings-content {
    float: left;
    width: 83.3333%;
}
.section-container {
    margin: 0 15px;
}
.ClearBoth {
    clear: both;
    display: block;
}
#pnlDateBar {
    font-size: 1.1em;
    margin: 10px auto 13px;
    min-width: 600px;
}
ul#activityDayRange {
    border: 1px solid #ddd;
    border-radius: 5px;
    display: inline-block;
    margin: 0;
    padding: 0;
}

ul#activityDayRange li {
    float: left;
    list-style: outside none none;
    padding-left: 0;
}

ul#activityDayRange li:first-child a {
    border-bottom-left-radius: 5px;
    border-top-left-radius: 5px;
}
ul#activityDayRange a {
    background-color: #fbfbfb;
    border-right: 1px solid #ddd;
    color: #666666;
    display: block;
    padding: 10px 20px;
    text-decoration: none;
}
ul#activityDayRange a:hover, ul#activityDayRange a.active {
    background: #f2f2f2 none repeat scroll 0 0;
}
#activityDGContainer {
    margin-top: 10px;
    min-height: 360px;
}
.settings-content .StandardTable {
    border: 1px solid #d6d9e1;
    border-radius: 5px;
    margin-top: 15px;
}
.StandardTable {
    padding: 0;
    width: 100%;
}
.StandardTable th.dynamic-first {
    border-left: medium none;
    padding: 16px 5px 16px 20px !important;
    width: auto;
}
.StandardTable th:first-child {
    background-clip: padding-box;
    border-radius: 5px 0 0;
}
.StandardTable th {
    background: rgba(0, 0, 0, 0) linear-gradient(to bottom, #fbfcfd 0%, #edeff5 100%) repeat scroll 0 0;
    border-left: 1px solid #ddd;
    color: #666666;
    font-family: "klavika-web","Helvetica Neue",Helvetica,Arial,sans-serif;
    font-weight: normal;
    padding: 16px 5px;
    text-align: left;
}
.StandardTable th:last-child {
    background-clip: padding-box;
    border-radius: 0 5px 0 0;
}

.StandardTable tr.primaryRow td:first-child {
    min-width: 43px;
    padding-left: 17px !important;
}
.StandardTable tr.primaryRow td {
    border-top: 1px solid #ddd;
    height: 60px;
    padding: 0 5px;
    vertical-align: middle;
}

table#activityDayRangePicker {
    display: none;
    float: right;
    margin-top: 5px;
}
#pnlDateBar .label {
    color: #666666;
    font-family: "klavika-web","Helvetica Neue",Helvetica,Arial,sans-serif;
    font-size: 14px;
    font-weight: normal;
    margin-top: 5px;
    text-align: left;
}
#pnlDateBar .datePicker {
    background-image: url("cal-icon.png");
    background-position: right center;
    background-repeat: no-repeat;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    color: #666;
    margin-right: 10px;
    padding: 1px 1px 1px 6px;
	 display: block;
    font-size: 14px;
    height: 34px;
    line-height: 1.42857;
}
.green-button {
    -moz-user-select: none;
    background-color: #229dd8;
    background-image: none;
    border: 1px solid #1f8dc2;
    border-radius: 4px;
    color: #ffffff;
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
    font-weight: bold;
    line-height: 1.42857;
    margin-bottom: 0;
    padding: 6px 12px;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
}
.green-button {
    float: right;
    margin: 0 10px 0 0;
}
#activityDayRangePicker .green-button {
    margin-left: 5px;
}
#pnlDateBar div.green-button {
    background: rgba(0, 0, 0, 0) linear-gradient(to bottom, #7297cb 0%, #5c84b7 100%) repeat scroll 0 0;
    border-radius: 5px;
    height: 32px;
}

.min-height-border {
    min-height: 500px;
    padding: 15px 0;
}

.cards-container {
    border-radius: 5px;
    padding-right: 15px;
}
.panel {
    background-color: #ffffff;
    border: 1px solid transparent;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
    margin-bottom: 20px;
}
.panel {
    margin-bottom: 15px;
}
.panel-default {
    border-color: #dddddd;
}

.cards .card-title {
    font-weight: bold;
    text-transform: uppercase;
}
.options-horizontal.right-links li {
    margin-left: 20px;
    margin-right: 0;
	float:right;
} 
.panel-body {
    padding: 15px;
}
.no-padding-grid.row {
    margin-left: 0;
    margin-right: 0;
}
.panel-heading {
    border-bottom: 1px solid transparent;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
    padding: 10px 15px !important;
}
.panel-default > .panel-heading {
    background-color: #f5f5f5;
    border-color: #dddddd;
    color: #333333;
}
.cards-container .panel-heading {
    background-color: #fff;
}
a, a:active {
    color: #229dd8;
    outline: medium none !important;
}
.list-unstyled.ae-card-options.clearfix{ padding:0;  }

.settings-content + .settings-content {  display:none;}

    
</style>

<script type="text/jscript">

$(document).ready(function(){
  $("#dateRangeLink").click( function(){
     $("activityDayRangePicker").toggle() 
  });
	
	})
</script>

 <article>
    <div class="container">
        <div id="content">
            <div class="content">
                <h1 class="border-buttom">Insight</h1>
                <div class="settings-row">
                    <div class="settings-nav" id="settingsNav">
                        <ul id="nested-master-menu">
                            <li id="ContentPlaceHolder1_menuItemActivity"><a href="<?=base_url();?>content/insight">activity</a></li>
                            <li class="active" id="ContentPlaceHolder1_menuItemReports"><a href="<?=base_url();?>content/reports">reports</a></li>
                        </ul>
                    </div>
                    <div class="settings-content">
                        <div class="section-container">
                            <div class="ClearBoth"></div>
                            <!-- Reports contents-->
                            <div class="settings-content">
                                <div class="section-container">
                                    <div class="min-height-border">
                                        <div class="cards-container cards">
                                            <div>
                                            <table cellspacing="0" style="width:100%;border-collapse:collapse;" id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV">
                                                <tbody><tr>
                                                    <td>
                                                        <!-- template -->
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <div class="row">
                                                                    <div class="col-lg-9">
                                                                        <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$QuickReportListGV$ctl02$QuickReportDownloadLink','')" class="card-title" id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_QuickReportDownloadLink_0">Listings that have the Buy Box</a>
                                                                    </div>
                                                                    <div class="col-lg-3 tar">
                                                                        <div class="options-horizontal right-links">
                                                                            <ul class="list-unstyled ae-card-options clearfix">
                                                                                <li class="pull-right">
                                                                                    <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$QuickReportListGV$ctl02$SecondaryQuickReportDownloadLink','')" data-original-title="download report" class="jsToolTip" id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_SecondaryQuickReportDownloadLink_0"><i class="fa fa-download"></i>&nbsp;Download</a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="min-price-section">
                                                                    <div class="row no-padding-grid">
                                                                        <div>
                                                                            <span id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_lblReportDescription_Listings_that_have_the_Buy_Box_0">All listings that display Buy Box ownership in Legend Repricing at the time of export. <br> <br> Included Columns: <strong>SKU, ItemID, Title, Your Price, Buy Box Price</strong>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    </tr><tr>
                                                        <td>
                                                        <!-- template -->
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <div class="row">
                                                                    <div class="col-lg-9">
                                                                        <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$QuickReportListGV$ctl03$QuickReportDownloadLink','')" class="card-title" id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_QuickReportDownloadLink_1">Listings that do not have the Buy Box</a>
                                                                    </div>
                                                                    <div class="col-lg-3 tar">
                                                                        <div class="options-horizontal right-links">
                                                                            <ul class="list-unstyled ae-card-options clearfix">
                                                                                <li class="pull-right">
                                                                                    <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$QuickReportListGV$ctl03$SecondaryQuickReportDownloadLink','')" data-original-title="download report" class="jsToolTip" id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_SecondaryQuickReportDownloadLink_1"><i class="fa fa-download"></i>&nbsp;Download</a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="min-price-section">
                                                                    <div class="row no-padding-grid">
                                                                        <div>
                                                                            <span id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_lblReportDescription_Listings_that_do_not_have_the_Buy_Box_1">All listings that <em>do not</em> display Buy Box ownership in Legend Repricing at the time of export. <br> <br>   Included columns:  <strong>SKU, ItemID, Title, Your Price, Buy Box Price</strong>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    </tr><tr>
                                                    <td>
                                                    <!-- template -->
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <div class="row">
                                                                <div class="col-lg-9">
                                                                    <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$QuickReportListGV$ctl04$QuickReportDownloadLink','')" class="card-title" id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_QuickReportDownloadLink_2">Listings at Min price</a>
                                                                </div>
                                                                <div class="col-lg-3 tar">
                                                                    <div class="options-horizontal right-links">
                                                                        <ul class="list-unstyled ae-card-options clearfix">
                                                                            <li class="pull-right">
                                                                                <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$QuickReportListGV$ctl04$SecondaryQuickReportDownloadLink','')" data-original-title="download report" class="jsToolTip" id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_SecondaryQuickReportDownloadLink_2"><i class="fa fa-download"></i>&nbsp;Download</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                            <div class="panel-body">
                                                                <div class="min-price-section">
                                                                    <div class="row no-padding-grid">
                                                                        <div>
                                                                            <span id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_lblReportDescription_Listings_at_Min_price_2">All listings that are currently at their min price. <br> <br>   Included columns: <strong>SKU, ItemID, Title, Total Live Price, Live Item Price, Live shipping Price, Competition Total Price, Marketplace Type, Seller Name</strong>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    </tr><tr>
                                                    <td>
                                                        <!-- template -->
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <div class="row">
                                                                    <div class="col-lg-9">
                                                                        <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$QuickReportListGV$ctl05$QuickReportDownloadLink','')" class="card-title" id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_QuickReportDownloadLink_3">Listings at Max price</a>
                                                                    </div>
                                                                    <div class="col-lg-3 tar">
                                                                        <div class="options-horizontal right-links">
                                                                            <ul class="list-unstyled ae-card-options clearfix">
                                                                                <li class="pull-right">
                                                                                    <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$QuickReportListGV$ctl05$SecondaryQuickReportDownloadLink','')" data-original-title="download report" class="jsToolTip" id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_SecondaryQuickReportDownloadLink_3"><i class="fa fa-download"></i>&nbsp;Download</a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="min-price-section">
                                                                    <div class="row no-padding-grid">
                                                                        <div>
                                                                            <span id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_lblReportDescription_Listings_at_Max_price_3">All listings that are currently at their max price. <br> <br> Included Columns: <strong>SKU, ItemID, Title, Total Live Price(Inclusive of shipping), Live Item Price, Live Shipping Price, Competition Total Price, Marketplace Type, Seller Name</strong>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    </tr><tr>
                                                        <td>
                                                        <!-- template -->
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <div class="row">
                                                                    <div class="col-lg-9">
                                                                        <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$QuickReportListGV$ctl06$QuickReportDownloadLink','')" class="card-title" id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_QuickReportDownloadLink_4">Listing without a Min price</a>
                                                                    </div>
                                                                    <div class="col-lg-3 tar">
                                                                        <div class="options-horizontal right-links">
                                                                            <ul class="list-unstyled ae-card-options clearfix">
                                                                                <li class="pull-right">
                                                                                    <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$QuickReportListGV$ctl06$SecondaryQuickReportDownloadLink','')" data-original-title="download report" class="jsToolTip" id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_SecondaryQuickReportDownloadLink_4"><i class="fa fa-download"></i>&nbsp;Download</a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="min-price-section">
                                                                    <div class="row no-padding-grid">
                                                                        <div>
                                                                            <span id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_lblReportDescription_Listing_without_a_Min_price_4">All listings without a min price set. <br> <br>   Included Columns: <strong>SKU, ItemID, Title, Live Price, Competition Price, Marketplace Type, Seller Name</strong>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    </tr><tr>
                                                        <td>
                                                        <!-- template -->
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <div class="row">
                                                                    <div class="col-lg-9">
                                                                        <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$QuickReportListGV$ctl07$QuickReportDownloadLink','')" class="card-title" id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_QuickReportDownloadLink_5">Listings that are being beaten</a>
                                                                    </div>
                                                                    <div class="col-lg-3 tar">
                                                                        <div class="options-horizontal right-links">
                                                                            <ul class="list-unstyled ae-card-options clearfix">
                                                                                <li class="pull-right">
                                                                                    <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$QuickReportListGV$ctl07$SecondaryQuickReportDownloadLink','')" data-original-title="download report" class="jsToolTip" id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_SecondaryQuickReportDownloadLink_5"><i class="fa fa-download"></i>&nbsp;Download</a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="min-price-section">
                                                                    <div class="row no-padding-grid">
                                                                        <div>
                                                                            <span id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_lblReportDescription_Listings_that_are_being_beaten_5">All listings where the competitors total price is below your total current price. <br> <br>   Included Columns: <strong>SKU, ItemID, Title, Live Price, Competition Price, Marketplace Type, Seller Name</strong>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    </tr><tr>
                                                        <td>
                                                        <!-- template -->
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <div class="row">
                                                                    <div class="col-lg-9">
                                                                        <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$QuickReportListGV$ctl08$QuickReportDownloadLink','')" class="card-title" id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_QuickReportDownloadLink_6">Competitor summary</a>
                                                                    </div>
                                                                    <div class="col-lg-3 tar">
                                                                        <div class="options-horizontal right-links">
                                                                            <ul class="list-unstyled ae-card-options clearfix">
                                                                                <li class="pull-right">
                                                                                    <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$QuickReportListGV$ctl08$SecondaryQuickReportDownloadLink','')" data-original-title="download report" class="jsToolTip" id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_SecondaryQuickReportDownloadLink_6"><i class="fa fa-download"></i>&nbsp;Download</a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="min-price-section">
                                                                    <div class="row no-padding-grid">
                                                                        <div>
                                                                            <span id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_lblReportDescription_Competitor_summary_6">Brief report containing competitor names, the number of listings you are competing with them on, the number of listings you are beating them on and listings you own the Buy Box on.  <br>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    </tr><tr>
                                                        <td>
                                                        <!-- template -->
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <div class="row">
                                                                    <div class="col-lg-9">
                                                                        <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$QuickReportListGV$ctl09$QuickReportDownloadLink','')" class="card-title" id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_QuickReportDownloadLink_7">Out of stock items</a>
                                                                    </div>
                                                                    <div class="col-lg-3 tar">
                                                                        <div class="options-horizontal right-links">
                                                                            <ul class="list-unstyled ae-card-options clearfix">
                                                                                <li class="pull-right">
                                                                                    <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$QuickReportListGV$ctl09$SecondaryQuickReportDownloadLink','')" data-original-title="download report" class="jsToolTip" id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_SecondaryQuickReportDownloadLink_7"><i class="fa fa-download"></i>&nbsp;Download</a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="min-price-section">
                                                                    <div class="row no-padding-grid">
                                                                        <div>
                                                                            <span id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_lblReportDescription_Out_of_stock_items_7">All listings with 0 inventory in Legend Repricing. Please keep in mind that this report is only kept up to date when <a href="http://support.legendrepricing.com/hc/en-us/articles/203163590-Quantity-Sync" target="_blank">Quantity Sync</a> is enabled. <br> <br>   Included Columns: <strong>SKU, ItemID, Title, Marketplace, Seller Name</strong>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                     </tr><tr>
                                                     <td>
                                                        <!-- template -->
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <div class="row">
                                                                    <div class="col-lg-9">
                                                                        <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$QuickReportListGV$ctl10$QuickReportDownloadLink','')" class="card-title" id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_QuickReportDownloadLink_8">Competition below Min Price</a>
                                                                    </div>
                                                                    <div class="col-lg-3 tar">
                                                                        <div class="options-horizontal right-links">
                                                                            <ul class="list-unstyled ae-card-options clearfix">
                                                                                <li class="pull-right">
                                                                                    <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$QuickReportListGV$ctl10$SecondaryQuickReportDownloadLink','')" data-original-title="download report" class="jsToolTip" id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_SecondaryQuickReportDownloadLink_8"><i class="fa fa-download"></i>&nbsp;Download</a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="min-price-section">
                                                                    <div class="row no-padding-grid">
                                                                        <div>
                                                                            <span id="ContentPlaceHolder1_InsightContentPlaceholder_QuickReportListGV_lblReportDescription_Competition_below_Min_Price_8">All listings where your competitor's price is below the min price you've set. <br> <br> Included Columns: <strong>SKU, Item ID, Title, Marketplace Type, Seller Name, Min Price, Competition Price</strong>
                                                                        </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                            </div>        
                            <!-- /ends reports contents-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </article>
 
 <?php include_once('footer.php'); ?>
 
