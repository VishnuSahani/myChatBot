<?php

date_default_timezone_set('Asia/Kolkata');
include('database.inc.php');
  
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
<!-- old code -->
    

   <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="style.css" rel="stylesheet">
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>



  <!-- old code end -->
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

<link rel="stylesheet" type="text/css" href="css/all.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

<script type="text/javascript" src="js/all.min.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- chat box java script -->
<script type="text/javascript">
  $(document).ready(function() {
  $('.chat_icon').click(function() {
    $('.chat_box').toggleClass('active');
  });

  $('.my-conv-form-wrapper').convform({selectInputStyle: 'disable'})
});

</script>
<style type="text/css">
  /*ChatBot*/
.chat_icon{
  position: fixed;
  bottom: 0;
  right: 30px;
  z-index: 1000;
  padding: 0;
  font-size: 80px;
  color: red;
  cursor: pointer;
}
.chat_box{
  width: 400px;
  height: 80vh;
  position: fixed;
  bottom: 100px;
  right: 30px;
  background:green;
  z-index: 1000;
  transition: all 0.3s ease-out;
  transform: scaleY(0);
}
.chat_box.active{
  transform: scaleY(1);
}
/*
#messages{
  padding: 20px;
}
.my-conv-form-wrapper textarea{
  height: 30px;
  overflow: hidden;
  resize: none;
}
.hidden{
  display: none !important;
}*/
</style>
</head>
<body>


<!-- ChatBot -->
<div class="chat_icon ">
  <i class="fa fa-comments" aria-hidden="true"></i>
</div>

<div class="chat_box">
  <div class="my-conv-form-wrapper">
    <!-- start my code -->
    <!--start code-->
               <div class="card" style="margin: 0;padding: 0;">
                 <div class="card-header" style="background-color:#e26228;">
                  <h3 class="text-light">Chat Bot
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-light">&times;</span>
        </button></h3>
      </div>
                <!--  -->
                  <div class="card-body messages-box">
           <ul class="list-unstyled messages-list">
              <?php
              $res=mysqli_query($con,"select * from message where id='0'");
              if(mysqli_num_rows($res)>0){
                $html='';
                while($row=mysqli_fetch_assoc($res)){
                  $message=$row['message'];
                  $added_on=$row['added_on'];
                  $strtotime=strtotime($added_on);
                  $time=date('h:i A',$strtotime);
                  $type=$row['type'];
                  if($type=='user'){
                    $class="messages-me";
                    $imgAvatar="user_avatar.png";
                    $name="Me";
                  }else{
                    $class="messages-you";
                    $imgAvatar="bot_avatar.png";
                    $name="Chatbot";
                  }
                  $html.='<li class="'.$class.' clearfix"><span class="message-img"><img src="image/'.$imgAvatar.'" class="avatar-sm rounded-circle"></span><div class="message-body clearfix"><div class="message-header"><strong class="messages-title">'.$name.'</strong> <small class="time-messages text-muted"><span class="fas fa-time"></span> <span class="minutes">'.$time.'</span></small> </div><p class="messages-p">'.$message.'</p></div></li>';
                }
                echo $html;
              }else{
                ?>
                <li class="messages-me clearfix start_chat">
                  <img src="image/bot_avatar.png" class="avatar-sm rounded-circle"> 
                  <span class="text-info" style="font-weight: bold;"> Hi! Ask me Anything
                  </span>
                </li>
                <?php
              }
              ?>
                    
                     </ul>
                  </div>
                  <div class="card-header">
                    <div class="input-group">
             <input id="input-me" type="text" name="messages" class="form-control input-sm" placeholder="Type your message here..."  />
             <span class="input-group-append">
             <input type="button" class="btn" style="background-color:#e26228;color:#ffffff" value="Send" onclick="send_msg()">
             </span>
          </div> 
                  </div>
               </div>
               <!--end code-->

    <!-- end code -->
    
  </div>
</div>





<script type="text/javascript">
     function getCurrentTime(){
      var now = new Date();
      var hh = now.getHours();
      var min = now.getMinutes();
      var ampm = (hh>=12)?'PM':'AM';
      hh = hh%12;
      hh = hh?hh:12;
      hh = hh<10?'0'+hh:hh;
      min = min<10?'0'+min:min;
      var time = hh+":"+min+" "+ampm;
      return time;
     }
     function send_msg(){
      jQuery('.start_chat').hide();
      var txt=jQuery('#input-me').val();
      var html='<li class="messages-me clearfix"><span class="message-img"><img src="image/user_avatar.png" class="avatar-sm rounded-circle"></span><div class="message-body clearfix"><div class="message-header"><strong class="messages-title">Me</strong> <small class="time-messages text-muted"><span class="fas fa-time"></span> <span class="minutes">'+getCurrentTime()+'</span></small> </div><p class="messages-p bg-info text-light">'+txt+'</p></div></li>';
      jQuery('.messages-list').append(html);
      jQuery('#input-me').val('');
      if(txt){
        jQuery.ajax({
          url:'get_bot_message.php',
          type:'post',
          data:'txt='+txt,
          success:function(result){
            var html='<li class="messages-you clearfix"><span class="message-img"><img src="image/bot_avatar.png" class="avatar-sm rounded-circle"></span><div class="message-body clearfix"><div class="message-header"><strong class="messages-title">Chatbot</strong> <small class="time-messages text-muted"><span class="fas fa-time"></span> <span class="minutes">'+getCurrentTime()+'</span></small> </div><p class="messages-p bg-secondary text-light">'+result+'</p></div></li>';
            jQuery('.messages-list').append(html);
            jQuery('.messages-box').scrollTop(jQuery('.messages-box')[0].scrollHeight);
          }
        });
      }
     }
      </script>

<!-- chat bot end -->
  <div class="container-fluid">
    <div class="row" >
      <div class="col-lg-12">


      </div>
      <!-- col lg 4 -->
    </div>
  </div>
