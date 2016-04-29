EMAIL = new RegExp(/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,6}$/);

$(document).ready(function() {
            $(".multidelete").click(function() {
                var val = $(".multidelete").val();
				$(".action").val(val);
				if(selectcheckbox())
				$("#multiform").submit();
            });

			$("#retweet_now").click(function() {
				$("#frmretweet").submit();
            });
			$("#orderby").change(function() {
			alert('it is working');
            });


			
});
function checkAll(a){
		var total = document.getElementById('total').value;
		if(a == 0){ for(q=0;q<total;q++){ document.getElementById('check'+q).checked = true;} document.getElementById('allbox').value = 1;}
		if(a == 1){ for(q=0;q<total;q++){ document.getElementById('check'+q).checked = false;} document.getElementById('allbox').value = 0;}
}

function selectcheckbox(){
	var total = document.getElementById('total').value; var j = 0; 
	for(i=0; i<total; i++) { if(document.getElementById('check'+i).checked == true){ j = 1; break; } } if(!j){ alert("Please select rows you want to process!"); return false; } else{ return true; }
}
/*function follow(id,name,pos){
		if(pos=='fea_' || pos=='gea_')
		{
		$("#fea_"+id).addClass("viewajaxload");
		} }*/
