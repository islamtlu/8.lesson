<?php
	// table.php
	
	//getting our config
	require_once ("../../config.php");
	
	//create connection
	$mysql = new mysqli("localhost", $db_username, $db_password, "webpr2016_islam");
	
	/*
		IF THERE IS ?DELETE=ROW_ID in the url
	*/

		if(isset($_GET["delete"])) {
			
			echo "Deleting row with id:".$_GET["delete"];
			
			// NOW () = current date-time
			$stmt = $mysql->prepare("UPDATE debattle_request SET deleted=NOW() WHERE id = ?");
			
			// replace the ?. The i here is an integer for the id number
			
			$stmt->bind_param ("i", $_GET["delete"]);
		
			if ($stmt->execute()){
				echo " Deleted successfully";
			}else{
				echo $stmt->error;
			}
			
			//Closes the statement, so others can use connection
			$stmt->close();
		}
	
	
	//SQL sentence // to show all results, remove ORDER 
	$stmt = $mysql->prepare("SELECT id, challengee, motion, start_date, end_date, characters, created FROM debattle_request WHERE deleted IS NULL ORDER BY created LIMIT 10 ");
	
	// on the above WHERE, WHERE deleted IS NULL show only those that are not deleted. WHERE should be before the ORDER
	
	//if error in sentence
	echo $mysql->error;
	
	//variable for data for each row we will get
	$stmt->bind_result($id, $challengee, $motion, $start_date, $end_date, $characters, $created);

	//query
	$stmt->execute ();
	
	//Create a table
	
	$table_html = "";
	
	//add somthing to string .=
	$table_html .= "<table>";
	$table_html .= "<tr>"; //table row
		$table_html .= "<th>ID</th>"; //table header
		$table_html .= "<th>Challengee</th>"; //table header
		$table_html .= "<th>Motion</th>"; //table header
		$table_html .= "<th>Start Date</th>"; //table header
		$table_html .= "<th>End Date</th>"; //table header
		$table_html .= "<th>Characters</th>"; //table header
		$table_html .= "<th>Created</th>"; //table header
		$table_html .= "<th>Delete?</th>"; //table header
	$table_html .= "</tr>"; //table row closing
	
	// GET RESULTS
	// we have multiple rows, the while loop
	while ($stmt->fetch()) {
		
		// Do SOMETHING FOR EACH ROW //the dots are actual spaces
		//echo $id." ".$challengee. "<br>";
		$table_html .= "<tr>"; //start a new row
		$table_html .= "<td>" .$id. "</td>"; //add coloumns
		$table_html .= "<td>" .$challengee. "</td>"; 
		$table_html .= "<td>" .$motion. "</td>"; 
		$table_html .= "<td>" .$start_date. "</td>"; 
		$table_html .= "<td>" .$end_date. "</td>"; 
		$table_html .= "<td>" .$characters. "</td>"; 
		$table_html .= "<td>" .$created. "</td>";
		$table_html .= "<td><a href='?delete=" .$id."'>Remove</a></td>";		
	$table_html .= "</tr>"; //end row
		
	}
	$table_html .= "</table>";
	echo $table_html;
?>
<br> <br>
<a href=Debattle.php>Debattle App</a>