
  <div class="panel panel-default">
    <div class="panel-heading">
      <p>  <label for="text" class="col-sm-2 control-label">
        <h1> Accounts:
        </h1>

      </label>
      </p>
    </div>

    <div class="panel-body">
      <div class="row">
        <div class="col-md-12">
          <div class="table">
            <table border="1" class="table table-striped table-hover  table-bordered">
<thead>
<th>
#
</th>
<th>
seller id
</th>
<th>
marketplace 
</th>
<!--
<th>
mws auth token
</th>--> <th>
GBS 
</th>
<th>
GBS value
</th>
<th>
Report frequency
</th>
<th>
Actions
</th>
</thead>
<tbody>
   <?php if(isset($user_settings_full)){ $i=0;foreach($user_settings_full->result_array()  as $val){ $i++; ?>
              <tr>
                <td><?php echo $i;?></td>    <td><?php echo $val['sellerid'];?></td>    <td><?php echo $val['marketplaceid']=='ATVPDKIKX0DER'?'amazon.com':'amazon.ca';?></td> <!--   <td><?php echo $val['mwsauthtoken'];?></td>--><td><?php echo $val['beatby'];?></td>      <td><?php echo $val['beatbyvalue'];?></td>      <td><?php echo $val['reports'];?></td>
 <td>
 <button  marketplaceid="<?php echo $val['marketplaceid'];?>"  sellerid="<?php echo $val['sellerid'];?>" class="btn" data-id="<?php echo md5(trim($val['sellerid'].$val['marketplaceid'])); ?>" data-toggle="modal" data-target="#<?php echo md5(trim($val['sellerid'].$val['marketplaceid']));?>" type="button" value="edit" style="border-radius:0px;font-size:11px">Edit</button>
 <button  data-marketplaceid="<?php echo $val['marketplaceid'];?>"  data-sellerid="<?php echo $val['sellerid'];?>" class="btn btn-danger delete-seller" data-id="<?php echo md5(trim($val['sellerid'].$val['marketplaceid'])); ?>" type="button" value="delete" style="border-radius:0px;font-size:11px">Delete</button>
</td> 
              </tr>
<?php }} ?>
</tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {  
  $(".editrow").on("click", function(){
    var $killrow = $(this).parent('tr');
    $killrow.addClass("danger");
    $killrow.fadeOut(2000, function(){
      $(this).remove();
    });});
    
    $("button.delete-seller").on("click",function(){
        if( !confirm("Are you sure you want to delete this seller?\n\n****This action can not be undone****") ){
            return;
        }
        sellerid = $(this).data('sellerid');
        del_url = "<?php echo base_url().'content/delete_settings/';?>"+sellerid;
        $.get(del_url,function(data){
            if( data != 'Deleted'){
                alert('Something went wrong contact admin.');
                return;
            }
            window.location.reload();
        });
    });



});

</script>

