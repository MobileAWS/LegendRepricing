<div id="loadingDiv">
    <div>
        <h7>Please wait...</h7>
    </div>
</div>
<footer>
    <div class="container">
        <div class="btn-backTotop"> <a href="#home" title="Back To Top" class="scroll"><i class="fa fa-chevron-up"></i>top</a> </div>
        <div class="row box-footer">
            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 box-aboutUs">
                <h6>legend repricing</h6>
                <p>The Best Repricing software on the market from a firm that listens to its customers. Capture market share and profits now you can have both volume and profits.</p>
            </div>
<!--
            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                <h5>Quick links</h5>
                <ul class="list-footermenu">
                    <li><a href="<?=base_url();?>home/about" title="About Us">About us</a></li>
                    <li><a href="<?=base_url();?>home/faq" title="Product Help">Product Help</a></li>
                    <li><a href="<?=base_url();?>home/contact" title="Contact Us">Contact Us</a></li>
                </ul>
            </div>  -->
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <p>copyright &copy; Legend Repricing <?php echo date('Y'); ?></p>
        </div>
    </div>
    </div>
</footer>
<link rel="shortcut icon" href="<?=base_url();?>asset/images_d/favicon.ico" type="image/x-icon" />
<!--<script type="text/javascript" language="javascript" src="<?=base_url();?>asset/js_d/jquery.tabledit.js"></script>-->
<script type="text/javascript" language="javascript" src="<?=base_url();?>/asset/js_d/bootstrap/bootstrap.min.js"></script> 
<script type="text/javascript" language="javascript" src="<?=base_url();?>/asset/js_d/html5shiv.js"></script> 
<!--<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script> 
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script> -->
<script type="text/javascript" language="javascript" src="<?=base_url();?>/asset/js_d/custom.js"></script>
<!-- js include for text rotation -->
<script type="text/javascript" language="javascript" src="<?=base_url();?>asset/js_d/jquery.simple-text-rotator.min.js"></script>
<script type="text/javascript" language="javascript" src="<?=base_url();?>asset/js_d/manage-rotator.js"></script>


