<?php 
     $id= $_GET['id'];
     require('database.inc.php');

     $del = mysqli_query($con,"delete from message where id='".$id."'");

     if ($del) 
     {
     	header('location:see-all-msg.php');
     	exit;
     }
 ?>