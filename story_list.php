<?php
session_start();
require_once ('inc/global_fns.php');

$conn = db_connect();
if (! $conn)
	die('could not connect to db');

$sql = "SELECT *
		FROM stories";

if (! ($result = mysql_query($sql)))
	die('Invalid query: ' . mysql_error());	
		
$content = '';	
while($row = mysql_fetch_array($result)){
	$content .= '
		<div class="snippet">
			<img class="left" src="images/user.png">
			<div class="left content">
				<h2>'.$row['name'].'</h2>
				<p>'.$row['school'].', '.$row['company'].'</p>
				<p>'.$row['story'].'</p>
			</div>
			<div class="clear"></div>
		</div>';
}

do_html_header('Give Form','story_list.css');
?>

<div id="info-box">
	<?php echo $content; ?>
</div>

<?php
do_html_footer();
?>