<script src="<?=base_url();?>asset/js_d/bootstrap-dialog.js"></script> 
<link href="<?=base_url();?>asset/css_d/bootstrap-dialog.css" rel="stylesheet">   
<script>
$(document).ready(function() {  

  $(document).on('click', function(e) {  
    toastr.clear();

      });
  $('#loadingDiv').hide();
  function myinit()
  {
  var inputs = $('input[type="text"],select,textarea').each(function() {
        $(this).data('original', this.value);
  }); 
  }  
  myinit();
  $(document).on("click", ".checking a" , function(e) {
    e.stopPropagation();
   e.preventDefault();
   var pageno=$(this).attr('href');
  if(pageno!='#')
   {
     var thenum = pageno.replace( /^\D+/g, ''); 
     if(!thenum)
       thenum=0;
  var col_direction=$(this).attr('col-direction');
  var col_name=$(this).attr('col-name');
    var search_text=$('#search_text').val(); 
    var account_sellerid=$('#account_sellerid').val(); 
   var filter_text=$('input[name="editList"]:checked:first').val(); 
    var filter_text1=$('input[name="editList1"]:checked:first').val();           
    var pagesize=$('#pagesize').val();
      $('#loadingDiv').show();
             $.ajax({
        url: "<?= site_url('content/listings_minify');?>",
          type: "POST",
          datatype:"html",
          data: {'account_sellerid':account_sellerid,'pageno':thenum,'pagesize':pagesize,'col_direction':col_direction,'col_name':col_name,'search_text':search_text,'channel_type':filter_text1,'status':filter_text},
          cache :false,
          success : function(response) {
           // if(response.match(/Success/))
//            alert('oops');
              {
            ///    toastr.success('Thank You ..Your listings table will be populated shortly');
              //  $("body").html(response);
                $("#amazon-listing-table").replaceWith(response);
                myinit();
     $('#loadingDiv').hide();
              }
             // else
              {
             //   toastr.error(response);
            }                                   
          }
             });  
   }    
});  
                  
  $(document).on("click", ".col-inactive" , function(e) {
    e.stopPropagation();
   e.preventDefault();
  var col_direction=$(this).attr('col-direction');
  var col_name=$(this).attr('col-name');
    var search_text=$('#search_text').val(); 
    var account_sellerid=$('#account_sellerid').val(); 
   var filter_text=$('input[name="editList"]:checked:first').val(); 
    var filter_text1=$('input[name="editList1"]:checked:first').val();           
    var pagesize=$('#pagesize').val();
  ///  var pageno=$('.pagination').val();
    var pageno=0;
      $('#loadingDiv').show();
             $.ajax({
        url: "<?= site_url('content/listings_minify');?>",
          type: "POST",
          data: {'account_sellerid':account_sellerid,'pageno':pageno,'pagesize':pagesize,'col_direction':col_direction,'col_name':col_name,'search_text':search_text,'channel_type':filter_text1,'status':filter_text},
          cache :false,
          success : function(response) {
         //   if(response.match(/Success/))
              {
              //  $("body").html(response);
                $("#amazon-listing-table").replaceWith(response);
                myinit();
            ///    toastr.success('Thank You ..Your listings table will be populated shortly');
      $('#loadingDiv').hide();
              }
             // else
              {
           //     toastr.error(response);
            }                                   
          }
      });                                   
     // $('#loadingDiv').hide();
});  


$(document).on('click','#selectAll',function(e){
      var table= $(e.target).closest('table');
          $('td input:checkbox',table).prop('checked',this.checked);
});                      
$(document).on('change','.edit_gbs',function(e) { 
  var obj=  $(this).val();        
    if(obj=='beatby')
    {
      $(this).closest('.edit_form').find('.gbs_beatby').show();
      $(this).closest('.edit_form').find('.gbs_beatmeby').hide();
      $(this).closest('.edit_form').find('.gbs_formula').hide();
      $(this).closest('.edit_form').find('.gbs_matchprice').hide();
    }             
    if(obj=='beatmeby')
    {
      $(this).closest('.edit_form').find('.gbs_beatby').hide();
      $(this).closest('.edit_form').find('.gbs_beatmeby').show();
      $(this).closest('.edit_form').find('.gbs_formula').hide();
      $(this).closest('.edit_form').find('.gbs_matchprice').hide();
    }              
    if(obj=='formula')
    {
      $(this).closest('.edit_form').find('.gbs_beatby').hide();
      $(this).closest('.edit_form').find('.gbs_beatmeby').hide();
      $(this).closest('.edit_form').find('.gbs_formula').show();
      $(this).closest('.edit_form').find('.gbs_matchprice').hide();
    }              
    if(obj=='matchprice')
    {
      $(this).closest('.edit_form').find('.gbs_beatby').hide();
      $(this).closest('.edit_form').find('.gbs_beatmeby').hide();
      $(this).closest('.edit_form').find('.gbs_formula').hide();
      $(this).closest('.edit_form').find('.gbs_matchprice').show();
    }                   
});       
$(document).on('change','.beat_amazon_flag',function(e) { 
  var obj=  $(this).val();        
    if(obj=='no')
    {
      $(this).closest('.edit_form').find('.beat_amazon').attr('disabled','disabled');
    }             
    else
    {
      $(this).closest('.edit_form').find('.beat_amazon').removeAttr('disabled');
    }
});      
$(document).on('change','.gbs_settings',function(e) { 
    var obj=  $(this).val();
    if(obj=='beatby')
    {
      $('.gbs_settings_beatby').removeAttr('disabled');
       $('.gbs_settings_beatby').val("0.00");
    }             
    if(obj=='beatmeby')
    {
      $('.gbs_settings_beatby').removeAttr('disabled');
       $('.gbs_settings_beatby').val("0.00");
    }              
    if(obj=='formula')
    {
      $('.gbs_settings_beatby').attr('disabled','disabled');
       $('.gbs_settings_beatby').val("Use our secret formula");
    }              
    if(obj=='matchprice')
    {
      $('.gbs_settings_beatby').attr('disabled','disabled');
       $('.gbs_settings_beatby').val("0.0");
    }                   
});                                     
 $(document).on('change','#gbs',function(e) { 
    var obj=  $(this).val();
    if(obj=='beatby')
    {
      $('#gbs_beatby').removeAttr('disabled');
       $('#gbs_beatby').val("0.00");
    }             
    if(obj=='beatmeby')
    {
      $('#gbs_beatby').removeAttr('disabled');
       $('#gbs_beatby').val("0.00");
    }              
    if(obj=='formula')
    {
      $('#gbs_beatby').attr('disabled','disabled');
       $('#gbs_beatby').val("Use our secret formula");
    }              
    if(obj=='matchprice')
    {
      $('#gbs_beatby').attr('disabled','disabled');
       $('#gbs_beatby').val("0.0");
    }                   
});             
$(document).on('input','.list-change',function(e) { 
  e.stopPropagation();
  e.preventDefault();       
  var mysku= $(this).closest('tr').find('button').attr('myskuid');
  var mysellerid= $(this).closest('tr').find('button').attr('sellerid');
  var mymarketplaceid= $(this).closest('tr').find('button').attr('marketplaceid');
  var row={};
  $(this).closest('tr').find('input[type=text],select,textarea').each(function(){
    if ($(this).data('original') !== this.value)
      row[$(this).attr('name')]=$(this).val();
  })
    if(jQuery.isEmptyObject(row))
    {
      $(this).css("color", "black");
      var obj=  $(this).closest('tr').find('button');
      $(obj).css("background-color", "#399ccd");
      $(obj).html("Edit");
      $(obj).removeClass('save_button');
      $(obj).attr("data-target","#"+md5(mysku.trim()));          
    } 
    else
    {
  $(this).css("color", "red");
  var obj=  $(this).closest('tr').find('button');
  $(obj).css("background-color", "orange");
  $(obj).html("Save");
  $(obj).removeClass('save_button').addClass('save_button');
  $(obj).attr("data-target","");
    }
   
});
  $(document).on('change','.filters,input[name="editList1"]:radio,input[name="editList"]:radio',function(e) {
  //  var pageno=$('#pagesize').val();

    e.stopPropagation();
   e.preventDefault();
    var pageno=0;
    var pagesize=$('#pagesize').val();
 //   var col_direction="<?php isset($col_direction)?$col_direction:'asc' ;?>";
  //  var col_name="<?php isset($col_name)?$col_name:'itemname'; ?>";
  var col_direction=$(this).attr('col-direction');
  var col_name=$(this).attr('col-name');
    var search_text=$('#search_text').val(); 
    var filter_text=$('input[name="editList"]:checked:first').val(); 
    var account_sellerid=$('#account_sellerid').val(); 
    var filter_text1=$('input[name="editList1"]:checked:first').val(); 
      $('#loadingDiv').show();
                  $.ajax({
        url: "<?= site_url('content/listings_minify');?>",
          type: "POST",
          data: {'account_sellerid':account_sellerid,'pageno':pageno,'pagesize':pagesize,'col_direction':col_direction,'col_name':col_name,'search_text':search_text,'channel_type':filter_text1,'status':filter_text},
          cache :false,
          success : function(response) {
          //  if(response.match(/Success/))
              {
                $("#amazon-listing-table").replaceWith(response);
                myinit();
      $('#loadingDiv').hide();
             //   toastr.success('Thank You ..Your listings table will be populated shortly');
              }
            //  else
              {
              //  toastr.error(response);
            }                                   
          }
      });                                   
  });

  //  $("table").tablesorter(); 
      $("#trigger-link").click(function() { 
                // set sorting column and direction, this will sort on the first and third column the column index starts at zero 
                var sorting = [[0,0],[2,0]]; 
                        // sort on the first column 
                        $("table").trigger("sorton",[sorting]); 
                        // return false to stop default link action 
                        return false; 
                            }); 
   $("#beatby").keydown(function(eve){
         var keyCodeEntered = eve.keyCode? eve.keyCode : eve.charCode;

             if (keyCodeEntered == 8) 
                   {
                              $(this).val("");
                                       return false;
                                   }
                  return true;
               });
  toastr.options = {
    "closeButton": true,
      "debug": false,
      "newestOnTop": true,
      "progressBar": false,
      "positionClass": "toast-top-center",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "3000",
      "hideDuration": "1000",
      "timeOut": "0",
      "extendedTimeOut": "0",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
  } 
        $(document).on('click','#submit_settings',function(e){
      var datastring = $("#form_settings").serialize();
    {                   
      $('#loading').show();
      $.ajax({
        url: "<?= site_url('content/save_settings');?>",
          type: "POST",
          data: datastring,
          cache :false,
          success : function(response) {
            if(response.match(/Success/))
              {
                toastr.success('Thank You ..Your listings table will be populated shortly');
                  window.setTimeout(function(){location.reload()},5000)
                 ///   location.reload();

              }
              else
              {
                toastr.error(response);
            }                                   
          }
      });
      $('#loading').hide();
    }
        });  
        $(document).on('click','.edit_settings_button',function(e){
       //   e.stopPropagation();
         // e.preventDefault();
          var datastring = $(this).closest(".edit_settings_form").serialize();
          console.log(datastring);
          $.ajax({
            url: "<?= site_url('content/save_settings');?>",
              type: "POST",
              data: datastring,
              cache :false,
              success : function(response) {
                if(response.match(/Success/))
                {
                  toastr.success('It will take some time to actually reflect the changed record');
                  window.setTimeout(function(){location.reload()},3000)
                }
                else
                {
                  toastr.error(response);
                }
              }
          });
        });                           
 
  $(document).on('click','.save_button',function(e){
    e.stopPropagation();
    e.preventDefault();
    /*
    var pass=$('#signuppass').val();
    var email=$('#signupemail').val();
    if( !isValidEmailAddress( email ) )
    {
      toastr.error("Invalid email address");
      return;
    }
    if(!pass.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/))
    {
      toastr.error("Password must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters");
  }
    else
     */
    var mysku=$(this).attr('myskuid');
    var mysellerid=$(this).attr('sellerid');
    var mymarketplaceid=$(this).attr('marketplaceid');
    {          
      var row={};
      $(this).closest('tr').find('input[type=text],select,textarea').each(function(){
          if ($(this).data('original') !== this.value)
        row[$(this).attr('name')]=$(this).val();
      })
      //  console.log(row);
        if(jQuery.isEmptyObject(row))
      {
///        alert('empty  row values');
        toastr.error('It seems the values are not changed');
        return;
      }
      row['sku']=mysku;
      row['sellerid']=mysellerid;
      row['marketplaceid']=mymarketplaceid;
      /*
      if(!(row['price']!=undefined))
      {
        //  alert('validation');
        if(row['min_price']!=undefined || row['max_price']!=undefined)
        {
          var cur_price=  $(this).closest('tr').find('input[name=price]').val();
          var min_price=  $(this).closest('tr').find('input[name=min_price]').val();
          var max_price=  $(this).closest('tr').find('input[name=max_price]').val();
          var r= BootstrapDialog.confirm("Current price is "+cur_price+", set current price vary between "+min_price+" and "+max_price+"",function(result){
            if(result) {
            }else {
              return true;
            }
          });
        }
    }
       */
      {                   
        //      $('#loading').show();
        $.ajax({
          url: "<?= site_url('content/process');?>",
            type: "POST",
            data: row,
            cache :false,
            success : function(response) {
              if(response.match(/Success/))
              {
                //  toastr.error(response);
         //       var newdata = "<?php echo site_url('content/listings');?>";
           //     window.location.assign(newdata);
                toastr.success('It will take some time to actually reflect the changed record on amazon site.Refreshing the page in 5 seconds');
                  window.setTimeout(function(){location.reload()},5000)
//                setTimeout(location.reload, 6000);
              }
              else
              {
                toastr.error(response);
            }
          }
      });
      //    $('#loading').hide();
    }
    }
  });                                      
  $(document).on('click','.edit_button',function(e){
    e.stopPropagation();
    e.preventDefault();
    /*
    var pass=$('#signuppass').val();
    var email=$('#signupemail').val();
    if( !isValidEmailAddress( email ) )
    {
      toastr.error("Invalid email address");
      return;
    }
    if(!pass.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/))
    {
      toastr.error("Password must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters");
    }
    else
     */
              {                  
                var row={};
                $(this).closest('.edit_form').find('input,select,textarea').each(function(){
                  if ($(this).data('original') !== this.value)
                  { 
                    var str=  $(this).attr('name');
                    if(str.match(/gbs_/g))
                    {
                    row['beatbyvalue']=$(this).val();
                    }
                    else
                    row[$(this).attr('name')]=$(this).val();
                  }
                });
                if(jQuery.isEmptyObject(row))
                {
                 // alert('empty  row values');
                  return;
                }                                 
                if(Object.keys(row).length<=3)
                {
                toastr.error('Havent changed anything?');
                  return;
                }
                //      var name = $(this).closest('#edit_form');
                //     var datastring =  $(this).closest('#edit_form').serialize();
                ///  alert(datastring);
           /*     console.log(row);
                if(!(row['price']!=undefined))
                {
                  if(row['min_price']!=undefined || row['max_price']!=undefined)
                  {
                    var cur_price=  $(this).closest('.edit_form').find('input[name=price]').val();
                    var min_price=  $(this).closest('.edit_form').find('input[name=min_price]').val();
                    var max_price=  $(this).closest('.edit_form').find('input[name=max_price]').val();
                    BootstrapDialog.confirm("Current price is "+cur_price+", set current price vary between "+min_price+" and "+max_price+"",function(result){
                      if(result) {
                      }else {
                        return true;
                      }
                    });
                  }                  
              } 
            */    
                      {                   
                        //      $('#loading').show();
                        $.ajax({
                          url: "<?= site_url('content/process');?>",
                            type: "POST",
                      data: row,
                      cache :false,
          success : function(response) {
            if(response.match(/Success/))
            {
            //  toastr.error(response);
                toastr.success('It will take some time to actually reflect the changed record on amazon site.Refreshing the page in 5 seconds');
                  window.setTimeout(function(){location.reload()},5000)
       //      var newdata = "<?php echo site_url('content/listings');?>";
         //    window.location.assign(newdata);
            }
            else
            {
              toastr.error(response);
            }
          }
      });
      //    $('#loading').hide();
    }
    }
  }); 

  /*
  $('#example11').Tabledit({
    url: "<?=base_url();?>content/process",
      columns: {
        identifier: [0, 'SKU'],                    
          editable: [[5, 'minprice'], [6, 'maxprice'],[7,'price']]
      } ,
      editButton: true,
      deleteButton: false,

      buttons: {
        edit: {
          class: 'btn btn-sm btn-default',
            html: '<span class="glyphicon glyphicon-pencil"></span>',
            action: 'edit'
        },
        delete: {
          class: 'btn btn-sm btn-default',
            html: '<span class="glyphicon glyphicon-trash"></span>',
            action: 'onDelete'
        },
      } ,
      onDraw: function() { 
        //alert('draw');
        return; },

          // executed when the ajax request is completed
          // onSuccess(data, textStatus, jqXHR)
          onSuccess: function() { alert('successs');return; },

          // executed when occurred an error on ajax request
          // onFail(jqXHR, textStatus, errorThrown)
          onFail: function() { return; },

          // executed whenever there is an ajax request
          onAlways: function() { alert('always');return; },
          onDelete: function(){ alert('delete');},
          // executed before the ajax request
          // onAjax(action, serialize)
          onAjax: function() { return; }
  });
*/
} );
/*
  $(document).ready(function() {
    $('#example').DataTable();
} );
 */
</script>    
<script type="text/javascript">
var LHCChatOptions = {};
LHCChatOptions.opt = {widget_height:340,widget_width:300,popup_height:520,popup_width:500};
(function() {
  var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
  var referrer = (document.referrer) ? encodeURIComponent(document.referrer.substr(document.referrer.indexOf('://')+1)) : '';
  var location  = (document.location) ? encodeURIComponent(window.location.href.substring(window.location.protocol.length)) : '';
po.src = '//legendrepricing.com/livehelperchat-master/lhc_web/index.php/chat/getstatus/(click)/internal/(position)/bottom_right/(ma)/br/(top)/350/(units)/pixels/(leaveamessage)/true?r='+referrer+'&l='+location;
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
</script>             
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-71424562-1', 'auto');
ga('send', 'pageview');

</script>
</body>
</html>
