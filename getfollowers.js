function getUsers(){
$.ajax({
  url:'getfollowers.php',
  type:'POST',
  async:false,
  data:{},
  success:function(response){
 $("#follower-box").append(response);
  }
});
});

  



}
