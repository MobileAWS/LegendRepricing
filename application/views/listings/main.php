<?php
$this->load->view('repricing/header');
$this->load->view('repricing/nav-inner-admin');
$forumulas = array('formula','beatby','beatmeby','matchprice');
?>

<div class="container" id="amazon-listing-table">	
    <div id="content">
        <div class="content">
            <div class="table-box">
                <form id="reprice" name="reprice" method="post">
                <div class="content show-entry">
                    <div style="font-size:14px;font-weight: bold; margin:10px; float: left">Repricing Playground</div>
                    <button name="reprice" value="reprice" style="float:right; margin-right: 10px; margin-top: 4px;" type="submit">Reprice</button>
                    
                    <?php if($reprice) {?>
                    <a style="float:right; margin-right: 10px; margin-top: 10px; font-size: 14px;" href="<?php echo base_url("listings");?>">Reset</a>
                    <?php  } ?>
                    
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
                        <th>Shipping</th>
                        <?php if($reprice) {?>
                        <th>New Price</th>   
                        <?php } ?>
                        <th>Qty</th>      
<!--                        <th>Comp</th>-->
                        <th>Buy Box</th>
                        
                        <th>Formula</th>
                        </thead>
                        <tbody> 
                            <?php
                            if (isset($listing)) {
                                $i = 0;
                                foreach ($listing as $val) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><input <?php echo $reprice ? 'checked' : ''; ?> type="checkbox" name="data[<?php echo $val['id'];?>][sku]" value="<?php echo $val['sku'];?>"></td>
                                        <td><div style="width: 50px;"><?php echo $val['sku'] ?></div></td>
                                        <td><a style=" width: 150px; display: inline-block; white-space: nowrap; text-overflow: ellipsis; overflow: hidden;" target = "_blank" class="listing-title ellipsis" href="<?php echo $amazon_url . $val['asin']; ?>"><?php echo $val['itemname']; ?></a></td>
                                        <td><?php echo ucfirst($val['item_condition']); ?></td>
                                        <td><?php
                                            if ($val['fulfillment_channel'] == 'AMAZON_NA')
                                                echo 'FBA';
                                            else
                                                echo 'Seller';
                                            ?></td>
                                        <td><input maxlength="15" class="list-change" style="width:70px" name="data[<?php echo $val['id'];?>][min_price]" type="text" value="<?php echo sprintf('%.2f', $val['min_price']); ?>"></td>
                                        <td><input maxlength="15" class="list-change" style="width:70px" name="data[<?php echo $val['id'];?>][max_price]" type="text" value="<?php echo sprintf('%.2f', $val['max_price']); ?>"></td>
                                        <td><input maxlength="15" class="list-change"  style="width:70px" name="data[<?php echo $val['id'];?>][price]" type="text" value="<?php echo (sprintf('%.2f', $val['price'])); ?>"></td>
                                        <td><input maxlength="15" class="list-change" style="width:70px" <?php if ($val['fulfillment_channel'] == 'AMAZON_NA') echo 'disabled'; ?> name="data[<?php echo $val['id'];?>][ship_price]" type="text" value="<?php echo $val['ship_price']; ?>"></td>
                                        <?php if($reprice) {?>
                                        <td><?php 
                                        if( $val['new_price'] ){
                                            echo sprintf('%.2f', $val['new_price']); 
                                        }else{
                                            echo "--";
                                        }
                                        ?></td>
                                        <?php } ?>
                                        <td><input maxlength="10" class="list-change" style="width:80px" <?php
                                            if ($val['fulfillment_channel'] == 'AMAZON_NA') {
                                                echo 'disabled value="' . $val['qty'] . '"';
                                            } else {
                                                echo 'value="' . $val['qty'] . '"';
                                            }
                                            ?> name="data[<?php echo $val['id'];?>][qty]" type="text"></td>
<!--                                        <td><?php
                                            if ($val['bb'] == 'yes')
                                                echo 'You have buybox';
                                            else
                                                echo unserialize($val['c1']);
                                            ?></td>-->
                                        <td><?php 
                                        echo sprintf('%.2f', $val['bb_price']); 
                                         if ($val['bb'] == 'yes'){
                                                echo " (Yes)";
                                         }
                                        ?></td>

                                        <td>
                                            <select name="data[<?php echo $val['id'];?>][beatby]" style="width:80px">
                                                <?php foreach($forumulas as $f){
                                                    $selected = $f == $val['beatby'] ? 'selected=selected' : '';
                                                ?>
                                                <option <?php echo $selected?> value="<?php echo $f?>"><?php echo $f?></option>>
                                                <?php } 
                                                
                                                if( true || in_array($val['beatby'],array('beatby','beatmeby')) ){
                                                ?>
                                                <input maxlength="10" class="list-change" style="width:60px; margin-left: 5px;" name="data[<?php echo $val['id'];?>][beatbyvalue]" type="text" value="<?php echo sprintf('%.2f', $val['beatbyvalue']); ?>">
                                                <?php } ?>
                                                
                                                
                                            </select>
                                        </td>
                                    </tr>
                                <?php
                                }
                            }
                            ?>
                        </tbody>	
                    </table>
                </div>	
                </form>
            </div>
            <div class="box-pagination">
                <div class="col-md-12 text-center">
                </div>
            </div>
            <div class="clearF"></div>
        </div><!--Content Closing-->
    </div><!--Content Closing-->
</div>	

<?php $this->load->view('repricing/footer.php'); ?>

