<?php 
if (isset($_POST['userQues']) && isset($_POST['reply']) ) 
{
	$userQues = trim($_POST['userQues']) ;
	$reply = trim($_POST['reply']) ;
	if(empty($userQues) || empty($reply))
	{
		echo "<span class='text-danger'>Please Fill Both Field</span>";
	}
	else
	{
		require('database.inc.php');

		$sql = mysqli_query($con,"insert into chatbot_hints (question,reply) values ('".$userQues."','".$reply."')");
		 	    		 //if (mysqli_query($con,"insert into subject_info (subject_code,subject_name,branch,semester,max_no,subject_type,max_class) values ('$subject_code','$subject','$br','$semester','$max_no','$subject_type','$max_class')")) 

		if ($sql) 
		{
			echo "Reply Inserted Successfully";
		}
		else
			echo "Something wrong Please Try again";
	}

}
else
{
	echo "<span class='text-danger'>Error ! </span>Please Try Again Due To Server Error";
}


 ?>