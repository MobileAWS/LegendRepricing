<?php if(isset($user_settings_full)) foreach($user_settings_full->result_array()  as $val){  ?>
<div class="modal fade" id="<?php  echo md5(trim($val['sellerid'].$val['marketplaceid']));?>" sellerid="<?php  echo $val['sellerid'];?>"  role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form role="form" class="edit_settings_form" action="#" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Configure settings </h4>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">    
              <!--
              <input type="hidden" name="sku" class="form-control" value="<?php echo $val['sku'];?>">
              <input type="hidden" name="marketplaceid" class="form-control" value="<?php echo $val['marketplaceid'];?>">
              <input type="hidden" name="sellerid" class="form-control" value="<?php echo $val['sellerid'];?>">-->
              <div class="col-md-4">
                <div class="form-group">
                  <label >Seller id:</label>
                  <input readonly type="text" name="sellerid" class="form-control" value="<?php echo $val['sellerid'];?>">
                </div> 
              </div>
              <div class="col-md-4 col-md-offset-4">
                <div class="form-group">
                  <label >Marketplaceid</label>
                  <input readonly type="text" name="marketplaceid" class="form-control" value="<?php echo $val['marketplaceid'];?>">
                </div> 
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label >Nick name:</label>
                  <input readonly type="text" name="nickname" class="form-control" value="<?php echo $val['nickname'];?>"> 
                  <input type="hidden" name="mwsauthtoken" class="form-control" value="<?php echo $val['mwsauthtoken'];?>"> 
                </div> 
              </div>

              <div class="col-md-4 col-md-offset-4">
                <div class="form-group">
                  <label>Generate reports email (Optional)</label>
                  <select class="form-control" name="reports" id="sel1">
                    <option value='None' <?php if ($val['reports']=='None') { echo "selected"; } ?>>None</option>
                    <option value='hourly'<?php if ($val['reports']=='hourly') { echo "selected"; } ?>>Hourly</option>
                    <option value='daily' <?php if ($val['reports']=='daily') { echo "selected"; } ?>>Daily</option>
                    <option value='monthly' <?php if ($val['reports']=='monthly') { echo "selected"; } ?>>monthly</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label >GBS:</label>     
                  <select  class="form-control gbs_settings" name="gbs" >
                    <option value='formula'  <?php if ($val['beatby']=='formula') { echo "selected"; } ?>>Formula</option>
                    <option value='beatby'  <?php if ($val['beatby']=='beatby') { echo "selected"; } ?>>beatby</option>
                    <option value='beatmeby' <?php if ($val['beatby']=='beatmeby') { echo "selected"; } ?>>beatmeby</option>
                    <option value='matchprice' <?php if ($val['beatby']=='matchprice') { echo "selected"; } ?>>matchprice</option>
                  </select>                                
                  <!--                  <input type="text" name="beatby" class="form-control" value="<?php echo $val['beatby'];?>"> -->
                  <!--  <label>*Use our secret formula to win Buybox </label>-->
                </div> 
              </div>            
              <div class="col-md-4">
                <div class="form-group gbs_value">
                  <label >Value:</label>     
                  <input type="text" <?php if($val['beatby']=='matchprice' || $val['beatby']=='formula') echo 'disabled';?> value="<?php echo $val['beatbyvalue'];?>" name="gbs_beatby" class="form-control gbs_settings_beatby" placeholder="0.0"/>
<!--
                  <input type="text" <?php if ($val['beatby']=='beatby') {echo 'style="display:block;" value="'.$val['beatbyvalue'].'"';} else {echo 'style="display:none;"';}?> name="gbs_beatby" class="form-control gbs_beatby" placeholder="0.0"/>
                  <input type="text" <?php if (!$val['beatby']=='beatmeby') {echo 'style="display:block;" value="'.$val['beatbyvalue'].'"';} else{echo 'style="display:none"';} ?> name="gbs_beatmeby" class="form-control gbs_beatmeby" placeholder="0.0"/>
                  <input  type="text" readonly <?php if ($val['beatby']=='matchprice') {echo 'style="display:block;" value="'.$val['beatbyvalue'].'"';}else{echo 'style="display:none"';} ?> name="gbs_matchprice" class="form-control gbs_matchprice" placeholder="0.0"/>
                  <input  type="text" readonly <?php if ($val['beatby']=='formula') {echo 'style="display:block;" value="'.$val['beatbyvalue'].'"';}else {echo 'style="display:none"';} ?>  name="gbs_formula" class="form-control gbs_formula" placeholder="Use our secret formula"/>          -->
                  <!--                  <input type="text" name="beatby" class="form-control" value="<?php echo $val['beatby'];?>"> -->
                  <!--  <label>*Use our secret formula to win Buybox </label>-->
                </div> 
              </div>                     
            </div>                     
            <!--
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Beat amazon:</label>     
                  <select class="form-control beat_amazon_flag" name="beat_amazon_flag" >
                    <option value='yes'  <?php if ($val['beat_amazon_flag']=='yes') { echo "selected"; } ?>>Yes</option>
                    <option value='no'  <?php if ($val['beat_amazon_flag']=='no') { echo "selected"; } ?>>No</option>
                  </select>                                
                </div> 
              </div>            
              <div class="col-md-4">
                <div class="form-group">
                  <label >Value:</label>     
                  <input type="text" value="<?php echo $val['beat_amazon'];?>" <?php if ($val['beat_amazon_flag']=='no') {echo 'disabled';}?> name="beat_amazon" class="form-control beat_amazon" placeholder="0.0"/>
                </div> 
              </div>                     
            </div>     -->                 
            <div class="row">
              <div class="col-md-8">
                <div class="form-group"> 
                  <label for="inputPassword3">Exclude seller id : (Optional)</label>      
                  <textarea name="exclude_seller" class="form-control" rows="3" placeholder="Enter seller ids separated by semicolon"><?php echo preg_replace('/\s+/', ' ', $val['exclude_seller']);?></textarea> </div> </div>
            </div>              
            <div class="row">
              <div class="col-md-8">
                <div class="form-group"> 
                  <label for="inputPassword3">Include seller id : (Optional)</label>      
                  <textarea name="include_seller" class="form-control" rows="3" placeholder="Enter seller ids separated by semicolon"><?php echo preg_replace('/\s+/', ' ', $val['include_seller']);?></textarea> </div> </div>
            </div>             
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary edit_settings_button">Save changes</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php } ?>
