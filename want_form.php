<?php
session_start();
require_once ('inc/global_fns.php');
do_html_header('Want Form', 'give_form.css');
?>

<div id="form-section" style="text-align: left;">
<h2>I Need Help</h2>
<form id="give-form" method="post" action="want_form_post.php">

<label>State</label> 
<select name="state">
	<option value=""></option>
	<option value="alabama">Alabama</option>
	<option value="alaska">Alaska</option>
	<option value="arizona">Arizona</option>
	<option value="arkansas">Arkansas</option>
	<option value="california">California</option>
	<option value="colorado">Colorado</option>
	<option value="connecticut">Connecticut</option>
	<option value="delaware">Delaware</option>
	<option value="districtofcolumbia">District Of Columbia</option>
	<option value="florida">Florida</option>
	<option value="georgia">Georgia</option>
	<option value="hawaii">Hawaii</option>
	<option value="idaho">Idaho</option>
	<option value="illinois">Illinois</option>
	<option value="indiana">Indiana</option>
	<option value="iowa">Iowa</option>
	<option value="kansas">Kansas</option>
	<option value="kentucky">Kentucky</option>
	<option value="louisiana">Louisiana</option>
	<option value="maine">Maine</option>
	<option value="maryland">Maryland</option>
	<option value="massachusetts">Massachusetts</option>
	<option value="michigan">Michigan</option>
	<option value="minnesota">Minnesota</option>
	<option value="mississippi">Mississippi</option>
	<option value="missouri">Missouri</option>
	<option value="montana">Montana</option>
	<option value="nebraska">Nebraska</option>
	<option value="nevada">Nevada</option>
	<option value="newhampshire">New Hampshire</option>
	<option value="newjersey">New Jersey</option>
	<option value="newmexico">New Mexico</option>
	<option value="newyork">New York</option>
	<option value="northcarolina">North Carolina</option>
	<option value="northdakota">North Dakota</option>
	<option value="ohio">Ohio</option>
	<option value="oklahoma">Oklahoma</option>
	<option value="oregon">Oregon</option>
	<option value="pennsylvania">Pennsylvania</option>
	<option value="rhodeisland">Rhode Island</option>
	<option value="southcarolina">South Carolina</option>
	<option value="southdakota">South Dakota</option>
	<option value="tennessee">Tennessee</option>
	<option value="texas">Texas</option>
	<option value="utah">Utah</option>
	<option value="vermont">Vermont</option>
	<option value="virginia">Virginia</option>
	<option value="washington">Washington</option>
	<option value="westvirginia">West Virginia</option>
	<option value="wisconsin">Wisconsin</option>
	<option value="wyoming">Wyoming</option>
</select>	

<label>Interest</label>
<select name="interest">
	<option value=""></option>
	<option value="employment">Employment</option>
	<option value="knowledge">Knowledge on immigration process (DACA, H-1 Visa etc.)</option>
	<option value="school">College & Admissions</option>
</select>


<br></br>

<input name="submit" type="submit" value="Submit">

</form>
</div>

<script>

//When they submit a story
$("#give-form").submit(function(){				
	//Get all form fields	
	var form_data = $(this).serialize() + '&submit=submit';

	var request = $.ajax({
		url: "want_form_post.php",
		type: "POST",
		data: form_data,
		dataType: "html"
	});

	//alert(form_data);
		
	//If successful, do something here
	request.done(function(msg) {
		hideModal(function() {
			var poly = findPolygonForState(msg);
			google.maps.event.trigger(poly, "click");
			//showStories();
			console.log(msg);
			});		
		//var myJSONObject = eval('(' + msg + ')');
			
      	//If successful, do something here		  	
		//console.log(myJSONObject.query.state);	
		//console.log(myJSONObject.query.interest);	
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