<?php
//Begin Header
function do_html_header($title, $css = false){
	global $_SESSION;
	//Check to see if CSS file was requested
	$css = ($css) ? '<link rel="stylesheet" href="css/' . $css . '" type="text/css" />' : '';
	?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $title;?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link rel="icon" type="image/png" href=" ">
<link rel="stylesheet" href="css/global.css" type="text/css">
<?php echo $css;?>
<script src="http://code.jquery.com/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" type="text/javascript"></script>

<body>
<div id="header">
	
</div>
<?php
} //End Header


//Begin footer
function do_html_footer(){
	?>
<script src="js/global.js" type="text/javascript"></script>
</body>
</html>
<?php
} //End footer
?>
