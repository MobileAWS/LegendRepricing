<?php include_once('header.php'); ?>
<?php include_once('nav-inner-admin.php'); ?>
<style type="text/css">

body {  font-family:Arial, Helvetica, sans-serif;}
.border-buttom {  border-bottom:1px solid #eee;}
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

#nested-content {
    float: left;
    width: 83.3333%;
}
#nested-content > div {
    font-style: normal;
    font-weight: 400;
}
#nested-content .section {
    background-clip: padding-box;
    border: 1px solid #d6d9e1;
    border-radius: 5px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
}
#nested-content .section {
    margin: 15px 15px 15px 0;
}
#nested-content .item-title-row {
    border-bottom: 1px solid #d6d9e1;
    color: #229dd8;
    font-weight: bold;
    padding: 10px 15px;
    text-transform: uppercase;
}

#nested-content .section .item-actions-row {
    float: right;
}
#nested-content .item-actions-row a {
    color: #229dd8;
    font-weight: normal;
    margin-left: 10px;
    text-decoration: none;
    text-transform: lowercase;
}
:root .fa-rotate-90, *:root .fa-rotate-180, *:root .fa-rotate-270, *:root .fa-flip-horizontal, *:root .fa-flip-vertical {
    filter: none;
}
.fa-rotate-90 {
    transform: rotate(90deg);
}
.fa-fw {
    text-align: center;
    width: 1.28571em;
}

#nested-content .item-info-row .item-info-container-wide {
    float: left;
    width: 66.6667%;
}
#nested-content .item-info-row .item-info-container-wide label {
    font-weight: normal;
    margin-left: 15px;
}
#nested-content .item-info-row .item-info-container .listings-number-container {
    border-left: 1px solid #d6d9e1;
    padding: 6px 0;
}

#nested-content .item-info-row .item-info-container {
    float: left;
    width: 33.3333%;
}
#nested-content .item-info-row {
    margin: 10px 0px; display:inline-block; width:100%;
}
#nested-content .item-info-row .item-info-container .listings-number-container a:link, #nested-content .item-info-row .item-info-container .listings-number-container a:visited, #nested-content .item-info-row .item-info-container .listings-number-container a:active {
    color: #474e5d;
    text-decoration: none;
}
#nested-content .item-info-row .item-info-container .listings-number-container .listings-number {
    font-size: 30px;
    font-weight: bold;
    text-align: center;
}
#nested-content .item-info-row .item-info-container .listings-number-container .listings-number-label {
    text-align: center;
}

    
</style>
 <article>
	<div class="container">
 
<div id="content">
<div class="content">
                            

    <h1 class="border-buttom">Manage</h1>

    <div class="settings-row">
        <div class="settings-nav" id="settingsNav">
		    <ul id="nested-master-menu">
                <li class="active" id="ContentPlaceHolder1_menuItemProfiles"><a href="#">strategies</a></li>
                <li id="ContentPlaceHolder1_menuItemMarketplaces"><a href="#">marketplaces</a></li>
                <li id="ContentPlaceHolder1_menuItemUploads"><a href="#">uploads</a></li>
                <li id="ContentPlaceHolder1_menuItemSettings"><a href="<?=base_url('content/settings');?>">settings</a></li>
                                
                
		    </ul>
        </div>
		
    <div id="nested-content">
        
        <div>
		<table cellspacing="0" style="width:100%;border-collapse:collapse;" id="ContentPlaceHolder1_SettingsContentPlaceholder_StrategiesListGV">
			<tbody><tr>
				<td>
                        <!-- template -->
                        <div class="section">
                            <div class="item-title-row">
                            <a href="#" id="ContentPlaceHolder1_SettingsContentPlaceholder_StrategiesListGV_StrategyTitle_0">Pre Configured Strategy</a>
                                <div class="item-actions-row">

                                    
                                    <a href="#" data-original-title="edit" class="jsToolTip" id="ContentPlaceHolder1_SettingsContentPlaceholder_StrategiesListGV_EditStrategyLink_0">
                                      <i class="fa fa-pencil fa-fw"></i>
                                    </a>
                                    <a href="#" data-original-title="duplicate" class="jsToolTip" id="ContentPlaceHolder1_SettingsContentPlaceholder_StrategiesListGV_DuplicateStrategyLink_0">
                                      <i class="fa fa-files-o fa-fw"></i>
                                    </a>
                                    <a href="#" value="6673" data-original-title="preview" class="previewIcon jsToolTip" id="ContentPlaceHolder1_SettingsContentPlaceholder_StrategiesListGV_PreviewStrategyLink_0">
                                      <i class="fa fa-eye fa-fw"></i>
                                    </a>

                                    <a href="#" value="6673" data-original-title="delete" class="deleteIcon jsToolTip" id="ContentPlaceHolder1_SettingsContentPlaceholder_StrategiesListGV_DeleteProfileLink_0">
                                    <i class="fa fa-trash-o fa-fw"></i>
                                    </a>

                                </div>
                            </div>

                            <div class="item-info-row">
                                <div class="item-info-container-wide">
                                    <div>
                                        <label>ID:</label>
                                        <strong>
                                            
                                            <span id="ContentPlaceHolder1_SettingsContentPlaceholder_StrategiesListGV_StrategyID_0">1</span>
                                        </strong>
                                    </div>
                                    <div>
                                        <label>Strategy:</label>
                                        <strong>
                                        <span id="ContentPlaceHolder1_SettingsContentPlaceholder_StrategiesListGV_ProfileConfiguration_0">Pre Configured</span>
                                        </strong>
                                    </div>
                                 <!--
                                    <div class="minPriceDiv">
                                        <label>Min Price Formula:</label>
                                        <strong>
                                            <span id="ContentPlaceHolder1_SettingsContentPlaceholder_StrategiesListGV_MinPriceMethod_0">Manual</span>
                                        </strong>
                                    </div>

                                    <div class="maxPriceDiv" style="display: none;">
                                        <label>Max Price Formula:</label>
                                        <strong>
                                            <span id="ContentPlaceHolder1_SettingsContentPlaceholder_StrategiesListGV_MaxPriceMethod_0"></span>
                                        </strong>
                                    </div>

                                    <div>
                                        <label>Last Modified:</label>
                                        <strong>
                                            <span id="ContentPlaceHolder1_SettingsContentPlaceholder_StrategiesListGV_LastModified_0">11/19/2014 3:43:24 AM</span>
                                        </strong>
                                    </div>
