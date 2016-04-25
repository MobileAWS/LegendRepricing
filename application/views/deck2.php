<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="latin1_swedish_ci">
    <title>Deck <?= base_url();?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
  <!--  <link href="<?= base_url();?>asset/css/style.css" rel="stylesheet"> -->
   <link href="asset/login/css/animate-custom.css" rel="stylesheet">
   <link rel="icon" href="data:;base64,iVBORw0KGgo=">
 <style type="text/css">
 html {
	overflow-y: scroll;
	background: #000 url(asset/login/img/background-image-1.jpg) top center;
	height:100%; 
}
body {
	font: normal normal 90% sans-serif;
	max-width: 800px;
	margin: 100px auto 50px auto;
	text-align: center;
	background: transparent url(asset/login/img/login-bg-overlay.png) repeat;
	min-height:100%; 
	border-radius: 15px;
}

.foo {   
float: left;
width: 100px;
height: 20px;
margin: 5px;
        border-width: 1px;
        border-style: solid;
        border-color: rgba(0,0,0,.2);
}
/*
h4 { 
   color: white; 
   font: bold 20px Helvetica, Arial, Sans-Serif;
   text-shadow: 10px 10px 0 #ffd217, 20px 20px 0 #5ac7ff, 30px 30px 0 #ffd217, 40px 40px 0 #5ac7ff;
}
*/
h4 {
  color:#fff;
  font-size: 20px;
}
h4 {
   text-shadow: 0px 5px 15px #000;
}
h3 {
  color:#fff;
  font-size: 15px;
}
h3 {
   text-shadow: 0px 5px 15px #000000;
}
h5 {
  color:#fff;
  font-size: 12px;
}
ul {
	list-style: none;
	margin: 0; padding: 0;
	text-align: left;	
}
body > ul {
	margin-bottom: 300px;
	background: transparent url(asset/login/img/login-bg.png) repeat;
	border:7px solid rgba(255, 255, 255, 0.31);
	-webkit-background-clip: padding-box; /* for Safari */
	-moz-background-clip: padding-box; /* for old Firefox */
	-o-background-clip: padding-box; /* for old Firefox */
    background-clip: padding-box; /* for IE9+, Firefox 4+, Opera, Chrome */
	-webkit-border-radius: 15px;
	-moz-border-radius: 15px;
	border-radius: 15px;
}
body > ul > li {
	position: relative;
}
body > ul > li > a {
	display: block;
	outline: 0;
	padding: .7em 1em;
	text-decoration: none;
	color: #fff;
	font-weight: bold;
	@include text-shadow(#111 0 -1px);
	background: #333;
	@include box-shadow(inset 0 1px 0 0 rgba(250,250,250,0.1));
	@include background-image(linear-gradient(#444, #333));
	@include filter-gradient(#444, #333, horizontal);
	border-bottom: 1px solid #222;
}
body > ul > li > ul {
	counter-reset: items;
	height: 0;
	overflow: hidden;
	background: #eee;
	color: #777;
	font-size: .75em;
	@include box-shadow(inset 0 0 50px #BBB);
}
body > ul > li > ul > li {
	counter-increment: items;
	padding: .5em 1.3em;
	border-bottom: 1px dotted #DDD;
}
body > ul > li > ul:after {
	font-size: 0.857em;
	@include inline-block;
	position: absolute;
	right: 10px;
	top: 15px;
	background: #333;
	line-height: 1em;
	height: 1em;
	padding: .7em .8em;
	margin: -.8em 0 0 0;
	color: white;
	text-indent: 0;
	text-align: center;
	@include text-shadow(0px 1px 0px rgba(0, 0, 0, .5));
	font-weight: 500;
	@include border-radius(.769em);
	@include box-shadow(inset 0px 1px 3px 0px rgba(0, 0, 0, .26), 0px 1px 0px 0px rgba(255, 255, 255, .15));
}
.retweet-id-cont {
	float: right;
}
.messages {
	float: center;
	font-size: 10px;
}

table, th, td {
      border: 1px solid black;
          border-collapse: collapse;
}

 </style>
    
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

<script src="asset/js/sorttable.js"></script>
<script src="asset/js/jquery.tablesorter.js"></script>

 <style type="text/css">
 .headerSortUp {
       background: url(http://tablesorter.com/themes/blue/bg.gif) no-repeat 99%;
 }
 </style>
<script type="text/javascript">
$(document).ready(function () {
    $("#schoptiona").click(function() {
        $("#manual").hide();
        $("#semiautomatic").hide();
        $("#automatic").show();
        $("#spitweets").show();  
        $.ajax({
				   url: "<?= site_url('deck/save_schtype');?>",
				   type: "POST",
           data: { 'data' :"automatic"},
				   cache :false,
				   success : function(response) {
					}
				}); 
    });
                        $("#schoptions").click(function() {
        $("#manual").hide();
        $("#semiautomatic").show();
        $("#automatic").hide();
        $("#spitweets").hide();  
        $.ajax({
				   url: "<?= site_url('deck/save_schtype');?>",
				   type: "POST",
           data: { 'data' :"semiautomatic"},
				   cache :false,
				   success : function(response) {
					}
				}); 
    });                   
    $("#schoptionm").click(function() {
        $("#manual").show();
        $("#automatic").hide();
        $("#semiautomatic").hide();
        $("#spitweets").hide();  
        $.ajax({
				   url: "<?= site_url('deck/save_schtype');?>",
				   type: "POST",
           data: { 'data' : "manual" },
				   cache :false,
				   success : function(response) {
					}
				}); 
    });                          
                     			$.ajax({
				   url: "<?= site_url('deck/savedtweets');?>",
				   type: "POST",
				   cache :false,
				   success : function(response) {
$("#spitweets").html(response);
  $("#dynamicsave").tablesorter({}); 
					}
				});
                          // hide vy default
//$("#spitweets").hide();
});

$(function() {
	
	$(".click_a a").click(function() {
		var ul = $(this).next(),
				clone = ul.clone().css({"height":"auto"}).appendTo("body"),
				height = ul.css("height") === "0px" ? ul[0].scrollHeight + "px" : "0px";
		
		clone.remove();
		ul.animate({"height":height});
		return false;
	});


$(".delete_logs").click(function() {



	 var total = $('#total_logs').val();
	 var j = 0;
	 for(i=0; i<total; i++)
	 {
		if($('#checkbox_log_'+i).is(':checked')){
		
		j = 1;
		break;
		}
	 }

	 if(j)
	 {
		var data = new Array();
	
		$('.logs_ids:checkbox:checked').each(function(i){
				
				var id = $(this).val();
				data.push(id);
		});
		
		var len = data.length;
		if(len>0){
		
			$.ajax({
				   url: "<?= site_url('deck/deletemultilogs');?>",
				   type: "POST",
				   data: { 'data': data},
				   cache :false,
				   success : function(response) {
						if(response==1)
							window.location.href = "<?= site_url('deck')?>";
					}
				});
		}
	 }
	 else
	 {
	 	alert('Por favor selecciona al menos una casilla para eliminar!');
	 }

	
});   
$(".deletetweets_twitter").live('click',function(e) {



	var con=confirm("are u sure deleting teh selected ones ?");
		if(con){
	 var total = $('#totaldelete').val();
	 var j = 0;
	 for(i=0; i<total; i++)
	 {
		if($('#checkdelete'+i).is(':checked')){
		
		j = 1;
		break;
		}
	 }

	 if(j)
	 {
		var data = new Array();
		var data1 = new Array();
	
		$('.twitter_ids:checkbox:checked').each(function(i){
				
				var id = $(this).val();
        var id1= $(this).attr('id');
				data.push(id);
        data1.push(id1);
		});
		
		var len = data.length;
		if(len>0){
		
    var imloader="<img src=<?= base_url()?>asset/images/ajax-loader.gif />"; 

$("#spitweets").html(imloader);
			$.ajax({
				   url: "<?= site_url('deck/deletetweets');?>",
				   type: "POST",
				   data: { 'data': data},
				   cache :false,
				   success : function(response) {
           if(response)
             {
              	$.ajax({
				   url: "<?= site_url('deck/savedtweets');?>",
				   type: "POST",
				   cache :false,
				   success : function(response) {              
$("#spitweets").html(response);
  $("#dynamicsave").tablesorter({}); 
           }
      });                                        

           /*





               var arrayLength = data1.length;
               for (var i = 0; i < arrayLength; i++) {
               $('#delete'+data1[i]).remove();
               } i
               */
           } 
           }
				});
		}
	 }
	 else
	 {
	 	alert('Por favor selecciona al menos una casilla para eliminar!');
	 }

	}
	
});   

 $("#nooffavs,#noofretweets,#nooftweets").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
             if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                       //display error message
                               $("#errmsg").html("Digits Only").show().fadeOut("slow");
                                              return false;
                                                  }
                                                     });
 $('#scheduletime').live('change', function(e) {
 var cr= confirm('are u sure want to save the changes');
 if(cr==true)
 {
    var data1=$(this).val();
    //send message tto controller    
    $.ajax({
				   url: "<?= site_url('deck/save_schtime');?>",
				   type: "POST",
				   data: { 'data': data1},
				   cache :false,
				   success : function(response) {
             alert("Table updated success");
					}
				}); 
 }
}); 
$('#schoption').live('change', function(e) {
 var cr= confirm('are u sure want to save the changes');
 if(cr==true)
 {
    var data1=$(this).val();
    //send message tto controller    
    $.ajax({
				   url: "<?= site_url('deck/save_schoption');?>",
				   type: "POST",
				   data: { 'data': data1},
				   cache :false,
				   success : function(response) {
             alert("Table updated success");
					}
				}); 
 }
});     
$(".sendsemidata").click(function() {
  
  if(!$('#semitime').val()  || !$('#semitwusername').val())
  {
    alert("oops empty data set");
    return false;
  }
  if($('#semitime').val()>59)
  {  
  alert("Invalida data");
  return  false;
  }
var datastring = $("#schsemiauto").serialize();
  {                   
  $.ajax({
url: "<?= site_url('deck/schsemiauto');?>",
type: "POST",
data: datastring,
cache :false,
success : function(response) {
//alert("we need ti s enow iner html to dip111ly the tablee");
alert("Saved");
$("#spitweets").html("Saved");
//  now make it sorttable
//var newTableObject = document.getElementById('dynamicsave');
//sorttable.makeSortable(newTableObject);
}
});
  }
});                            
$(".senddata").click(function() {
  
  if(!$('#nooftweets').val() || !$('#noofretweets').val() || !$('#nooffavs').val() || !$('#twusername').val())
  {
    alert("oops empty data set");
    return false;
  }
  if($('#nooftweets').val()>300)
  {  
  alert("Invalida data");
  return  false;
  }
var datastring = $("#schauto").serialize();
  {                   
    var imloader="<img src=<?= base_url()?>asset/images/ajax-loader.gif />"; 

$("#spitweets").html(imloader);
  $.ajax({
url: "<?= site_url('deck/schauto');?>",
type: "POST",
data: datastring,
cache :false,
success : function(response) {
//alert("we need ti s enow iner html to dip111ly the tablee");
$("#spitweets").html(response);
$('#dynamicsave').tablesorter();
//  now make it sorttable
//var newTableObject = document.getElementById('dynamicsave');
//sorttable.makeSortable(newTableObject);
}
});
  }
});       
$("#addapp1").submit(function(event)
{

  var data= new Array();
  data["password"]=$("#addapp #password").val();
  data["new_password"]=$("#addapp #new_password").val();
  if(data["password"] && data["new_password"])
  {
                     			$.ajax({
				   url: "<?= site_url('deck/addapp');?>",
				   type: "POST",
				   data: { 'data': data},
				   cache :false,
				   success : function(response) {
						if(response==1)
							window.location.href = "<?= site_url('deck')?>";
					}
				});
  }
  else
  {
    alert("null vlaues are insterted");
  }

 
});      
$(".savetweets_twitter").live('click',function(e) {

	var con=confirm("are u sure saving into database ?");
		if(con){
	 var total = $('#totaltweets').val();
	 var j = 0;
	 for(i=0; i<total; i++)
	 {
		if($('#checktweet'+i).is(':checked')){
		
		j = 1;
		break;
		}
	 }

	 if(j)
	 {
/*		var data = new Array();
	
		$('.twitter_ids:checkbox:checked').each(function(i){
				
				var id = $(this).val();
				data.push(id);
		});
		
		var len = data.length;
    */
    var k=0;
var table = $("#dynamicsave");
var element = {}, cart = [];
    table.find('.tweetdata').each(function (i) {
       var $tds = $(this).find('td');
      
		if($('#checktweet'+k).is(':checked')){
       element={};
       element.tweet_id = $('#checktweet'+k).val();
       element.fv = $tds.eq(4).text();
       element.rt = $tds.eq(3).text();
       element.text =$tds.eq(2).text();
       element.screename = $('#twusername').val();
       cart.push(element);
       }
       k++;
    });


 // 	if(len>0)
    {
		
    var imloader="<img src=<?= base_url()?>asset/images/ajax-loader.gif />"; 

$("#spitweets").html(imloader);
             var myJsonString = JSON.stringify(cart);
			$.ajax({
				   url: "<?= site_url('deck/savetweets');?>",
				   type: "POST",
				   data: { 'data': myJsonString},
				   cache :false,
				   success : function(response) {
              // jow change the save button
//              $('#dynamichange').val('delete');

   		$.ajax({
				   url: "<?= site_url('deck/savedtweets');?>",
				   type: "POST",
				   data: { 'data': cart},
				   cache :false,
				   success : function(response) {              
$("#spitweets").html(response);
  $("#dynamicsave").tablesorter({}); 



           }
      });
           }
				});
		}
	 }
	 else
	 {
	 	alert('Por favor selecciona al menos una casilla para eliminar!');
	 }

	}
	
});   
$(".verifycr_twitter").click(function() {



	var con=confirm("are u sure verifying credentials ?");
		if(con){
	 var total = $('#total').val();
	 var j = 0;
	 for(i=0; i<total; i++)
	 {
		if($('#check'+i).is(':checked')){
		
		j = 1;
		break;
		}
	 }

	 if(j)
	 {
		var data = new Array();
	
		$('.twitter_ids:checkbox:checked').each(function(i){
				
				var id = $(this).val();
				data.push(id);
		});
		
		var len = data.length;
		if(len>0){
		
			$.ajax({
				   url: "<?= site_url('deck/verifycredentials');?>",
				   type: "POST",
				   data: { 'data': data},
				   cache :false,
				   success : function(response) {
           if(response)
             {
             var nresponse= eval(response);
             for (var i = 0; i < nresponse.length; i++) {
             //                      nw randonly hcnage the colors 
                 var whatsis=("#myid"+data[i]);
             $(whatsis).css({"background-color": nresponse[i]});

             }
           } 
           }
				});
		}
	 }
	 else
	 {
	 	alert('Por favor selecciona al menos una casilla para eliminar!');
	 }

	}
	
});  
$(".verifykeys_twitter").click(function() {


	var con=confirm("are u sure verifying keys?");
		if(con){
	 var total = $('#total').val();
	 var j = 0;
	 for(i=0; i<total; i++)
	 {
		if($('#check'+i).is(':checked')){
		
		j = 1;
		break;
		}
	 }

	 if(j)
	 {
		var data = new Array();
	
		$('.twitter_ids:checkbox:checked').each(function(i){
				
				var id = $(this).val();
				data.push(id);
		});
		
		var len = data.length;
		if(len>0){
		
			$.ajax({
				   url: "<?= site_url('deck/verifykeys');?>",
				   type: "POST",
				   data: { 'data': data},
				   cache :false,
				   success : function(response) {
 //            alert(response);
           if(response)
             {
             var nresponse= eval(response);
             for (var i = 0; i < nresponse.length; i++) {
             //                      nw randonly hcnage the colors 
                 var whatsis=("#myid"+data[i]);
             $(whatsis).css({"background-color": nresponse[i]});

             }
           }
					}
				});
		}
	 }
	 else
	 {
	 	alert('Por favor selecciona al menos una casilla para eliminar!');
	 }

	}
	
}); 
$(".delete_twitter").click(function() {


	var con=confirm("En verdad quieres ELIMINAR la(s) cuenta(s)?");
		if(con){
	 var total = $('#total').val();
	 var j = 0;
	 for(i=0; i<total; i++)
	 {
		if($('#check'+i).is(':checked')){
		
		j = 1;
		break;
		}
	 }

	 if(j)
	 {
		var data = new Array();
	
		$('.twitter_ids:checkbox:checked').each(function(i){
				
				var id = $(this).val();
				data.push(id);
		});
		
		var len = data.length;
		if(len>0){
		
			$.ajax({
				   url: "<?= site_url('deck/deletemultiaccounts');?>",
				   type: "POST",
				   data: { 'data': data},
				   cache :false,
				   success : function(response) {
						if(response==1)
							window.location.href = "<?= site_url('deck')?>";
					}
				});
		}
	 }
	 else
	 {
	 	alert('Por favor selecciona al menos una casilla para eliminar!');
	 }

	}
	
});

$(".delete_accounts").click(function() {


var con=confirm("En verdad quieres ELIMINAR usuario(s)?");
		if(con){
	 var total = $('#total_accounts').val();
	 var j = 0;
	 for(i=0; i<total; i++)
	 {
		if($('#checkbox_accounts_'+i).is(':checked')){
		
		j = 1;
		break;
		}
	 }

	 if(j)
	 {
		var data = new Array();
	
		$('.accounts_ids:checkbox:checked').each(function(i){
				
				var id = $(this).val();
				data.push(id);
		});
		
		var len = data.length;
		if(len>0){
		
			$.ajax({
				   url: "<?= site_url('deck/deletemultiUsers');?>",
				   type: "POST",
				   data: { 'data': data},
				   cache :false,
				   success : function(response) {
						if(response==1)
							window.location.href = "<?= site_url('deck')?>";
					}
				});
		}
	 }
	 else
	 {
	 	alert('Por favor selecciona al menos una casilla para eliminar!');
	 }

	}
});

});
	function checkAll_log(a)
	{
		
		var total = $('#total_logs').val();
		
		if(a == 0)
		{
			
			for(q=0;q<total;q++)
			{
				$('#checkbox_log_'+q).attr('checked', true);
			}
			$('#allbox_log').val(1);
		}

		if(a == 1)

		{

			for(q=0;q<total;q++)

			{

				$('#checkbox_log_'+q).attr('checked', false);

			}

			$('#allbox_log').val(0);

		}

		

	}

	function checkAll_accounts(a)
	{
		
		var total = $('#total_accounts').val();
		
		if(a == 0)
		{
			
			for(q=0;q<total;q++)
			{
				$('#checkbox_accounts_'+q).attr('checked', true);
			}
			$('#allbox_accounts').val(1);
		}

		if(a == 1)

		{

			for(q=0;q<total;q++)

			{

				$('#checkbox_accounts_'+q).attr('checked', false);

			}

			$('#allbox_accounts').val(0);

		}

		

	}       
  function checkAlldeletetweets(a)
	{
		
		var total = $('#totaldelete').val();
		
		if(a == 0)
		{
			
			for(q=0;q<total;q++)
			{
				$('#checkdelete'+q).attr('checked', true);
			}
			$('#alltweetdeletebox').val(1);
		}

		if(a == 1)

		{

			for(q=0;q<total;q++)

			{

				$('#checkdelete'+q).attr('checked', false);
			}

			$('#alltweetdeletebox').val(0);

		}

		

	}
                   
  function checkAlltweets(a)
	{
		
		var total = $('#totaltweets').val();
		
		if(a == 0)
		{
			
			for(q=0;q<total;q++)
			{
				$('#checktweet'+q).attr('checked', true);
			}
			$('#alltweetbox').val(1);
		}

		if(a == 1)

		{

			for(q=0;q<total;q++)

			{

				$('#checktweet'+q).attr('checked', false);
			}

			$('#alltweetbox').val(0);

		}

		

	}
 
	
	function checkAll(a)
	{
		
		var total = $('#total').val();
		
		if(a == 0)
		{
			
			for(q=0;q<total;q++)
			{
				$('#check'+q).attr('checked', true);
			}
			$('#allbox').val(1);
		}

		if(a == 1)

		{

			for(q=0;q<total;q++)

			{

				$('#check'+q).attr('checked', false);

			}

			$('#allbox').val(0);

		}

		

	}

</script>

<script type="text/javascript">

function doacttion_twlogin()
{
	window.location.href = "<?= base_url()?>twitterlogin";
}
function deleteAllLogs()
{
	var con=confirm("En verdad quieres BORRAR TODO el registro? (es recomendable hacerlo cada noche para uso optimo del deck)");
		if(con){
	window.location.href = "<?= base_url()?>deck/deletealllogs";
				}
	}

function deleteErrorLog()
{
	var con=confirm("En verdad quieres BORRAR la advertencia? (Es recomendable borrarla cada noche. Para verificar que todas las cuentas sigan vinculadas debes darle RT a una cuenta que no esté dentro del deck)");
		if(con){
	window.location.href = "<?= base_url()?>deck/deleteerrorlog";
				}
}
function deleteSpamOne()
{
	var con=confirm("Borrar Spam de hace 1 hora?");
		if(con){
	window.location.href = "<?= base_url()?>deck/deletespamone";
				}
}
function check_id(event)
{
    //event.preventDefault();
	var retweet_id = document.getElementById('retweet_id').value; 


	if(retweet_id)
	{
		$.ajax({
			url : "<?=site_url('deck/chk_rt_limit')?>",
			type : 'post',
			async: false,
			data : {'retweet_id' : retweet_id},
			success :function(data, status){
				//alert(data);
				if(data == 'yes') {
					//alert("hello");
					return true;
				}
				else
				{
					alert('Ya diste los RTs de esta hora!');
					return false;
				}
			},
			error : function(xhr, desc, err)
			{
				 console.log("Details: " + desc + "\nError:" + err);
				return false;
			}

		});
	}
	else 
	{
		alert('Por favor coloca el ID del Tweet para dar Retweet');
		return false;
	}
}

function check_undo_id()
{
	var retweet_id = document.getElementById('undo_retweet_id').value; 
	if(retweet_id)
	{
		return true;
	}
	else 
	{
	alert('Por favor coloca el ID del Tweet para Deshacer los Retweets');
	return false;
	}
}
function check_spam_time()
{
	var spam_time = document.getElementById('spam_time').value; 
	if(spam_time)
	{
		return true;
	}
	else 
	{
	alert('Por favor coloca los minutos');
	return false;
	}
}
function check_favorite_id()
{
	var favorite_id = document.getElementById('favorite_id').value; 
	if(favorite_id)
	{
		return true;
	}
	else 
	{
	alert('Por favor coloca el ID del Tweet para dar Favorito');
	return false;
	}
}
function check_undoretweet_minutos()
{
	var undo_retweet_minutos = document.getElementById('undo_retweet_minutos').value; 
	if(undo_retweet_minutos)
	{
		return true;
	}
	else 
	{
	alert('Por favor los minutos ');
	return false;
	}
}
function check_schedule()
{
	var schedule_id = document.getElementById('schedule_id').value; 
	var af_time = document.getElementById('af_time').value;
	var schedule_status = document.getElementById('schedule_status').value; 

	if(schedule_id)
	{
		if(af_time > 60)
		{
			alert("El numero debe ser entre 01 y 59 minutos");
			return false
		}
		else
		{
			$.ajax({
				url : "<?=site_url('deck/sv_schedule')?>",
				type : 'post',
				async: false,
				data : {'schedule_id' : schedule_id,'af_time' : af_time, 'schedule_status': schedule_status},
				success :function(data, status){
					//alert(data);
					if(data == 'yes') {
						//alert("hello");
						alert("Tu programación de RTs ha sido guardada exitosamente!");
						return false;
					}
					else
					{
						alert("Cierra sesion y vuelve a intentarlo.");
					}
				},
				error : function(xhr, desc, err)
				{
					console.log("Details: " + desc + "\nError:" + err);
					//alert("Error")
					return false;
				}

			});
			return false;
		}
	}
	else 
	{
		alert('Por favor escribe los IDs de tus tweets para programar');
		return false;
	}
}

function check_undofavorite_id()
{
	var undo_favorite_id = document.getElementById('undo_favorite_id').value; 
	if(undo_favorite_id)
	{
		return true;
	}
	else 
	{
	alert('Por favor coloca el ID del Tweet para Deshacer los Favoritos');
	return false;
	}
}
	function selectcheckbox()

	{
	 var total = document.getElementById('total').value;

	 var j = 0;

	 for(i=0; i<total; i++)

	 {

		if(document.getElementById('check'+i).checked == true){

		j = 1;

		break;

		}

	 }

	 if(!j)

	 {

		alert("Por favor selecciona las cuentas que deseas utilizar!");

		return false;

	 }

	}
	
	function deleteUser(id)

	{

		var con=confirm("En verdad quieres borrarlo?");
		if(con){
		window.location = '<?php echo base_url();?>deck/delete/'+id;

		}

	}
	function deleteAccount(id)

	{

		var con=confirm("En verdad quieres borrarlo?");
		if(con){
		window.location = '<?php echo base_url();?>deck/deleteaccount/'+id;

		}

	}

function deleteLoghistory(id)

	{

		var con=confirm("En verdad quieres borrarlo?");
		if(con){
		window.location = '<?php echo base_url();?>deck/deleteloghistory/'+id;

		}

	}

var viewInfo = {
			
			// -- Variables --//
			
			pleaseWaitMsg : 'Please Wait',
			errorMsg : 'There was an Error.',

			// -- Functions --//

			postForm : function(uri, data, type) {
				
				$('#messages').text(viewInfo.pleaseWaitMsg);
				
				$.ajax({
					type : 'POST',
					url : uri,
					data : data,
					success : function(res, textStatus) {
						$('#messages').text('');
						//console.log(res);
						if(type == 1) {
							var obj = jQuery.parseJSON(res);
							//console.log(obj);
							viewInfo.renderLogTable(obj);
						}						
					},
					error : function(xhr, textStatus, errorThrown) {
						console.log('request failed ' + errorThrown);
						$('#messages').text(viewInfo.errorMsg);
					}
				});
			},
			
			limitRecordsBy : function(dropdown) {
				
				if(dropdown.value != "") {
				
					console.log('limitRecordsBy ' + dropdown.value);
					var data = {};
					data['days-back'] = dropdown.value;
					
					viewInfo.postForm('deck/limit-logs', data, 1);	
				}
			},

			renderLogTable : function(logArr) {
				
				if(logArr != undefined && logArr !=  null) {
					$('#table-body-tweet-logs tr').slice(2).remove();
					for (var i = 0, l = logArr.length; i < l; i++) {
						var rowObj = logArr[i];
						viewInfo.renderLogTableRow(rowObj, i);
					}
				}
				
			},
			
			renderLogTableRow : function(rowObj, rowIndex) {
				//console.log('renderLogTableRow');
				//console.log(rowObj);
				var row = $('<tr />');
				$('#table-body-tweet-logs').append(row);

				var checkboxRow = '';
				var tweetLogRow = '';
				var tweetLogRowEnd = '';
				var deleteLogRow = '';
				console.log('Retweet id ' + rowObj.reTweetId + ' Fav id ' + rowObj.favoriteId);
				var tweetId = ''; //(rowObj.actionPerformed == 'RT' || rowObj.actionPerformed == 'unRT') ? rowObj.reTweetId : rowObj.favoriteId;
				if(rowObj.actionPerformed == 'RT' || rowObj.actionPerformed == 'unRT') {
					tweetId = rowObj.reTweetId;
				} else {
					tweetId = rowObj.favoriteId;
				}
				
				<?php if($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin' ) {?>
				//console.log(rowObj);
				tweetLogRow = '<a href="https://twitter.com/twittertv/status/' + tweetId + '" target="_blank">';

				tweetLogRowEnd = '</a>';
				checkboxRow = '<input type="checkbox" class="logs_ids" name="checkbox_log[]" id="checkbox_log_' 
					+ rowIndex + '" value="' + rowObj.msg_id + '" />';
					
				deleteLogRow = '<td><a href="#" class="delete_icon" onclick="deleteLoghistory(' + rowObj.msgId + ')" '
				+ 'title="Delete This">Delete</a></td>';
				<?php }?>
				
				row
						.append($('<td>' + checkboxRow + '</td>'
								+ ' <td style="width:150px">' + rowObj.createdOn + '</td>'
								+ ' <td style="width:100px">' + rowObj.userName + '</td>  '
								+ ' <td style="width:100px">' + rowObj.actionPerformed + '</td>  '
								+ ' <td style="width:100px">' + tweetLogRow + tweetId + tweetLogRowEnd + '</td>  '
								+ deleteLogRow
						));	
			},

			propertyEnterPressed : function(e) {
				if (e.which == 13) {
					console.log('propertyEnterPressed');
					viewInfo.searchBoxEnter();
				}
			},

			reTweetIds : function() {
				var reTweetId = $('#re-tweet-id').val();
				var data = {};
				data['re-tweet-id'] = reTweetId;
				data['search-type'] = 1;
				
				viewInfo.postForm('deck/retweet-logs', data, 1);	
				
			},

			searchBoxEnter : function () {
				var searchInput = $('#re-tweet-id').val();
				
				if(searchInput.match(/^\d+$/)) {					
				    console.log("Entry was a number");
				    viewInfo.reTweetIds();
				    
				} else {
					viewInfo.searchByName();
				}
			},

			searchByName : function() {
				var nameStr = $('#re-tweet-id').val();
				var data = {};
				data['search-str'] = nameStr;
				data['search-type'] = 2;
				
				viewInfo.postForm('deck/retweet-logs', data, 1);	
				
			}
		};
	$(document).ready(function() {
		$('#limit-table').val('');
		$('#re-tweet-id').keypress(function(e) {
			viewInfo.propertyEnterPressed(e);
		});
		
	});
</script>
  </head>         

  <!--
          <div class="foo" style="background-color:#13b4ff;"></div>
          <div class="foo" style="background-color:#ab3fdd;"></div>
          <div class="foo" style="background-color:#ae163e;"></div>

          -->
  <body>
<DIV class="animated bounceInDown"> <DIV ALIGN=center><img src="http://soloparadeck.com/asset/images/decklogo.png"></div>
<?php if($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin' ) {?>
<h4><DIV ALIGN=left><font color="WHITE"> <a href="<?= base_url()?>createuser" style="text-align:center;color:#FFFFFF">Admin Panel</a></font></div><DIV ALIGN=right> 
<?php }?>
<font style="color:#FFFFFF">Bienvenido <strong><?= $user_info['name'] ?> </strong> | </font>&nbsp;<a href="<?= base_url()?>logout" style="color:#FF0000">Cerrar Sesión</a> </h4></div>
<br>
</div>
<?php if($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin' ) {?>
<?php if($inactive_accounts){?>
<h5><div class="error_div"> <font color="#FFFFFF">ADVERTENCIA! ESTAS CUENTAS REVOCARON EL DECK O QUITARON EL RT ANTES DE TIEMPO : <br><?php echo $inactive_accounts;?> </font></div></h5>
<?php }?>
<?php }?>
<br>
<?php if($this->session->userdata('success')) {?>
<h3><div class="success_div"> <font color="#FFFFFF"> <?php echo $this->session->userdata('success');?> </font></div></h3>
<?php $this->session->unset_userdata('success'); }?>

<ul class="click_a">    <li>
		<a href="#">Add App</a>
		<ul>
      	<form name="addapp" id="addapp" action="<?php echo site_url();?>deck/addapp" enctype="multipart/form-data" method="post">
<!--      		<form name="addapp" id="addapp" method="post">-->
			<font style="color:#FF0000"><?php echo validation_errors(); ?></font>
			<?php if($success) { echo $success;} ?>
	  <center>
        
		<p><tr>
          <td>Insert consumer key &nbsp;&nbsp;&nbsp;</td>
          <td><input type="password" name="password" id="password" placeholder="Insert consumer key"></td>
          <td></td>
          <p>
          <td>Insert consumer secret key &nbsp;&nbsp;</td>
          <td><input type="password" name="new_password" id="new_password" placeholder="insert consumer secret key"></td>
          <p>
          <p>
          <p>
		  <td><input type="submit" id="addappbutton" name="addappbutton" value="Save"></td>
          <!-- add button -->
          </tr>

        
        </center>
	</form>

    </ul>
	</li> 
	<li>
		<a href="#">Cuentas de Twitter</a>

		<ul>
				  <li> &nbsp; &nbsp; <a href="javascript:void(0);" onClick="doacttion_twlogin();" > <img src="<?= base_url()?>asset/images/signup_twitter.jpg"></a></li>

		<table border="0">
		
		 
		  <form id="input_form" name="input_form" action="<?php echo site_url();?>deck" method="post" onSubmit="return selectcheckbox();" >
			
			<input type="hidden" name="total" id="total" value="<?= $deck_accounts->num_rows() ?>" />

			<tr><td colspan="">&nbsp;</td><td><?php if($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin' ) {?><input type="button" class="delete_twitter" value="Delete" /><?php }?></td>
  <td><?php if($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin' ) {?><input type="button" class="verifykeys_twitter" value="Verify keys" /><?php }?></td>

 <td><?php if($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin' ) {?><input type="button" class="verifycr_twitter" value="Verify Credentials" /><?php }?></td>

      </tr>

		 	<tr style="background-color:#CCCCCC;">
			<td width="40"><input type="checkbox" name="allbox" id="allbox" value="0" onClick="checkAll(this.value)" /></td>
			<td width="50">No</td>
			<td width="100">User</td>
			<td width="100">Accounts</td>
			<td >Follower</td>
			<td>Action</td>
			<td>Status</td>
			</tr>

		 <?php if($deck_accounts->num_rows() >0) { ?>
			<?php 
			$i=1;
			$t=0;
			foreach($deck_accounts->result() as $row) {
			?>
			<tr>
			<td><input type="checkbox" class="twitter_ids" name="checkbox[]" id="check<?= $t ?>" value="<?= $row->user_id ?>" /></td>
			<td><?= $i?></td>
			<td> <?= $row->user_name?> </td>
			<td><?= $row->username?></td>
			<td><?= $row->followers?></td>
			<td><a href="javascript:void(0)" class="delete_icon" onClick="deleteAccount('<?= $row->account_id ?>')" title="Delete This"><?= ($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin')?'Delete':''?></a>					
</td>
      <td> <div class="foo" id="myid<?= str_replace(' ', '', $row->user_id); ?>" style="background-color:
      <?php
      if($mysendstatus)
      {
      foreach($mysendstatus as $ro)
      {
        if($row->user_id == explode(":",$ro)[0])
        {
        echo   explode(":",$ro)[1].";";
          break;
        }
      }
       }
      ?>" >
      </div>
       </td>
			</tr>                           

		
		<?php $i++;$t++;} }?>
    </form>
		</table>
		</ul>
	</li>
	<li style="display:<?=($setting_info['close_deck']=='no')?'block':'none'?>">
		<a href="#">Retweets</a>
		<ul>
      <center> Únicamente coloca el número de tweet, ejemplo: 
        https://twitter.com/username/status/<b>404506264299765760</b>
        <p><tr>
          <td>Dar RT</td>
          <td><input type="text" name="retweet_id" id="retweet_id" placeholder="404506264299765760"></td>
          <td><button name="retweet_now" id="retweet_now" onClick="return check_id(event);"><img src="<?=site_url()?>/asset/images/button-play.png"></button></td>
          <p>
          <td>Deshacer RT</td>
          <td><input type="text" name="undo_retweet_id" id="undo_retweet_id" placeholder="404506264299765760"></td>
          <td><button name="undoretweet" id="undoretweet" onClick="return check_undo_id();"> <img src="<?=site_url()?>/asset/images/button-play.png"></button></td>
          </tr>
        
        </center>
    </ul>
	</li>
	<li style="display:<?=($setting_info['favorite']=='yes' && $setting_info['close_deck']=='no')?'block':'none'?>" >
		<a href="#">Favoritos</a>
			<ul>
      <center> Únicamente coloca el número de tweet, ejemplo: 
        https://twitter.com/username/status/<b>404506264299765760</b>
        <p><tr>
          <td>Dar FAV</td>
          <td><input type="text" name="favorite_id" id="favorite_id" placeholder="404506264299765760"></td>
          <td><button name="" onClick="return check_favorite_id();" ><img src="<?=site_url()?>/asset/images/button-play.png" ></button></td>
          <p>
          <td>Deshacer FAV</td>
          <td><input type="text" name="undo_favorite_id" id="undo_favorite_id" placeholder="404506264299765760"></td>
          <td><button name="" onClick="return check_undofavorite_id();"> <img src="<?=site_url()?>/asset/images/button-play.png" ></button></td>
          </tr>
        
        </center>
    </ul>
	</li>
	<?php if($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin' ) {?>
			<li>
		<a href="#">Borrar Spam</a>
			<ul>
			
      <center> Únicamente coloca los minutos desde que quieres que borre el spam:
        <p><tr>
          <td>Borrar SPAM desde hace # minutos</td>
          <td><input type="text" name="minutos" id="minutos" maxlength="2" placeholder="30"></td>
          <td><input type="submit" name="delete_spam" value="borrar spam"></td>
          <p>
          </tr>
        
        </center>
    </ul>
	</li>
	<?php }?>
	<li>
		<a href="#">Programar Retweets</a>

			<ul>
 
		<div style="overflow-y:auto; width:auto; height:450px;">
<form>
<center>
<input   id="schoptiona" type="radio" name="schoption" value="automatic"  <?php if($user_info["schedule_type"]=='automatic') echo 'checked'?>>Automatic
<input id="schoptionm" type="radio" name="schoption" value="manual" <?php if($user_info["schedule_type"]=='manual') echo 'checked'?>>Manual
<input id="schoptions" type="radio" name="schoption" value="semiauto" <?php if($user_info["schedule_type"]=='semiautomatic') echo 'checked'?>>Semiautomatic
</center>
</form> 
<div id="manual"  <?php if($user_info["schedule_type"]!=='manual') echo 'style="display: none"'?> >
		<font color="red"><b> Esta función podría requerir activación previa
		   por favor contacta al administrador.</b></font>
      <center>Escribe los IDs de tus tweets <b>en cada renglón</b>
	    <br>Únicamente coloca el número de tweet, ejemplo: 
        <br>https://twitter.com/username/status/<b>404506264299765760</b>
      	<p><tr>
          <td>Programar IDs:</td>
        <p><tr>
          <td><textarea name="schedule_id" style="height:250px;width:250px;" id="schedule_id" placeholder="Escribe un ID por renglón..."><?php if($schedule_info->num_rows()>0)
		  {
		  foreach($schedule_info->result() as $row){
		  echo "$row->rt_id\n";
		  ?><?php } } ?></textarea></td>
          <p>
          <td>En que minuto de cada hora se darán los RTs:</td>
          <td><input type="text" name="af_time" id="af_time" maxlength="2" value="<?php echo $user_info['schedule_time'];?>"></td>
		  <td><select id="schedule_status" name="schedule_status">
		  	<option <?php if($user_info['schedule_status'] == 'yes') { ?> selected="selected" <?php }?> value="yes">Active</option>
			<option <?php if($user_info['schedule_status'] == 'no') { ?> selected="selected" <?php }?> value="no">Inactive</option>
			</select></td>
          <td><button name="" onClick="return check_schedule();"> <img src="<?=site_url()?>/asset/images/button-play.png" ></button></td>
          </tr>
		  <tr>
        
        </center>
</div>
<div id="automatic"  <?php if($user_info["schedule_type"]!=='automatic') echo 'style="display: none"'?> >
<!-- now create a new form OK -->

<!--		  <form id="input_form" name="input_form" action="<?php echo site_url();?>deck/schauto" method="post">-->
 	<form name="schauto" id="schauto"  enctype="multipart/form-data" action="<?php echo site_url();?>deck" method="post" >
			<font style="color:#FF0000"><?php echo validation_errors(); ?></font>
			<?php if($success) { echo $success;} ?>
	  <center>
        
		<p><tr>
          <td>Insert twitter username &nbsp;&nbsp;&nbsp;</td>
		<td><input type="text" name="twusername" id="twusername" placeholder="@twitterusername"></td>
          <td></td>
          <p>
          <td>Insert no of tweets &nbsp;&nbsp;</td>
          <td><input type="number" min="1" max="300" name="nooftweets" id="nooftweets" placeholder="#tweets"></td>
          <p>
          <td>Insert no of retweets &nbsp;&nbsp;</td>
          <td><input type="number" min="1" max="100" name="noofretweets" id="noofretweets" placeholder="#retweets"></td>
          <p>
          <td>Insert no of favs &nbsp;&nbsp;</td>
          <td><input type="number" min="1" max="100" name="nooffavs" id="nooffavs" placeholder="#favs"></td>
          <p>
	  <td>Select the options &nbsp;&nbsp;</td>
	  <td>
	  <select id="optiontweets" name="optiontweets">
	  <option value="timeline">Timeline</option>
	  <option value="favorites">Favorites</option>
	  </select>
	  </td>
<p>
	  <td><input class="senddata" type="button" id="gettweets" name="gettweets" value="GET tweets"></td>
          <!-- add button -->
          </tr>

        
        </center>
	</form>

</div>

<div id="semiautomatic"  <?php if($user_info["schedule_type"]!=='semiautomatic') echo 'style="display: none"'?> >

<!--		  <form id="input_form" name="input_form" action="<?php echo site_url();?>deck/schauto" method="post">-->
 	<form name="schsemiauto" id="schsemiauto"  enctype="multipart/form-data" action="<?php echo site_url();?>deck" method="post" >
			<font style="color:#FF0000"><?php echo validation_errors(); ?></font>
			<?php if($success) { echo $success;} ?>
	  <center>
        
		<p><tr>
          <td>Insert twitter username &nbsp;&nbsp;&nbsp;</td>
		<td><input type="text" name="semitwusername" id="semitwusername" placeholder="@twitterusername" value="<?php echo $user_info["schedule_auto_account"]?>"></td>
          <td></td>
	  <td>Select the options &nbsp;&nbsp;</td>
	  <td>
	  <select id="optionsemitweets" name="optionsemitweets">
	  <option value="timeline"  <?php if($user_info["schedule_auto_from"]=='timeline') echo 'selected'?>>Timeline</option>
	  <option value="favorites"   <?php if($user_info["schedule_auto_from"]=='favorites') echo 'selected'?>>Favorites</option>
	  </select>
	  </td>
          <td>Insert scheduled time  &nbsp;&nbsp;</td>
          <td><input type="number" min="1" max="59" name="semitime" id="semitime" placeholder="1-59" value="<?php echo $user_info["schedule_time"]?>"></td> 
<p>
	  <td><input class="sendsemidata" type="button" value="Save"></td>
          <!-- add button -->
          </tr>

        
        </center>
	</form>

</div>                           
<div id="spitweets" align="center"   <?php if($user_info["schedule_type"]!=='automatic') echo 'style="display: none"'?> >        

</div>
<div id="deletetweets">
</div>
</div>
    </ul>
	</li>
<!--	</form>-->
<?php  /* ?>	 OLD LOGG BELOW - THIS IS NOT SHOWED:
	<li>
	
		<a href="#">Registro</a>

		<ul>
		<div style="overflow-y:scroll; width:auto; height:250px;">
		<table border="0">

    	 <?php if($log_history->num_rows() >0) { ?>
			
			<input type="hidden" name="total_logs" id="total_logs" value="<?= $log_history->num_rows() ?>" />
			<tr><td colspan="">&nbsp;</td><td><?php if($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin' ) {?> <a href="javascript:void(0)" onClick="deleteAllLogs();" ><button type="button">Borrar Registro</button></a><?php }?></td><td><?php if($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin' ) {?> <a href="javascript:void(0)" onClick="deleteErrorLog();" ><button type="button">Borrar Advertencia</button></a><?php }?></td></tr>
			<tr style="background-color:#CCCCCC;">
			<td><?php if($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin' ) {?><input type="checkbox" name="allbox_log" id="allbox_log" value="0" onClick="checkAll_log(this.value)" /><?php }?></td>
			<td width="150">Logged Time </td>
			<td width="100">User</td>
			<td width="100">Action</td>
			<td >Tweet id</td>
			<td>Delete</td>
			</tr>

		<?php 
			$l=0;
			foreach($log_history->result() as $log) {
			?>
			<tr>
			
			<td><?php if($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin' ) {?><input type="checkbox" class="logs_ids" name="checkbox_log[]" id="checkbox_log_<?= $l ?>" value="<?= $log->msg_id ?>" /><?php }?></td>

			<td><?=date("d-m-Y H:i:s a",$log->create_date)?></td>
			<td><?= $log->user_name?></td>
			<td><?= $log->action?></td>
			<td><?php if($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin' ) {?><a href="https://twitter.com/twittertv/status/<?= ($log->action=='RT' || $log->action=='unRT')?$log->retweet_id:$log->favorite_id?>" target="_blank"><?= ($log->action=='RT' || $log->action=='unRT')?$log->retweet_id:$log->favorite_id?></a><?php }?><?php if($user_info['type'] == 'user' || $user_info['type'] == 'user' ) {?><?= ($log->action=='RT' || $log->action=='unRT')?$log->retweet_id:$log->favorite_id?><?php }?></td>
			
			<td><a href="javascript:void(0)" class="delete_icon" onClick="deleteLoghistory('<?= $log->msg_id ?>')" title="Delete This"><?= ($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin')?'Delete':''?></a>					

			</tr>

<!--		  <li> <?= $log->user_name?> <?= $log->retweet_id?'RT':'FAV'?> <?= $log->retweet_id?$log->retweet_id:$log->favorite_id?> </li> -->
		  <?php $l++;}  } else {?>
		  <tr><td>	<font style="color:#FF0000">	Todavía no hay acciones.</font><td></tr>

		<?php   } ?>
		</table>
		</div>
		</ul>
		
	</li>  
	
	<?php  */?>
	
	<?php  // NEW LOG BELOW - THIS IS THE ONE THAT IS SHOWED TO THE ADMIN ?>
	
		<li>
	<?php if($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin' )  {?>
		<a href="#">Registro</a> 
		

		<ul>
		
		<div style="overflow-y:scroll; width:auto; height:250px;">
		<h6 class="text-danger messages">
				<span id="messages"></span>
			</h6>
		<span> 
		<select id="limit-table" onchange="viewInfo.limitRecordsBy(this);">
		  <option value=""></option>
		  <option value="1">1 day ago</option>
		  <option value="2">2 day ago</option>
		  <option value="3">3 day ago</option>
		  <option value="4">4 day ago</option>
		</select> 
	</span>
	<span class="retweet-id-cont"><input id="re-tweet-id" type="text" name="re-tweet-id" placeholder="Retweet Id or Name"></span>
		<input type="hidden" name="total_logs" id="total_logs" value="<?= $log_history->num_rows() ?>" />
		<table id="table-tweet-logs" border="0">
			<tbody id="table-body-tweet-logs">
		<?php 
		 if($log_history->num_rows() > 0) { ?>
			
			<tr><td colspan="">&nbsp;</td><td><?php if($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin' ) 
			{?> <a href="javascript:void(0)" onClick="deleteAllLogs();" ><button type="button">Borrar Registro</button></a><?php 
			}?></td><td><?php if($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin' ) {?> 
			<a href="javascript:void(0)" onClick="deleteErrorLog();" ><button type="button">Borrar Advertencia</button></a><?php 
			}?></td></tr>
			<tr style="background-color:#CCCCCC;">
			<td><?php if($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin' ) {?><input type="checkbox" name="allbox_log" id="allbox_log" value="0" onClick="checkAll_log(this.value)" /><?php }?></td>
			<td width="150">Logged Time </td>
			<td width="100">User</td>
			<td width="100">Action</td>
			<td >Tweet id</td>
			<td>Delete</td>
			</tr>
			
			
			<?php   
		} 
		
		?>


 
		</tbody>
		</table>
		</div>
		</ul>
		
	</li>
	
	<?php }?>
	
  <li>
		<a href="#">Mensaje del Admin
    </a>
		<ul>
			<li><b><h2>
			<?php
$saltos=$setting_info['admin_message'];
$var_con_br=nl2br($saltos);
echo $var_con_br;
echo " <br> ";
?>
			</h2></b></li>
		
		</ul>
	</li>
  
      <li>
		<a href="#">Cuentas y Alternativas</a>
      
		<ul>
		
			<table border="0">
			<?php if($alternative_accounts->num_rows() >0) { ?>
			<tr><td colspan="">&nbsp;</td><td><?php if($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin' ) {?><input type="submit" class="delete_accounts" value="Delete" /><?php }?></td></tr>
			<?php }?>
		 	<tr style="background-color:#CCCCCC;">
			<td><?php if($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin' ) {?><input type="checkbox" name="allbox_accounts" id="allbox_accounts" value="0" onClick="checkAll_accounts(this.value)" /><?php }?></td>
			<td width="50">No</td>
			<td width="100">User</td>
			<td width="150">Principle Account</td>
			<td >Alternative Accounts</td>
			<td width="50" >Action</td>

		    <?php if($alternative_accounts->num_rows() >0) { ?>
			<input type="hidden" name="total_accounts" id="total_accounts" value="<?= $alternative_accounts->num_rows() ?>" />

			<?php 
			$a=0;
			$al = 1;
			foreach($alternative_accounts->result() as $alaccounts) {
			?>
			<tr>
			<td><?php if($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin' ) {?><input type="checkbox" class="accounts_ids" name="checkbox_accounts[]" id="checkbox_accounts_<?= $a ?>" value="<?= $alaccounts->acc_id ?>" /><?php }?></td>

			<td><?=$al?></td>
			<td><?=$alaccounts->name?></td>
			<td><?=$alaccounts->principle_account?></td>
			<td> <?=$alaccounts->alternative_account?> </td>
			<td><a href="javascript:void(0)" class="delete_icon" onClick="deleteUser('<?= $alaccounts->acc_id ?>')" title="Delete This"><?= ($user_info['type'] == 'admin' || $user_info['type'] == 'superadmin')?'Delete':''?></a>					
</td>
			</tr>


		<!--   <li>    <?=1+$i++?>  <?=$alaccounts->name?>  <?=$alaccounts->principle_account?>    <?=$alaccounts->alternative_account?>  <span style="float:right"><a href="javascript:void(0);" title="Delete This">Delete</a></span></li>-->
      			  <?php $a++;$al++;}  } else {?>
		  		<tr><td colspan="4">Todavía no hay cuentas</td></tr>

		<?php   } ?>
			</table>
		</ul>
	  
	  </li>
  
  <li>
		<a href="#">Reglas</a>
		<ul>
			<li><b><h2><?php
$saltos=$setting_info['rules'];
$var_con_br=nl2br($saltos);
echo $var_con_br;
echo " <br> ";
?></h2></b></li>
		
		</ul>
	</li>

  <li>
		<a href="#">CHAT</a>
		<ul>
			<li>PRÓXIMAMENTE</li>
		
		</ul>
	</li>
	
  <li>
		<a href="#">Cambia tu Contraseña</a>
		<ul>
      		<form name="reset_password" id="reset_password" action="<?php echo site_url();?>deck/reset_password" enctype="multipart/form-data" method="post">
			<font style="color:#FF0000"><?php echo validation_errors(); ?></font>
			<?php if($success) { echo $success;} ?>
	  <center>
        
		<p><tr>
          <td>Contraseña Vieja &nbsp;&nbsp;&nbsp;</td>
          <td><input type="password" name="password" id="password" placeholder="Contraseña Vieja"></td>
          <td></td>
          <p>
          <td>Contraseña Nueva &nbsp;&nbsp;</td>
          <td><input type="password" name="new_password" id="new_password" placeholder="Contraseña Nueva"></td>
          <p>
		  <td>Confirma tu Contraseña</td>
		  <td><input type="password" name="confirm_password" id="confirm_password" placeholder="Confirma tu Contraseña"></td>
          <p>
		  <td><input type="submit" name="reset_password" value="Reset"></td>

          </tr>

        
        </center>
	</form>

    </ul>
	</li>
</ul>


  </body>
</html>
