<?php
session_start();
require_once ('inc/global_fns.php');
do_html_header('Dreamers Together', 'index.css');
?>
<div id="cover">
	<div id="logo-section">
		<div class="wrapper">
			<img src="images/logo.gif" alt="Dreamers Together" />
		</div>
	</div>
	<div id="mission-section">
		<div class="wrapper">
			<h2>Mission Statement</h2>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore 
			et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut 
			aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore 
			eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt 
			mollit anim id est laborum.
		</div>
	</div>
	<div id="count-section">
		<div class="wrapper">
			<span id="count">32424234 Dreamers Connected</span>
		</div>
	</div>
	<div id="options-section">
		<div class="wrapper">
			<a class="button white" href="want_form.php">Want</a> <a class="button white" href="give_form.php">Need</a>
		</div>
	</div>
</div>
<?php
 do_html_footer();
?>