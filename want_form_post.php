<?php
session_start();
require_once('inc/global_fns.php');
//Connect to db
$conn = db_connect ();
if (!$conn)
	die ('Could not connect to the database');

$PHP_SELF=$_SERVER['PHP_SELF'];

//Post Values
$state=$_POST['state'];
$interest=$_POST['interest'];
$submit=$_POST['submit'];

//Validate form if submitted
if($submit){		
    echo $state;
	exit();
	
} //End submit
echo "No Submit";
?>