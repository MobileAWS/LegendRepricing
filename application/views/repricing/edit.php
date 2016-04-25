<?php if(isset($user_listings)) foreach($user_listings->result_array()  as $val){  ?>
<!--<div class="modal fade" id="<?php  echo $val['sku'];?>" sellerid="<?php  echo $val['sellerid'];?>"  role="dialog" aria-labelledby="gridSystemModalLabel">-->
<div class="modal fade" id="<?php  echo md5(trim($val['sku']));?>" sellerid="<?php  echo $val['sellerid'];?>"  role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form role="form" class="edit_form" action="#" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Configure listings - <?php echo $val['sku'];?></h4>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">    
              <input type="hidden" name="sku" class="form-control" value="<?php echo $val['sku'];?>">
              <input type="hidden" name="marketplaceid" class="form-control" value="<?php echo $val['marketplaceid'];?>">
              <input type="hidden" name="sellerid" class="form-control" value="<?php echo $val['sellerid'];?>">
              <div class="col-md-4">
                <div class="form-group">
                  <label >Min price:</label>
                  <input maxlength="15" type="text" name="min_price" class="form-control" value="<?php echo $val['min_price'];?>">
                </div> 
              </div>
              <div class="col-md-4 col-md-offset-4">
                <div class="form-group">
                  <label >Max price:</label>
                  <input maxlength="15" type="text" name="max_price" class="form-control" value="<?php echo $val['max_price'];?>">
                </div> 
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label >Max order qty:</label>
                  <input maxlength="10" type="text" name="maxorderqty" class="form-control" value="<?php echo $val['maxorderqty'];?>"> 
                </div> 
              </div>
              <div class="col-md-4 col-md-offset-4">
                <div class="form-group">
                  <label >MAP price:</label>
                  <input maxlength="15" type="text" name="map_price" class="form-control" value="<?php echo $val['map_price'];?>">
                </div> 
              </div>                                
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label >Listing price:</label>
                  <input maxlength="15" type="text" name="price" class="form-control" value="<?php echo $val['price'];?>">
                </div> 
              </div>
              <div class="col-md-4 col-md-offset-4">
                <div class="form-group">
                  <label >Shipping price:</label>
                  <input maxlength="15" type="text" name="ship_price" class="form-control" value="<?php echo $val['ship_price'];?>"> 
                </div> 
              </div>                           
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label >Strategy:</label>     
                  <select class="form-control edit_gbs" name="beatby" >
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
                  <input type="text" <?php if ($val['beatby']=='beatby') {echo 'style="display:block;" value="'.$val['beatbyvalue'].'"';} else {echo 'style="display:none;"';}?> name="gbs_beatby" class="form-control gbs_beatby" placeholder="0.0"/>
                  <input type="text" <?php if ($val['beatby']=='beatmeby') {echo 'style="display:block;" value="'.$val['beatbyvalue'].'"';} else{echo 'style="display:none"';} ?> name="gbs_beatmeby" class="form-control gbs_beatmeby" placeholder="0.0"/>
                  <input  type="text" readonly <?php if ($val['beatby']=='matchprice') {echo 'style="display:block;" value="'.$val['beatbyvalue'].'"';}else{echo 'style="display:none"';} ?> name="gbs_matchprice" class="form-control gbs_matchprice" placeholder="0.0"/>
                  <input  type="text" readonly <?php if ($val['beatby']=='formula') {echo 'style="display:block;" value="'.$val['beatbyvalue'].'"';}else {echo 'style="display:none"';} ?>  name="gbs_formula" class="form-control gbs_formula" placeholder="Use our secret formula"/>         
                  <!--                  <input type="text" name="beatby" class="form-control" value="<?php echo $val['beatby'];?>"> -->
                  <!--  <label>*Use our secret formula to win Buybox </label>-->
                </div> 
              </div>                     
            </div>                     
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label >Change Fulfilment channel:</label>
                  <select class="form-control" name="fulfillment_channel">
                    <option value='AMAZON_NA' <?php if ($val['fulfillment_channel'] == 'AMAZON_NA') { echo "selected"; } ?>>FBA</option>
                    <option value='DEFAULT' <?php if ($val['fulfillment_channel']== 'DEFAULT') { echo "selected"; } ?>>Seller</option>
                  </select>
                  <!--      <input type="text" name="fulfillment_channel" class="form-control" value="<?php echo $val['fulfillment_channel'];?>"> -->
                </div> 
              </div>                                          
            </div>           
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label >Competition Type:</label>
                  <select class="form-control" name="comp_type">
                    <option value='all' <?php if ($val['comp_type'] == 'all') { echo "selected"; } ?>>All Sellers</option>
                    <option value='amazon' <?php if ($val['comp_type'] == 'amazon') { echo "selected"; } ?>>Amazon</option>
                    <option value='fba' <?php if ($val['comp_type'] == 'fba') { echo "selected"; } ?>>FBA</option>
                    <option value='nonfba' <?php if ($val['comp_type'] == 'nonfba') { echo "selected"; } ?>>Non FBA</option>
                    <option value='amazonandfba' <?php if ($val['comp_type']== 'amazonandfba') { echo "selected"; } ?>>Amazon and FBA</option>
                  </select>
                  <!--      <input type="text" name="fulfillment_channel" class="form-control" value="<?php echo $val['fulfillment_channel'];?>"> -->
                </div> 
              </div>                                          
            </div>   
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
            </div>                      
            <div class="row">
              <div class="col-md-8">
                <div class="form-group"> 
                  <label for="inputPassword3">Exclude seller id : (Optional)</label>      
                  <textarea name="exclude_seller" class="form-control" rows="3" placeholder="Enter seller ids separated by semicolon"><?php echo preg_replace('/\s+/', ' ', $val['exclude_seller']);?></textarea> </div> </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary edit_button">Save changes</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php } ?>
