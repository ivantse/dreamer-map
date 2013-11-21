<?php
session_start();
require_once ('inc/global_fns.php');
do_html_header('Give Form');
?>

<div id="form-section" style="text-align: left;">
<div class="wrapper">
<form id="give-form" method="post" action="give_form_post.php">

<label>Name</label> <input type="text" name="name" /><br />

<label>Zipcode</label> <input type="text" name="zipcode" /><br />

<label>State</label> 
<select name="state">
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

<label>Story</label> <textarea name="story" rows="4" cols="27"></textarea><br />

<label>Do you wish to be contacted?</label> <br />
<form>
<input type="checkbox" name="vehicle" value="Bike">Yes<br>
<input type="checkbox" name="vehicle" value="Car">No
</form>

<form>
Email: <input type="text" name="Email"><br>
Facebook: <input type="text" name="Facebook"><br>
Twitter: <input type="text" name="Twitter"><br>
linkedIn: <input type="text" name="LinkedIn"><br>
</form>

<label>Do you wish to share your education and career with Dreamers?<br />
<form>
<input type="checkbox" name="vehicle" value="Yes">Yes<br>
<input type="checkbox" name="vehicle" value="No">No
</form>

<form>
School: <input type="text" name="School"><br>
Company: <input type="text" name="Company"><br>
Major: <input type="text" name="Major"><br>
Year of Graduation (Expected): <input type="text" name="Year of Graduation (Expected)"><br>
</form>


<label></label> <input type="submit" name="submit" value="Submit" /></form>
</div>
</div>

<script>

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

	alert(form_data);
		
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