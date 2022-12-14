<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Title" content="GotoGro Memeber Management Sysytem"/>
    <meta name="Authors" content="Sartaj Khan, Eddie Taing, Conrad Kotz, Jack Wylde"/>
    <link rel="stylesheet" href="styles.css"/>
	<style type="text/css">
		.content-table {
			justify-content: center;
    		text-align: center;
			margin: auto;
		}
	</style>
    <title>Search Member Results</title>
</head>
<body>
	<?php 
		include 'nav.php'; 
		session_start();

        if (!isset($_SESSION['loggedin']))
        {
            $_SESSION['message'] = "Must be logged in";
            header("location: log_in.php");
        }
	?>
	<br>
	<h1>Search Member Results:</h1>
	<?php
		require_once("settings.php");
		require_once("phpfunctions.php");

		$selectquery = "SELECT * FROM `members` WHERE ";
		$criteriacount = 0;

		//Validating member id
		if (isset($_POST['member_id']))
		{
			$member_id = $_POST['member_id'];
			if (is_numeric($member_id) && $member_id)
			{
				//Adding member id to query
				$selectquery .= "`member_id`=$member_id AND ";
				$criteriacount++;
			}
		}

		//Validating first name
		if (isset($_POST['f_name']))
		{
			$f_name = $_POST['f_name'];
			$pattern = "/^[a-zA-Z- ]+$/";
			if (strlen($f_name) > 0 && preg_match($pattern, $f_name))
			{
				//Adding first name to query
				$selectquery .= "`fname`='$f_name' AND ";
				$criteriacount++;
			}
		}

		//Validating last name
		if (isset($_POST['l_name'])) 
		{
			$l_name = $_POST['l_name'];
			$pattern = "/^[a-zA-Z- ]+$/";
			if (strlen($l_name) > 0 && preg_match($pattern, $l_name))
			{
				//Adding last name to query
				$selectquery .= "`lname`='$l_name' AND ";
				$criteriacount++;
			}
		}

		//Validating phone number
		if (isset($_POST['phone'])) 
		{
			$phone = $_POST['phone'];
			$phonepattern = "/^(\+?\(61\)|\(\+?61\)|\+?61|\(0[1-9]\)|0[1-9])?( ?-?[0-9]){7,9}$/";
			if (strlen($phone) > 0 && preg_match($phonepattern, $phone))
			{
				//Validating 
				$selectquery .= "`phone`='$phone' AND ";
				$criteriacount++;
			}
		}

		//Validating email
		if (isset($_POST['email']))
		{
			$email = $_POST['email'];
			$emailpattern = "/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/";
			if (preg_match($emailpattern, $email))
			{
				//Adding email to query
				$selectquery .= "`email`='$email' AND ";
				$criteriacount++;
			}
		}

		//Creating database connection
		$conn = new mysqli($host, $user, $pswd, $db);

		//Check if error with connection
        if ($conn->connect_errno)
        {
            echo "<p>Failed to connect to database: " . $conn->connect_error . "</p>";
            exit();
        }

        createMemberTable($conn);

        $searchresultsarray = array();

		//Check if any search has been made.
		if ($criteriacount > 0)
		{
			$selectquery .= " active = TRUE";

			$selectresult = $conn->query($selectquery);

			//Checking if result has any records/rows
			if ($selectresult->num_rows > 0)
			{
				while ($row = $selectresult->fetch_assoc())
				{
					//Putting record into array
					$searchresultsarray[] = $row;
				}				
			}
			else
			{
				echo "<p>0 results</p>";
			}
				
			$conn->close();
		}
		else
		{
			//Check all members if no search input made
			$selectquery = "SELECT * FROM members WHERE active=TRUE";

			$result = $conn->query($selectquery);

			//Check if any members
			if ($result->num_rows > 0)
			{
				while ($row = $result->fetch_assoc())
				{
					//Adding record of member into array
					$searchresultsarray[] = $row;
				}
			}
			else
			{
				echo "<p>0 results</p>";
			}
		}
		if (sizeof($searchresultsarray) > 0)
		{
			//Displaying all search results into array.
			echo "<div class='searchresults'>";
			echo "<table class='content-table'>";
			echo "<tr><th>Member ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>Update Member</th><th>Add Sales</th><th>Delete Member</th><th>Search Sales Record</th></tr>";
			foreach ($searchresultsarray as $searchresult)
			{
				echo "<tr>";
				echo "<td>" . $searchresult['member_id'] . "</td>";
				echo "<td>" . $searchresult['fname'] . "</td>";
				echo "<td>" . $searchresult['lname'] . "</td>";
				echo "<td>" . $searchresult['email'] . "</td>";
				echo "<td>" . $searchresult['phone'] . "</td>";
				echo "<td><a href='updatememberform.php?member_id=" . $searchresult['member_id'] . "' class='update_php'>Update Member</a></td>";
				echo "<td><a href='add_sales.php?member_id=" . $searchresult['member_id'] . "' class='add_php'>Add Sales Record</a></td>";
				echo "<td><a href='deletememberform.php?member_id=" . $searchresult['member_id'] . "' class='delete_php'>Delete</a></td>";
				echo "<td><a href='searchsalesprocess.php?member_id=" . $searchresult['member_id'] . "'>Search Sales Record</a></td>";
				echo "</tr>";	
			}
			echo "</table>";
			echo "</div>";
		}	
	?>
	<a href="search_members.php" class="choose_back"><p class="back">&larr;&nbsp;Go Back</p></a>
</body>
</html>