  <div class="container-fluid table-responsive">
<!--<button type="button" class="btn btn-primary btn-lg">Refresh</button>-->
<p class="alert alert-success"><b>Note:</b>The reports will be automatically generated after 30 minutes So new listing wil be shown here after 30 minutes</li>
Yo can also set delete for min-price and max_price to deltete the restriction .</p>
<a href="<?php echo base_url("content/listings");?>" class="btn btn-primary">Refresh/All listings</a>
<a href="<?php echo base_url("content/listings_active");?>" class="btn btn-primary">Active listings</a>
<a href="<?php echo base_url("content/listings_bb");?>" class="btn btn-primary">Buybox listings</a>
<a href="<?php echo base_url("content/listings_nbb");?>" class="btn btn-primary">Non Buybox listings</a>
<a href="<?php echo base_url("content/listings_compare");?>" class="btn btn-primary">Price Map Overview</a>


<hr>
      <table id="myTable" class="table table-striped table-hover table-bordered dataTable " >
      <caption><h1><?= $table_caption;?></h1> </caption>
  <thead>  
    <tr>  
      <th>item name</th>  
      <th class="col-lg-1">sku</th>  
      <th data-toggle="tooltip" title="(excluding shipping rate)">price</th>  
      <th>asin</th>  
      <th data-toggle="tooltip" title="Competitor name/Price">C1</th>  
      <th data-toggle="tooltip" title="Competitor name/Price">C2</th>  
      <th data-toggle="tooltip" title="Competitor name/Price">C3</th>  
      <th data-toggle="tooltip" title="Competitor name/Price">C4</th>  
      <th data-toggle="tooltip" title="Competitor name/Price">C5</th>  
      <th data-toggle="tooltip" title="Competitor name/Price">C6</th>  
      <th data-toggle="tooltip" title="Competitor name/Price">C7</th>  
      <th data-toggle="tooltip" title="Competitor name/Price">C8</th>  
      <th data-toggle="tooltip" title="Competitor name/Price">C9</th>  
      <th data-toggle="tooltip" title="Competitor name/Price">C10</th>  
      </tr>  
      </thead>
<tbody>
<?php
if($user_listings)
{
  $content='';
  $count=1;
    foreach($user_listings->result_array() as $row) {
      $content.="<tr>";
      $content.=  '<td><a target = "_blank"  href="'.$amazon_url.$row['asin'].'">'.$row['itemname'].'</a></td>';
      $content.=  '<td>'.$row['sku'].'</td>';
      $content.=  '<td>'.$currency.'<span id='.$row["sellerid"].'@'.$row["sku"].' key="price" class="xedit editable editable-click text-danger"><b>'.$row['price'].'</b></span></td>';
      $content.=  '<td>'.$row['asin'].'</td>';
      $myarray=unserialize($row['c1']);
      if(isset($myarray))
      {
        foreach($myarray as $my)
        $content.=  '<td>'.explode("/",$my)[0].'/'.explode("/",$my)[1].'</td>';
      }
      $content.="</tr>";
      $count+=1;
    }
  echo $content;
}
?>
</tbody>
</table>  
</div>
</body>
</html> 
