<?php
session_start();
require_once ('inc/global_fns.php');
do_html_header('Dreamers Together', 'index.css');
?>
<div id="cover">
	<div id="logo-section">
		<div class="wrapper">
			<img src="images/logo.png" alt="Dreamers Together" />
		</div>
	</div>
	<div id="mission-section">
		<div class="wrapper">
			For young dreamers who seek inspiration and career advice, an interactive map that connects them with 
			inspiring dreamers who already walked the path of being undocumented, with a focus on nurturing a sense 
			of community for dreamers.
		</div>
	</div>
	<div id="count-section">
		<div class="wrapper">
			<span id="count">32424234 Dreamers Connected</span>
		</div>
	</div>
	<div id="options-section">
		<div class="wrapper">
			<a class="button white" href="want_form.php">Get Help</a> <a class="button white" href="map.php?modal=give_form.php">Give Help</a>
		</div>
	</div>
</div>
<?php
 do_html_footer();
?>