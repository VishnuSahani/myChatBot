<?php
date_default_timezone_set('Asia/Kolkata');
include('database.inc.php');
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="robots" content="noindex, nofollow">
      <title>PHP Chatbot</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	  <link href="style.css" rel="stylesheet">
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

      <style type="text/css">
      	
      </style>
   </head>
   <body>



      <div class="container" id="chat_container">
         <div class="row justify-content-md-center mb-4">
            <div class="col-md-6" style="position:relative;">
            	<!-- model start -->

<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#chatModal" id="robo" name="robo" style="position:fixed;bottom: 0;right: 0;z-index:100; ">May I Help You</button>

<div class="chat_icon">
	<i class="fa fa-comments" aria-hidden="true"></i>
</div>
<!-- Modal -->
<div class="modal fade" id="chatModal" tabindex="-1" role="dialog" aria-labelledby="chatModalLabel" aria-hidden="true" style="position:fixed;bottom: 0;right: 0; ">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="background-color: transparent;border: 0;">
     
      <div class="modal-body" >
      
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
      </div>
      
    </div>
  </div>
</div>

            	<!-- model close -->
               <i class="fa fa-chevron-up"></i>

            </div>
            <!-- col close -->
         </div>
         <!-- row -->
      </div>
<!-- container -->
      <span id="time"></span>
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
<!-- ---------------------------- -->

      <script type="text/javascript">   

      	setTimeout(function(){

      		        	$('#chatModal').modal('show');



      	},2000);
      </script>
   </body>
</html>


