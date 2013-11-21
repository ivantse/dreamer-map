<?php
session_start();
require_once('inc/global_fns.php');
//Connect to db
$conn = db_connect ();
if (!$conn)
	die ('Could not connect to the database');

$PHP_SELF=$_SERVER['PHP_SELF'];

//Post Values
$name=trim($_POST['name']);
$zipcode=empty($_POST['zipcode']) ? 0 : trim($_POST['zipcode']);
$state=$_POST['state'];
$story=trim($_POST['story']);
$email=trim($_POST['email']);
$facebook=trim($_POST['facebook']);
$twitter=trim($_POST['twitter']);
$linkedin=trim($_POST['linkedin']);
$school=trim($_POST['school']);
$company=trim($_POST['company']);
$major=trim($_POST['major']);
$grad_year= empty($_POST['grad_year']) ? 0 : trim($_POST['grad_year']);
$submit=$_POST['submit'];

//Validate form if submitted
if($submit){
    $errors=1;
	
	//Name is not valid
	if(strlen($name)<2){
		$msg='Please enter a valid name';
		$errors++;
	}
	
	//Story is not valid
	if(strlen($story)<2){
		$msg='Please enter a valid story';
		$errors++;
	}
	
	//state is not valid
	if(strlen($state)<2){
		$msg='Please select a valid state';
		$errors++;
	}
	
	//Attempt to Post in DB
	if($errors==1){
	    //Insert comment in DB
        $sql = "INSERT INTO stories (name, state, zipcode, story, email, facebook, twitter, linkedin, school, company, major, grad_year, added)
                VALUES ('$name', '$state', $zipcode, '$story', '$email', '$facebook', '$twitter', '$linkedin', '$school', '$company', '$major', $grad_year, now())";
        
        if ( !($result = mysql_query($sql)) )
               die ('Could not insert story into table'.$sql);
                        
		//Possible JSON formating
		/*{"story": {
		 * 	"sid": "5357",
		 *	"name": "Joe Blow",
		 *	"state": "CA",	
		 *	"story": "Hey, I'm a dreamer!",
		 *	"option": "college"
		 *}}
		 */    

        /*
		$data_array = array();
		$data_array['sid'] = $sid;
		$data_array['name'] =  $name;
		$data_array['state'] = $state;
		$data_array['story'] = $story;
		$data_array['options'] = $options;
		
		$json_array = array('story' => $data_array);
	
		$json = json_encode($json_array);
		*/
        echo $state;
	}else{
		echo $msg;
	}
	exit();
} //End submit
echo "No Submit";
?>