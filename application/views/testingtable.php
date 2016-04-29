<!--<html>
<head>
<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">   
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<link rel="stylesheet" 
href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
<link href="dataTables.responsive.css" rel="stylesheet">   
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
<script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> 
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script type="text/javascript" src="datatables.responsive.js"></script>
 
<script>      
jQuery(document).ready(function() {
    $.fn.editable.defaults.mode = 'popup';
    $('.xedit').editable();
    $(document).on('click','.editable-submit',function(){
      var x = $(this).closest('td').children('span').attr('id');
      var y = $('.input-sm').val();
      var z = $(this).closest('td').children('span');
      $.ajax({
        url: "process.php?id="+x+"&data="+y,
        type: 'GET',
        success: function(s){
        if(s == 'status'){
        $(z).html(y);}
        if(s == 'error') {
        alert('Error Processing your Request!');}
        },
error: function(e){
alert('Error Processing your Request!!');
}
});
      });
});                    
$(document).ready(function(){
        $('#myTable').dataTable({responsive: true});
        });
</script>
</head>
<body> -->
<div class="container-fluid table-responsive">
      <table id="myTable" class="table table-striped table-hover table-bordered " >
  <thead>  
    <tr>  
      <th>ENO</th>  
      <th>EMPName</th>  
      <th>Country</th>  
      <th>Salary</th>  
      <th>Status</th>  
      <th>Status11</th>  
    </tr>  
  </thead>  
  <tbody>  
<?php
$data='
<tr>  
<td>
<input type="text"  value="001"</input>  
</td>
    <td>Anusha</td>  
    <td>India</td>  
    <td>10000</td>    <td>
    <button type="button" class="btn btn-primary btn-large btn-block disabled">Inactive</button>
    </td>
    <td>
    <button type="button" class="btn btn-primary btn-large btn-block">Save</button>
    </td>           
  </tr>  
  <tr>  
    <td>002</td>  
    <td>Charles</td>  
    <td>United Kingdom</td>  
    <td>28000</td>  
    <td>
    <button type="button" class="btn btn-primary btn-large btn-block disabled">Inactive</button>
    </td>
    <td>
    <button type="button" class="btn btn-primary btn-large btn-block">Save</button>
    </td>
  </tr>  
  <tr>  
    <td>003</td>  
    <td>Sravani</td>  
    <td>Australia</td>  
    <td>7000</td>  
  </tr>  
  <tr>  
    <td>004</td>  
    <td>Amar</td>  
    <td>India</td>  
    <td>18000</td>  
  </tr>  
  <tr>  
    <td>005</td>  
    <td>Lakshmi</td>  
    <td>India</td>  
    <td>12000</td>  
  </tr>  
  <tr>  
    <td>006</td>  
    <td>James</td>  
    <td>Canada</td>  
    <td>50000</td>  
  </tr>  

  <tr>  
    <td>007</td>  
    <td>Ronald</td>  
    <td>US</td>  
    <td>75000</td>  
  </tr>  
  <tr>  
    <td>008</td>  
    <td>Mike</td>  
    <td>Belgium</td>  
    <td>100000</td>  
  </tr>  
  <tr>  
    <td>009</td>  
    <td>Andrew</td>  
    <td>Argentina</td>  
    <td>45000</td>  
  </tr>  

  <tr>  
    <td>010</td>  
    <td>Stephen</td>  
    <td>Austria</td>  
    <td>30000</td>  
  </tr>  
  <tr>  
    <td>011</td>  
    <td>Sara</td>  
    <td>China</td>  
    <td>750000</td>  
  </tr>  
  <tr>  
    <td>012</td>  
    <td>JonRoot</td>  
    <td>Argentina</td>  
    <td>65000</td>  
    </tr>';
?>
<?php echo $data; ?>
  </tbody>  
</table>  
</div>
</body>
</html>
