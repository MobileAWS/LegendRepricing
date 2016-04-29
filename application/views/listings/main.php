<?php
$this->load->view('repricing/header');
$this->load->view('repricing/nav-inner-admin');
?>
<div class="container" id="amazon-listing-table">	
    <div id="content">
        <div class="content">
            <div class="table-box">
                <div class="content show-entry">
                    <h1>Repricing Demo</h1>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="example">
                        <thead>
                          <!--   <th>#</th>  -->
                        <th><input type="checkbox" id="selectAll" name="list-table-all"></th>
                        <th>SKU</th>
                        <th>Title</th>
                        <th>Condition</th>
                        <th>Channel</th>
                        <th data-toggle="tooltip" title="Set delete to delete the restriction"> Min Price</th>
                        <th>Max Price</th>
                        <th>Your Price</th>                      
                        <th>Amazon fees</th>                                
                        <th>Qty</th>      
                        <th>Competition</th>
                        <th>Buy Box</th>
                        <th>Shipping</th>
                        <th>    
                            <button disabled class="btn" type="button" onclick="alert('Hello world!')">Save ALL!</button>
                        </th>
                        </thead>
                        <tbody> 
                            <?php
                            if (isset($user_listings)) {
                                $i = 0;
                                foreach ($user_listings->result_array() as $val) {
                                    $i++;
                                    ?>
                                        <!--   <tr rowid="<?php echo $val['sku'] . '@' . $val['sellerid']; ?>">-->
                                    <tr>
                                        <td><input type="checkbox" name="list-table" value="<?php echo $val['sku']; ?>"></td>
                                        <!--                <td><?php echo ($page + $i); ?></td>  -->
                                        <td><?php echo $val['sku'] ?></td>
                                        <td><a style=" width: 200px; display: inline-block; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;" target = "_blank" class="listing-title ellipsis" href="<?php echo $amazon_url . $val['asin']; ?>"><?php echo $val['itemname']; ?></a></td>
                                        <!--   <td><?php echo $val['item_condition'] . '/' . $val['item_subcondition'] ?></td> -->
                                        <td><?php echo ucfirst($val['item_condition']); ?></td>
                                        <td><?php
                                            if ($val['fulfillment_channel'] == 'AMAZON_NA')
                                                echo 'FBA';
                                            else
                                                echo 'Seller';
                                            ?></td>
                                        <td><input maxlength="15" class="list-change" style="width:100px" name="min_price" type="text" value="<?php echo sprintf('%.2f', $val['min_price']); ?>"></td>
                                        <td><input maxlength="15" class="list-change" style="width:100px" name="max_price" type="text" value="<?php echo sprintf('%.2f', $val['max_price']); ?>"></td>
                                        <td><input maxlength="15" class="list-change"  style="width:100px" name="price" type="text" value="<?php echo (sprintf('%.2f', $val['price'])); ?>"></td>
                                        <td><?php echo $val['fees']; ?></td>
                                        <td><input maxlength="10" class="list-change" style="width:100px" <?php
                                                   if ($val['fulfillment_channel'] == 'AMAZON_NA') {
                                                       echo 'disabled value="' . $val['qty'] . '"';
                                                   } else {
                                                       echo 'value="' . $val['qty'] . '"';
                                                   }
                                                   ?> name="qty" type="text"></td>
                                        <td><?php
                                    if ($val['bb'] == 'yes')
                                        echo 'You have buybox';
                                    else
                                        echo unserialize($val['c1']);
                                    ?></td>
                                        <td><?php echo sprintf('%.2f', $val['bb_price']); ?></td>
                                        <!--      <td><input style="width:100px" name="maxorderqty" type="text" value="<?php echo $val['maxorderqty']; ?>"></td>
                                          <td><input style="width:100px" name="map_price" type="text" value="<?php echo sprintf('%.2f', $val['map_price']); ?>"></td>    -->
                                        <td><input maxlength="15" class="list-change" style="width:100px" <?php if ($val['fulfillment_channel'] == 'AMAZON_NA') echo 'disabled'; ?> name="ship_price" type="text" value="<?php echo $val['ship_price']; ?>"></td>
                                        <!--  <td><input style="width:100px" name="status" type="text" readonly value="<?php echo $val['status']; ?>"></td>
                                          <td>
                                            <span id="<?php echo $val['sku']; ?>" data-id="<?php echo $val['sku'] ?>" title="Edit" class="glyphicon glyphicon-pencil" data-toggle="modal" data-target="#<?php echo $val['sku']; ?>"></span>   
                                            <span sellerid="<?php echo $val['sellerid']; ?>" title="Save" class="glyphicon glyphicon-saved save_button" id="<?php echo $val['sku']; ?>"></span>               
                                          </td>
                                        -->
                                        <td>
                                            <button myskuid="<?php echo $val['sku']; ?>"  marketplaceid="<?php echo $val['marketplaceid']; ?>"  sellerid="<?php echo $val['sellerid']; ?>" class="btn" data-id="<?php echo md5(trim($val['sku'])); ?>" data-toggle="modal" data-target="#<?php echo md5(trim($val['sku'])); ?>" type="button" value="edit" style="border-radius:0px;font-size:11px">Edit</button>
                                        </td>
                                    </tr>
    <?php }
}
?>
                        </tbody>	
                    </table>
                </div>	
            </div>
            <div class="box-pagination">
                <div class="col-md-12 text-center">
<?php echo isset($pagination) ? $pagination : ''; ?>
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
</div>	
</article>

<?php $this->load->view('repricing/footer.php'); ?>

