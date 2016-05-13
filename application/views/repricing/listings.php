<?php include_once('header.php'); ?>
<?php include_once('nav-inner-admin.php'); ?>
<!--
  <div class="top-header"> 
    <span class="box-search">
    <form role="form" id="search_form" action="<?php echo base_url('content/listings_search');?>" method="post">
      <input type="submit" value="Search" class="btn-search"><i class="fa fa-search"></i>
      <input name="search_text" type="text" class="input-header" title="Search" placeholder="Search">
      <input type="submit" class="btn btn-submit" title="Submit" value="Submit"/>
</form>
    </span>	
  </div>	 -->
<div class="container" id="amazon-listing-table">	
  <div id="content">
    <div class="content">
      <h1>
        <!--
          <div class="btn-setAction">	
            <div class="btn-group">
              <button title="Listing Views " type="button" class="dropdown-toggle btn" data-toggle="dropdown">
                Sort/Views <i class="fa fa-angle-down"></i>
              </button>
              <ul class="dropdown-menu">
                <li><a href="#">Favorites</a></li>
                <li><a href="<?php echo base_url('content/listings');?>">All Listings</a></li>
                <li><a href="<?php echo base_url('content/listings_active');?>">Active Listings</a></li>
                <li><a href="<?php echo base_url('content/listings_inactive');?>">Inactive Only</a></li>
                <li><a href="#">Out-of-stock</a></li>
                <li><a href="#">No Min Price</a></li>
                <li><a href="#">Manual Price Only</a></li>
                <li><a href="#">Listings at min price</a></li>
                <li><a href="#">Listings at max price</a></li>
                <li><a href="#">Competition Below Min</a></li>
                <li><a href="<?php echo base_url('content/listings_bb');?>">Buy Box</a></li>
                <li><a href="<?php echo base_url('content/listings_nbb');?>">Non Buy Box</a></li>

              </ul>
            </div>
            <div class="btn-group">
              <button title="Action" type="button" class="dropdown-toggle btn" data-toggle="dropdown">
                Action <i class="fa fa-angle-down"></i>
              </button>
              <ul class="dropdown-menu">
                <li><a href="#">Dropdown link</a></li>
                <li><a href="#">Dropdown link</a></li>
              </ul>
            </div>	  
          </div>      -->                
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Download Template
            <span class="fa fa-download"></span></button>
          <ul class="dropdown-menu">
          <li><a href="<?php echo base_url('/files/1.csv');?>" download="LP-fields.csv">All Available fields</a></li>
            <li><a href="<?php echo base_url('/files/2.csv');?>" download="LP-inventory.csv" >Update Inventory</a></li>
      <!--      <li><a href="#">Update Group Inventory</a></li>-->
      <li><a href="<?php echo base_url('/files/3.csv');?>" download="LP-Minmax.csv">Set or Update Min/Max prices</a></li>
      <li><a href="<?php echo base_url('/files/4.csv');?>" download="LP-Price.csv">Set or Update Price</a></li>
      <li><a href="<?php echo base_url('/files/5.csv');?>" download="LP-MAP.csv" >Set or Update Map prices</a></li>
            <!--
    <li><a href="#">Update Group Inventory</a></li>
    <li><a href="#">Update Group Inventory</a></li>
    <li><a href="#">Update Group Inventory</a></li>
    <li><a href="#">Update Group Inventory</a></li>
    <li><a href="#">Update Group Inventory</a></li>
    <li><a href="#">Update Group Inventory</a></li>-->
          </ul>
        </div>
        <br />
        <strong>
          Amazon Seller id / Marketplace    
        </strong>
        <select class="filters" id="account_sellerid" style="max-width:500px;width:300px;background-color:white;">
          <?php foreach($user_settings->result_array() as $vv) {?>
          <option value="<?php echo $vv['sellerid'].'/'.$vv['marketplaceid'];?>" <?php if($vv['sellerid']==$sellerid && $vv['marketplaceid']==$marketplaceid) { echo 'selected' ;}?>><?php 
          if (strlen($vv['nickname'])>=1) {echo $vv['nickname'].'/'.($vv['marketplaceid']=='ATVPDKIKX0DER'?"amazon.com":"amazon.ca");} else {echo $vv['sellerid'].'/'.($vv['marketplaceid']=='ATVPDKIKX0DER'?"amazon.com":"amazon.ca");}?></option>
          <?php } ?>
        </select>                   
        <br />
        <br />
        All listings
        <span style="padding:10px;font-size:11px">
          <label>Status:</label>
          <input class="filters1" type="radio" name="editList" value="all" <?php if($status!='active' && $status!='inactive') echo 'checked' ;?>>All
          <input class="filters1" type="radio" name="editList" value="active" <?php  if($status=='active') echo 'checked';?>>Active
          <input class="filters1" type="radio" name="editList" value="inactive" <?php  if($status=='inactive') echo 'checked';?>>Inactive
        </span>           
        <span style="padding:10px;font-size:11px">
          <label>Fulfilled By:</label>
          <input class="filters1"type="radio" name="editList1" value="all" <?php if($channel_type!='AMAZON_NA' && $channel_type!='DEFAULT') echo 'checked' ;?>>All
          <input class="filters1" type="radio" name="editList1" value="AMAZON_NA" <?php if($channel_type=='AMAZON_NA') echo 'checked' ;?>>Amazon
          <input class="filters1" type="radio" name="editList1" value="DEFAULT" <?php if($channel_type=='DEFAULT') echo 'checked' ;?>>Merchant
        </span> 

      </h1>
      <div class="table-box">
        <div class="content show-entry">
          <h1>
            <div class="fright">

              <span class="box-search">
                <!-- <form role="form"  action="<?php echo base_url('content/listings_search');?>" method="post">-->
                <!--<form role="form"  action="" method="post">-->
                <input type="button" value="Search" class="btn-search filters"><i class="fa fa-search"></i>
                <input id="search_text" name="search_text" type="text" value="<?php echo $search_text;?>" class="input-header filters" title="Search" placeholder="Search title or SKU or ASIN">
                <!--                  </form>-->
              </span>
            </div>
            <!--  Show <input readonly type="number" title="number" value="5" class="input-show"/> <span>Entries</span></h1>-->
            Show 
            <select class="filters" id="pagesize" style="width:100px;background-color:white;">
              <option value="10" <?php if($pagesize==10) echo 'selected';?>>10</option>
              <option value="20"<?php if($pagesize==20) echo 'selected';?>>20</option>
              <option value="50"<?php if($pagesize==50) echo 'selected';?>>50</option>
              <option value="100"<?php if($pagesize==100) echo 'selected';?>>100</option>
            </select>
            <span>Entries</span>

            <span style="padding:10px;font-size:11px">
              <label><?php echo isset($pag_message)?$pag_message:'';?></label>
            </span>
          </h1>
        </div>
        <div class="table-responsive">
          <table class="table table-hover" id="example">
            <thead>
              <!--   <th>#</th>  -->
              <th><input type="checkbox" id="selectAll" name="list-table-all"></th>
              <th>SKU
                <?php if($col_name=='sku' && $col_direction=="desc")
                {
                echo '<span class="col-active">&#9660;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="desc" col-name="sku" >&#9660;</span> ';
                }
                ?>
                <?php if($col_name=='sku' && $col_direction=="asc")
                {
                echo '<span class="col-active">&#9650;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="asc" col-name="sku" >&#9650;</span> ';
                }
                ?>
              </th>
              <th>Title
                <?php if($col_name=='itemname' && $col_direction=="desc")
                {
                echo '<span class="col-active">&#9660;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="desc" col-name="itemname">&#9660;</span> ';               
                }
                ?>
                <?php if($col_name=='itemname' && $col_direction=="asc")
                {
                echo '<span class="col-active">&#9650;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="asc" col-name="itemname" >&#9650;</span> ';
                }
                ?>       

              </th>
              <th>Condition
                <?php if($col_name=='item_condition' && $col_direction=="desc")
                {
                echo '<span class="col-active">&#9660;</span>';
                }
                else
                {
                echo '<span class="col-inactive"  col-direction="desc" col-name="item_condition" >&#9660;</span> ';              
                }
                ?>
                <?php if($col_name=='item_condition' && $col_direction=="asc")
                {
                echo '<span class="col-active">&#9650;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="asc" col-name="item_condition" >&#9650;</span> ';
                }
                ?>       


              </th>
              <th>Channel
                <?php if($col_name=='fulfillment_channel' && $col_direction=="desc")
                {
                echo '<span class="col-active">&#9660;</span>';              
                }
                else
                {
                echo '<span class="col-inactive" col-direction="desc" col-name="fulfillment_channel" >&#9660;</span> ';     
                }
                ?>
                <?php if($col_name=='fulfillment_channel' && $col_direction=="asc")
                {
                echo '<span class="col-active">&#9650;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="asc" col-name="fulfillment_channel" >&#9650;</span> ';
                }
                ?>       
              </th>
              <th data-toggle="tooltip" title="Set delete to delete the restriction"> Min Price
                <?php if($col_name=='min_price' && $col_direction=="desc")
                {
                echo '<span class="col-active">&#9660;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="desc" col-name="min_price" >&#9660;</span> ';              
                }
                ?>
                <?php if($col_name=='min_price' && $col_direction=="asc")
                {
                echo '<span class="col-active">&#9650;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="asc" col-name="min_price" >&#9650;</span> ';
                }
                ?>       
              </th>
              <th>Max Price
                <?php if($col_name=='max_price' && $col_direction=="desc")
                {
                echo '<span class="col-active">&#9660;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="desc" col-name="max_price" >&#9660;</span> ';
                }
                ?>
                <?php if($col_name=='max_price' && $col_direction=="asc")
                {
                echo '<span class="col-active">&#9650;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="asc" col-name="max_price" >&#9650;</span> ';
                }
                ?>       
              </th>
              <th>Your Price
                <?php if($col_name=='price' && $col_direction=="desc")
                {
                echo '<span class="col-active">&#9660;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="desc" col-name="price" >&#9660;</span> ';
                }
                ?>
                <?php if($col_name=='price' && $col_direction=="asc")
                {
                echo '<span class="col-active">&#9650;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="asc" col-name="price" >&#9650;</span> ';
                }
                ?>       
              </th>                      
              <th>Amazon fees
                <?php if($col_name=='fees' && $col_direction=="desc")
                {
                echo '<span class="col-active">&#9660;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="desc" col-name="fees" >&#9660;</span> ';
                }
                ?>
                <?php if($col_name=='fees' && $col_direction=="asc")
                {
                echo '<span class="col-active">&#9650;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="asc" col-name="fees" >&#9650;</span> ';
                }
                ?>       
              </th>                                
              <th>Qty
                <?php if($col_name=='qty' && $col_direction=="desc")
                {
                echo '<span class="col-active">&#9660;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="desc" col-name="qty" >&#9660;</span> ';
                }
                ?>
                <?php if($col_name=='qty' && $col_direction=="asc")
                {
                echo '<span class="col-active">&#9650;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="asc" col-name="qty" >&#9650;</span> ';
                }
                ?>       
              </th>      
              <th>Competition
                <?php if($col_name=='c1' && $col_direction=="desc")
                {
                echo '<span class="col-active">&#9660;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="desc" col-name="c1" >&#9660;</span> ';
                }
                ?>
                <?php if($col_name=='c1' && $col_direction=="asc")
                {
                echo '<span class="col-active">&#9650;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="asc" col-name="c1" >&#9650;</span> ';
                }
                ?>       
              </th>
              <th>Buy Box
                <?php if($col_name=='bb_price' && $col_direction=="desc")
                {
                echo '<span class="col-active">&#9660;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="desc" col-name="bb_price" >&#9660;</span> ';
                }
                ?>
                <?php if($col_name=='bb_price' && $col_direction=="asc")
                {
                echo '<span class="col-active">&#9650;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="asc" col-name="bb_price" >&#9650;</span> ';
                }
                ?>       
              </th>

              <!--
                <th>Max Order Quantity</th> 
               <th>MAP </th>   -->
              <th>Shipping
                <?php if($col_name=='ship_price' && $col_direction=="desc")
                {
                echo '<span class="col-active">&#9660;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="desc" col-name="ship_price" >&#9660;</span> ';
                }
                ?>
                <?php if($col_name=='ship_price' && $col_direction=="asc")
                {
                echo '<span class="col-active">&#9650;</span>';
                }
                else
                {
                echo '<span class="col-inactive" col-direction="asc" col-name="ship_price" >&#9650;</span> ';
                }
                ?>       
              </th>
              <!--                <th>Status </th>
                <th>Actions</th>-->
              <th>    
                <button disabled class="btn" type="button" onclick="alert('Hello world!')">Save ALL!</button>
              </th>
            </thead>
            <tbody> 
            <?php if(isset($user_listings)){ $i=0;foreach($user_listings->result_array()  as $val){ $i++; ?>
            <!--   <tr rowid="<?php echo $val['sku'].'@'.$val['sellerid'];?>">-->
            <tr>
              <td><input type="checkbox" name="list-table" value="<?php echo $val['sku'];?>"></td>
              <!--                <td><?php echo ($page+$i); ?></td>  -->
              <td><?php echo  $val['sku'] ?></td>
              <td><a style=" width: 200px; display: inline-block; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;" target = "_blank" class="listing-title ellipsis" href="<?php echo $amazon_url.$val['asin'];?>"><?php echo  $val['itemname'];  ?></a></td>
              <!--   <td><?php echo $val['item_condition'].'/'.$val['item_subcondition'] ?></td> -->
              <td><?php echo ucfirst($val['item_condition']);?></td>
              <td><?php if($val['fulfillment_channel']=='AMAZON_NA') echo 'FBA';
                else echo 'Seller'; ?></td>
              <td><input maxlength="15" class="list-change" style="width:100px" name="min_price" type="text" value="<?php echo sprintf('%.2f',$val['min_price']); ?>"></td>
              <td><input maxlength="15" class="list-change" style="width:100px" name="max_price" type="text" value="<?php echo sprintf('%.2f',$val['max_price']); ?>"></td>
              <td><input maxlength="15" class="list-change"  style="width:100px" name="price" type="text" value="<?php echo (sprintf('%.2f',$val['price'])); ?>"></td>
              <td><?php echo $val['fees'];?></td>
              <td><input maxlength="10" class="list-change" style="width:100px" <?php if($val['fulfillment_channel']=='AMAZON_NA') {echo 'disabled value="'.$val['qty'].'"';} else {echo 'value="'.$val['qty'].'"';}?> name="qty" type="text"></td>
              <td><?php if($val['bb']=='yes') echo 'You have buybox';
else echo sprintf('%.2f',$val['c1']); ?></td>
              <td><?php echo sprintf('%.2f',$val['bb_price']); ?></td>
              <!--      <td><input style="width:100px" name="maxorderqty" type="text" value="<?php echo $val['maxorderqty']; ?>"></td>
                <td><input style="width:100px" name="map_price" type="text" value="<?php echo sprintf('%.2f',$val['map_price']); ?>"></td>    -->
              <td><input maxlength="15" class="list-change" style="width:100px" <?php if($val['fulfillment_channel']=='AMAZON_NA') echo 'disabled';?> name="ship_price" type="text" value="<?php echo $val['ship_price'] ;?>"></td>
              <!--  <td><input style="width:100px" name="status" type="text" readonly value="<?php echo $val['status']; ?>"></td>
                <td>
                  <span id="<?php echo $val['sku'];?>" data-id="<?php echo $val['sku'] ?>" title="Edit" class="glyphicon glyphicon-pencil" data-toggle="modal" data-target="#<?php echo $val['sku'];?>"></span>   
                  <span sellerid="<?php echo $val['sellerid'];?>" title="Save" class="glyphicon glyphicon-saved save_button" id="<?php echo $val['sku'];?>"></span>               
                </td>
                  -->
              <td>
                <button myskuid="<?php echo $val['sku'];?>"  marketplaceid="<?php echo $val['marketplaceid'];?>"  sellerid="<?php echo $val['sellerid'];?>" class="btn" data-id="<?php echo md5(trim($val['sku'])); ?>" data-toggle="modal" data-target="#<?php echo md5(trim($val['sku']));?>" type="button" value="edit" style="border-radius:0px;font-size:11px">Edit</button>
              </td>
            </tr>
            <?php }} ?>
            </tbody>	
          </table>
        </div>	
      </div>
      <div class="box-pagination">
        <div class="col-md-12 text-center">
          <?php echo isset($pagination)?$pagination:''; ?>
        </div>
      </div>
      <!--
        <div class="box-pagination">
          <div class="showing-entry">Showing 1 to 25 of 27 entries</div>		
          <ul class="pagination">
            <li><a title="Prev" href="#" class="btn-prv">< Prev</a></li>
            <li class="current"><a title="1" href="#">1</a></li>
            <li><a title="2" href="#">2</a></li>
            <li><a title="3" href="#">3</a></li>
            <li><a title="4" href="#">4</a></li>
            <li><a title="5" href="#">5</a></li>
            <li><a title="6" href="#">6</a></li>				
            <li><a title="Next" href="#" class="btn-prv">Next ></a></li>
          </ul>				
        </div>                           -->
      <div class="clearF"></div>
    </div><!--Content Closing-->
  </div><!--Content Closing-->
  <?php include_once('edit.php'); ?>
</div>	
</article>

<?php include_once('footer.php'); ?>

