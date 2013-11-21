<?php
session_start();
require_once ('inc/global_fns.php');
do_html_header('Give Form','give_form.css');
?>

<div id="form-section" style="text-align: left;">
<div class="wrapper">
<form id="give-form" method="post" action="give_form_post.php">
<div class="inline-form">

<label>Name</label> <input type="text" name="name" />

<label>Zipcode</label> <input type="text" name="zipcode" />

<label>State</label> 
<select name="state">
	<option value=""></option>
	<option value="AL">Alabama</option>
	<option value="AK">Alaska</option>
	<option value="AZ">Arizona</option>
	<option value="AR">Arkansas</option>
	<option value="CA">California</option>
	<option value="CO">Colorado</option>
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="DC">District Of Columbia</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="HI">Hawaii</option>
	<option value="ID">Idaho</option>
	<option value="IL">Illinois</option>
	<option value="IN">Indiana</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="MT">Montana</option>
	<option value="NE">Nebraska</option>
	<option value="NV">Nevada</option>
	<option value="NH">New Hampshire</option>
	<option value="NJ">New Jersey</option>
	<option value="NM">New Mexico</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="ND">North Dakota</option>
	<option value="OH">Ohio</option>
	<option value="OK">Oklahoma</option>
	<option value="OR">Oregon</option>
	<option value="PA">Pennsylvania</option>
	<option value="RI">Rhode Island</option>
	<option value="SC">South Carolina</option>
	<option value="SD">South Dakota</option>
	<option value="TN">Tennessee</option>
	<option value="TX">Texas</option>
	<option value="UT">Utah</option>
	<option value="VT">Vermont</option>
	<option value="VA">Virginia</option>
	<option value="WA">Washington</option>
	<option value="WV">West Virginia</option>
	<option value="WI">Wisconsin</option>
	<option value="WY">Wyoming</option>
</select>
</div>			

<label>Story</label> <textarea name="story" rows="4" cols="27"></textarea><br />

<input id="contact" type="checkbox" name="contact" value="true">Do you wish to be contacted?<br>

<div id="contact-section" class="inline-form hide">
<label>Email:</label><input type="email" name="email">
<label>Facebook:</label><input type="facebook" name="facebook">
<label>Twitter: </label><input type="facebook" name="twitter">
<label>linkedIn:</label><input type="linkedin" name="linkedin">
</div>



<input id="education" type="checkbox" name="education" value="true">Do you wish to share your education and career with Dreamers?<br>

<div id="education-section" class="inline-form hide">
<label>School: </label><input type="school" name="school">
<label>Company: </label> <input type="company" name="company"><br>
<label>Major: <label/> <input type="major" name="major">
<label>Grad Year: </label><input type="grad_year" name="grad_year">
</div>


<label></label> <input type="submit" name="submit" value="Submit" /></form>
</body>

</div>
</div>


<script>

//Is contact checked
$("#contact").click( function(){
	if($(this).is(':checked')){ 
		$("#contact-section").show();
	}else{
		$("#contact-section").hide();
	}
});

//Is education checked
$("#education").click( function(){
	if($(this).is(':checked')){ 
		$("#education-section").show();
	}else{
		$("#education-section").hide();
	}
});

//When they submit a story
$("#give-form").submit(function(){				
	//Get all form fields	
	var form_data = $(this).serialize() + '&submit=submit';

	var request = $.ajax({
		url: "give_form_post.php",
		type: "POST",
		data: form_data,
		dataType: "html"
	});

	//alert(form_data);
		
	//If successful, do something here
	request.done(function(msg) {
		console.log(msg);		
		var myJSONObject = eval('(' + msg + ')');
			
      	//If successful, do something here		  	
		console.log(myJSONObject.story.name);	
	});
	
	request.fail(function(jqXHR, textStatus) {
		alert( "Request failed: " + textStatus );
	});
	
	//cancle submit button behavior
	return false;
});

</script>
<?php
do_html_footer();
?>