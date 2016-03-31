<?php
	// require another php file
	// ../../ => 2 folders back - navigating to where the config file it
	require_once ("../../config.php");
	//the variable exists in the URL
	if(!isset($_GET["edit"])){
		
		//redirect user
		echo "redirect";
		header("Location: table.php");
		exit (); //don't execute further
	}else{
		echo "User wants to edit row:".$_GET["edit"];
	}
	
?>

<h2> Debattle Request </h2>

<form method="get">
	<label for="to">User to Challenge:* <label>
	<input type="text" placeholder="@" name="to"><br><br>
	
	<label for="motion">Motion:* <label>
	<input type="text" name="motion"><br><br>
	
	Position: <br>
	<input type="radio" name="position" value="Pro" checked> Pro<br>
    <input type="radio" name="position" value="Against"> Against<br><br>
	
	Visibility: <br>
	<input type="radio" name="visibility" value="Open" checked> Open<br>
    <input type="radio" name="visibility" value="Closed"> Closed<br><br>
	
	Start Date:
    <input type="date" name="bday"><br><br>
	End Date:
    <input type="date" name="bday2"><br><br>
	
	Select your favorite color:
    <input type="color" name="favcolor"><br><br>
	
	Set number of characters (between 1 and 300):
    <input type="number" name="characters" min="1" max="300"><br><br>
	
	<!-- This is the save button-->
	<input type="submit" value="Start the Challenge">

<form>
<br> <br>
<a href=table.php>Table Results</a>