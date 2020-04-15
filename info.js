function yHandler(){
 var container = document.getElementById("postarea");
  var contentHeight = container.offsetHeight;
  var yOffset = window.pageYOffset;
  var y = yOffset+window.innerHeight;
  if(y >= contentHeight){
  $(document).ready(function(){
$.ajax({
  url:'findinfo.php',
  type:'POST',
  async:false,
  data:{id:$("#infodata").val()},
  success:function(response){
 $("#postarea").append(response);
  }
});
});

  }



}
window.onscroll=yHandler;

