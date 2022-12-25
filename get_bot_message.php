<?php
date_default_timezone_set('Asia/Kolkata');
include('database.inc.php');
$txt=mysqli_real_escape_string($con,$_POST['txt']);
$txt1 = trim($txt);
if (empty($txt1))
{
		$html="Sorry not be able to understand you";
	    echo $html;
	    exit;
}
$sql="select reply from chatbot_hints where question like '%$txt1%'";
$res=mysqli_query($con,$sql);
if(mysqli_num_rows($res)>0){
	$row=mysqli_fetch_array($res);
	$html=$row['reply'];
}else{
	$html="Sorry not be able to understand you";
}
$added_on=date('Y-m-d h:i:s');
mysqli_query($con,"insert into message(message,added_on,type) values('$txt1','$added_on','user')");
//$added_on=date('Y-m-d h:i:s');
//mysqli_query($con,"insert into message(message,added_on,type) values('$html','$added_on','bot')");
echo $html;
?>