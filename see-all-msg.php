<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <meta name="robots" content="noindex, nofollow">
      <title>Chatbot Message Box</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	  <link href="style.css" rel="stylesheet">
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
   </head>
<body>
	<script type="text/javascript">
		function get_ques(ques)
		{
			$('#status').html('Please Wait....');
			$('#ansBtn').attr('Disabled',true); 

			var formdata = new FormData();  
				//formdata.append( "dname", _("name").value );
				formdata.append("userQues",$('#userQues').val());
				formdata.append("reply",$('#reply').val());
				var ajax = new XMLHttpRequest();
				ajax.open("POST","insert-chat-QuesReply.php");
				ajax.onreadystatechange = function(){
					if(ajax.readyState == 4 && ajax.status == 200){
						$('#status').html(ajax.responseText);
					}
					else{
						$('#status').html('No');
					}
				}
				ajax.send(formdata);

		}
		///////////

		
	</script>
	<h3 class="text-light text-center bg-danger">All User's Question </h3>
<div class="responsive">
	<table class="table table-dark">
		<thead>
			<th>S.No.</th>
			<th>Message</th>
			<th>Add</th>
			<th>Delete</th>
		</thead>
		<tbody class="tbody-info">
			<?php 
			require('database.inc.php');

			$sql = mysqli_query($con,"select * from message where type='user'");

			if (mysqli_num_rows($sql)>0) 
			{
				$num=1;
				while($row = mysqli_fetch_array($sql))
				{
					$val = $row['message'];
					echo "<tr>
					<td>".$num."</td>
					<td>".$row['message']."</td>
					<td>
					<form method='post'>
					   <input type='hidden' value='$val' id='que_val' name='que_val'/>
					   <button type='submit' name='btn_que' class='btn btn-outline-warning'>Add Ques</button>
					</form>

					</td>
                    <td><a href='delete-msg.php?id=".$row['id']."' role='button' class='btn btn-outline-danger'>Delete</a></td>
					
					</tr>";

					$num++;
				}
			}

			 ?>
			
		</tbody>
		
	</table>
	
</div>
<!-- div responsive -->



<!-- Modal -->
<div class="modal fade" id="addQuesModal" tabindex="-1" role="dialog" aria-labelledby="addQuesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">      
    	<form id="qusAnsForm" name="qusAnsForm" onsubmit="get_ques(); return false">

      <div class="modal-header" style="background-color:#e26228;">
        <h5 class="modal-title text-light" id="addQuesModalLabel">Add Questions and Reply</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>      <!-- modal header -->

      <div class="modal-body">
      		<div class="form-group">
      			<label for="userQues" style="font-weight: bold;">User's Question</label>
      			
      			<textarea name="userQues" id="userQues" class="form-control" required=""></textarea>
      		</div>
      		<!-- form group -->

      		<div class="form-group">
      			<label for="reply" style="font-weight: bold;">Their Reply</label>
      			<textarea name="reply" id="reply" class="form-control" required=""></textarea>
      		</div>
      	      		<!-- form group -->

        
      </div>
      <!-- modal body -->
      <div class="modal-footer">   

      <span id="status"></span>

        <button type="submit" class="btn btn-danger" id="ansBtn">Save changes</button>
      </div>      <!-- modal footer -->

      </form>
    </div>
  </div>
</div>
</body>
</html>

<?php 
if(isset($_POST['que_val']))
{
	 $v = $_POST['que_val'];
	 //echo $v ;

	echo "<script>$('#userQues').val('".$v."');
	$('#addQuesModal').modal('show');

	</script>";
}
 ?>