-->
                                </div>

                                <div class="item-info-container">
                                    <div class="listings-number-container">
                                        <a href="listings.aspx?profileID=6673" class="assigned-listings" id="ContentPlaceHolder1_SettingsContentPlaceholder_StrategiesListGV_AssignedListingsLink_0">
                                            <div class="listings-number">
<?php echo $mtotal;?>
                                            </div>
                                            <div class="listings-number-label">Assigned Listings</div>
                                        </a>
                                    </div>
                                </div>

                                

                                <input type="hidden" id="ContentPlaceHolder1_SettingsContentPlaceholder_StrategiesListGV_hdnUserID_0" name="ctl00$ctl00$ContentPlaceHolder1$SettingsContentPlaceholder$StrategiesListGV$ctl02$hdnUserID">
                                

                            </div>

                        </div>
                        
                    </td>
			</tr>
		</tbody></table>
	</div>
    </div>

    <input type="hidden" id="strategyIDHidden" value="">

    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal" id="manageStrategyModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 id="myModalLabel" class="modal-title">Add Default Strategy</h4>
                </div>

                <div id="divDeleteStrategy" class="jsDelete-modal-body modal-body">
                    <div id="divDeleteMessage" class="text-red"></div>
                </div>
                <div id="divDeleteStrategyFooter" class="jsDelete-modal-footer modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                    <button id="btnDeleteProfile" data-dismiss="modal" class="btn btn-danger" type="button">Delete</button>
                </div>

                <div id="AssignStrategyModal" class="jsDelete-modal-body  modal-body">
                    <div class="alert alert-warning">
                        <i class="fa fa-warning"></i>These changes may take a few minutes to save.
                    </div>
                    <div class="assign-listings">
                        <ul id="assignStrategyList" role="menu" class="list-unstyled"></ul>
                    </div>
                </div>

                <div id="SaveStrategyModalFooter" class="jsDelete-modal-footer modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                    <button id="btnSaveStrategy" class="btn btn-primary" type="button">Save</button>
                </div>
                <div id="AssignStrategyModalFooter" class="jsDelete-modal-footer  modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                    <div id="jsSaveAssignStrategyPreloader" style="display: none;" class="save-animation">
                        <img src="images/icons/waiting-animation.gif" alt="Loading...">
                    </div>
                    <button id="btnAssignStrategy" class="btn btn-primary" type="button">Save</button>
                </div>

                <div class="jsDelete-modal-body  modal-body" id="divDeleteWarning">    
                <div style="display: block;" role="alert" class="alert alert-danger alert-dismissible"><i class="fa fa-warning">
                    </i> Sorry you cannot delete <strong><span class="spanStrategyName"></span></strong> since it is used in existing Marketplace(s).<hr><p>You must first disassociate this Strategy with these Marketplace(s):</p><span id="marketplaceDeleteWarning">
                        <ul id="ulMarketplaces"></ul></span>
                </div>
                <div id="divDeleteWarningFooter" class="jsDelete-modal-footer modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>                    
                </div>
            </div>


            </div>
        </div>
    </div>

    <!--preview modal-->
    <div aria-hidden="true" aria-labelledby="jsPreviewStrategy" role="dialog" tabindex="-1" id="jsPreviewStrategy" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
            <h4 class="modal-title">Preview Strategy</h4>
          </div>
          <div class="preview-modal-body modal-body ">
        
          </div>
          <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
            
          </div>
        </div>
      </div>
    </div>


    <div style="display: none" class="error-panel"></div>


    </div>   
       
    <div class="settings-content">
            
    </div>       

    
    <input type="hidden" id="ContentPlaceHolder1_LanguageISO" name="ctl00$ctl00$ContentPlaceHolder1$LanguageISO">

                            

                        </div>
                        </div>
                    
</div>
 </article>

 <?php include_once('footer.php'); ?>
 
