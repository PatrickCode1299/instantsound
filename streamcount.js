function streamcount(){
	$.ajax({
	url:'streamcount.php',
	type:'POST',
	data:{songid:$("#songelement").val()},
	success:function(response){
    $("#streamholder").html(response);
	}
});
}