<?php
session_start();
require_once ('inc/global_fns.php');

$state = isset($_GET['state']) ? $_GET['state'] : '';

$conn = db_connect();
if (! $conn)
	die('could not connect to db');

if(!empty($state)){
	$sql = "SELECT *
			FROM stories
			WHERE state = '$state'
			ORDER BY image_url DESC, sid DESC";
}else{	
	$sql = "SELECT *
			FROM stories
			ORDER BY image_url DESC, sid DESC";
}

if (! ($result = mysql_query($sql)))
	die('Invalid query: ' . mysql_error());	
		
$content = '';
$stories_count = 0;
while($row = mysql_fetch_array($result)){
	$stories_count++;
	
	//Check for a URL
	if(!empty($row['image_url'])){
		$file_url = $row['image_url'];
	}else{
		$file_url = 'user.png';
	}
	
	//Show school or career info
	$school_career = '';
	if(!empty($row['school']) || !empty($row['company'])){
		$school_career .= '<p class="career-box">';
		if(!empty($row['school']) && !empty($row['company'])){
			$school_career .= ucwords(strtolower($row['school'])).', '.ucwords(strtolower($row['company']));
		}else if(!empty($row['school'])){
			$school_career .= ucwords(strtolower($row['school']));
		}else{
			$school_career .= ucwords(strtolower($row['company']));
		}
		$school_career .= '</p>';
	}
	
	//Contact
	$contact = '';
	if(!empty($row['email']) || !empty($row['facebook']) || !empty($row['linkedin']) || !empty($row['twitter'])){
		if(!empty($row['facebook'])){
			$contact .= '<a href="'.$row['facebook'].'" target="_blank"><img src="images/facebook.png"></a> ';
		}
		if(!empty($row['linkedin'])){
			$contact .= '<a href="'.$row['linkedin'].'" target="_blank"><img src="images/linkedin.png"></a> ';
		}
		if(!empty($row['twitter'])){
			$contact .= '<a href="http://www.twitter.com/'.$row['twitter'].'" target="_blank"><img src="images/twitter.png"></a> ';
		}		
		if(!empty($row['email'])){
			$contact .= '<a href="mailto:'.$row['email'].'" target="_blank"><img src="images/email.png"></a>';
		}
	}
	
	//Show the first one
	if($stories_count == 1){
		$show_first_box = ' current';
		$show_first_long = '';
		$show_first_snip = ' hide';
	}else{
		$show_first_box = '';
		$show_first_long = ' hide';
		$show_first_snip = '';
	} 
	
	$content .= '
		<div class="snippet'.$show_first_box.'">
			<img class="profile left" src="images/'.$file_url.'">
			<div class="left content">
				<h2>'.$row['name'].'</h2>
				'.$school_career.'
				<p class="snip'.$show_first_snip.'">'.substr($row['story'],0, 90).'...</p>
				<p class="long'.$show_first_long.'">'.$row['story'].'<br><br>'.'<button>Connect</button><div class="contact">'.$contact.'</div>
			</div>
			<div class="clear"></div>
		</div>';
}
if($stories_count == 0){
	$content = 'No Results';	
}


do_html_header('Story List','story_list.css');
?>

<div id="info-box">
	<?php echo $content; ?>
</div>

<script>
$(document).on( "click", '.snippet', function( event ) {
	$('.snippet').find('.long').addClass('hide');
	$('.snippet').find('.snip').removeClass('hide');
	$('.snippet').removeClass('current');
	
	$(this).find('.snip').addClass('hide');
	$(this).find('.long').removeClass('hide');
	$(this).toggleClass('current');
});
$('.snippet button').click(function() {
	$(this).hide();
	$(this).closest('.content').find('.contact').show();
	});
</script>


<?php
do_html_footer();
?>