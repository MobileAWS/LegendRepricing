 
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
                <li class="active" id="ContentPlaceHolder1_menuItemActivity"><a href="<?=base_url();?>content/insight">activity</a></li>
                <li id="ContentPlaceHolder1_menuItemReports"><a href="<?=base_url();?>content/reports">reports</a></li>
		    </ul>
        </div>
        <div class="settings-content">
            <div class="section-container">
		        
            
        <div class="ClearBoth"></div>

    

    <div class="pnlDateBar" id="pnlDateBar">
		
        <ul id="activityDayRange">
            <li>
                <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$lbDateToday','')" id="lbDateToday">Today</a></li>
            <li>
                <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$lbDateYesterday','')" class="active" id="lbDateYesterday">Yesterday</a></li>
            <li>
                <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$lbDateWeek','')" id="lbDateWeek">This Week</a></li>
            <li>
                <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$lbDateMonth','')" id="lbDateMonth">This Month</a></li>
            <li><a onclick="ToggleActivityDayRangePicker()" id="dateRangeLink" href="#">Date Range</a></li>
        </ul>

        <table id="activityDayRangePicker">
            <tbody><tr>
                <td valign="middle">
                    <div class="label">Start Date</div>
                </td>
                <td valign="middle">
                    <input type="text" class="datePicker hasDatepicker" id="tbDateStart" value="02-Dec-2015" name="ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$tbDateStart">
                </td>
                <td valign="middle">
                    <div class="label">End Date</div>
                </td>
                <td valign="middle">
                    <input type="text" class="datePicker hasDatepicker" id="tbDateEnd" value="02-Dec-2015" name="ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$tbDateEnd">
                </td>
                <td valign="middle">
                    <div class="green-button">
                        <a href="javascript:__doPostBack('ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$lbDateFilterSubmit','')" id="lbDateFilterSubmit" onclick="return ValidateDateFilter();">Update</a>
                    </div>
                </td>
            </tr>
        </tbody></table>

        <div class="ClearBoth"></div>
    
	</div> <div id="activityDGContainer">

        <input type="hidden" value="1" id="ContentPlaceHolder1_InsightContentPlaceholder_CurrentPageValue" name="ctl00$ctl00$ContentPlaceHolder1$InsightContentPlaceholder$CurrentPageValue">
        <table cellspacing="0" cellpadding="0" class="StandardTable" id="ActivityTable"><thead><tr>
<th class="dynamic-first">Event</th>
<th>Details</th>
</tr></thead><tbody>
<tr class="primaryRow"><td colspan="2">There is no activity for the selected date range</td></tr></tbody></table>

    </div>
    </div></div>
        

    </div></div></div></div>
 </article>
 
 <?php include_once('footer.php'); ?>
 