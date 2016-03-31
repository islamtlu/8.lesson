<?php
	// require another php file
	// ../../ => 2 folders back - navigating to where the config file it
	require_once ("../../config.php");
	
	//the variable doesn't exist in the URL
	if(!isset($_GET["edit"])){
		
		//redirect user
		echo "redirect";
		header("Location: table.php");
		exit (); //don't execute further
		
	}else{
		
		echo "User wants to edit row:".$_GET["edit"];
		
		//ask for latest data for single row
		$mysql = new mysqli("localhost", $db_username, $db_password, "webpr2016_islam");
		
		//may be user wantes to update data after clicking the button 
		
		if(isset($_GET["challengee"]) && isset ($_GET["motion"])){
			
			echo "User modified data, tries to save";
			
			// should be validation?
			
			$stmt = $mysql->prepare("UPDATE debattle_request SET challengee=?, motion=?, position=?, visibility=?, start_date=?, end_date=?, favcolor=?, characters=? WHERE id=?");
			
			echo $mysql->error;
			
			$stmt->bind_param("sssssssii", $_GET["challengee"], $_GET["motion"], $_GET["position"], $_GET["visibility"], $_GET["start_date"], $_GET["end_date"], $_GET["favcolor"], $_GET["characters"], $_GET["edit"]);
			
			if($stmt->execute()){
				
				
				echo "Saved successfully";
				
				//option one
				
				//header ("Location: table.php");
				//exit ();
				
				//option two - update variables
				
				$challengee = $_GET["challengee"];
				$motion = $_GET["motion"];
				$position = $_GET["position"];
				$visibility = $_GET["visibility"];
				$start_date = $_GET["start_date"];
				$end_date = $_GET["end_date"];
				$favcolor = $_GET["favcolor"];
				$characters = $_GET["characters"];
				$id = $_GET["edit"];
				
				
				
			}else{
				
				echo $stmt->error;
			}
			
		}else{
			
			//user did not click any buttons yet,
			//give user latest data from database
			
		$stmt = $mysql->prepare("SELECT id, challengee, motion, position, visibility, start_date, end_date, favcolor, characters FROM debattle_request WHERE id=?");
		
		echo $mysql->error;
		
		//replace the ? mark   id = integer
		$stmt->bind_param("i", $_GET["edit"]);
		
		//bind result data
		$stmt->bind_result($id, $challengee, $motion, $position, $visibility, $start_date, $end_date, $favcolor, $characters);
		
		$stmt->execute();
		
		//we have only 1 row of data
		
		if($stmt->fetch()){
			
			//we had data
			echo $challengee." ".$motion." ".$position." ".$visibility." ".$start_date." ".$end_date." ".$favcolor." ".$characters;
			
		}else{
			
			//something went wrong
			echo $stmt->error;
			
		}
		
		}
		
	}
	
?>

<h2> Debattle Request </h2>

<form method="get">

	<input hidden name="edit" value="<?=$id;?>"><br><br>

	<label for="challengee">User to Challenge:* </label>
	<input type="text" placeholder="@" name="challengee" value="<?=$challengee;?>"><br><br>
	
	<label for="motion">Motion:* </label>
	<input type="text" name="motion" value="<?=$motion;?>"><br><br>
	
	Position: <br>
	<?php if($position == "Pro"): ?>
		<label><input type="radio" name="position" value="Pro" checked> Pro</label><br>
		<label><input type="radio" name="position" value="Against"> Against</label><br><br>
	<?php else: ?>
		<label><input type="radio" name="position" value="Pro"> Pro</label><br>
		<label><input type="radio" name="position" value="Against" checked> Against</label><br><br>
	<?php endif; ?>
	
	
	Visibility: <br>
	<?php if($visibility == "Open"): ?>
		<label><input type="radio" name="visibility" value="Open" checked> Open</label><br>
		<label><input type="radio" name="visibility" value="Closed"> Closed</label><br><br>
	<?php else: ?>
		<label><input type="radio" name="visibility" value="Open"> Open</label><br>
		<label><input type="radio" name="visibility" value="Closed" checked> Closed</label><br><br>
	<?php endif; ?>
	
	Start Date:
    <input type="date" name="start_date" value="<?= $start_date;?>"><br><br>
	End Date:
    <input type="date" name="start_date" value="<?= $end_date;?>"><br><br>
	
	Select your favorite color:
    <input type="color" name="favcolor" value="<?= $favcolor;?>"><br><br>
	
	Set number of characters (between 1 and 300):
    <input type="number" name="characters" value="<?= $characters;?>" min="1" max="300"><br><br>
	
	<!-- This is the save button-->
	<input type="submit" value="Start the Challenge">

<form>
<br> <br>
<a href=table.php>Table Results</a>