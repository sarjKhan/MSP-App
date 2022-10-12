<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Title" content="GotoGro Memeber Management Sysytem"/>
    <meta name="Authors" content="Sartaj Khan, Eddie Taing, Conrad Kotz, Jack Wylde"/>
    <link rel="stylesheet" href="styles.css"/>
    <title>Delete Member</title>
</head>
<body>
<?php include 'nav.php' ?>
	<h1>Delete Member Confirm</h1>
	<?php
		require_once("settings.php");

		$errorMsg = array();

		//Checking if member id was set
		if (isset($_GET['member_id']))
		{
			$member_id = $_GET['member_id'];
			//Validating member id
			if (!is_numeric($member_id))
			{
				$errorMsg[] = "Member ID is not a number.";
			}
			else
			{
				$member_id = (int) $member_id;
				//Creating database connection
				$conn = new mysqli($host, $user, $pswd, $db);

				//Check if error with connection
	           	if ($conn->connect_errno)
	            {
	             	echo "<p>Failed to connect to database: " . $conn->connect_error . "</p>";
	                exit();
	            }

	            createMemberTable($conn);

	            $selectquery = "SELECT * FROM `members` WHERE `member_id`=$member_id";

	            $result = $conn->query($selectquery);

	            if ($result->num_rows === 1)
	            {
	            	while ($row = $result->fetch_assoc())
	            	{
	            		if ($row['active'] == TRUE)
	            		{
	            			echo "<table>";
		            		echo "<tr><td>Member ID:</td><td>" . $row['member_id'] ."</td></tr>";
		            		echo "<tr><td>First Name:</td><td>" . $row['fname'] ."</td></tr>";
		            		echo "<tr><td>Last Name:</td><td>" . $row['lname'] ."</td></tr>";
		            		echo "<tr><td>Email:</td><td>" . $row['email'] ."</td></tr>";
		            		echo "<tr><td>Phone:</td><td>" . $row['phone'] ."</td></tr>";
		            		echo "</table>";
		            		//Setting up form with values from database as values in form.
	                        echo "<form method='POST' action='deletememberprocess.php'>";
	                        echo "<input type='hidden' name='member_id' value='" . $row['member_id'] . "' />";
	                        echo "<input type='submit' value='Delete' />";
	                        echo "</form>";
	            		}
	            		else
	            		{
	            			echo "<p>Record has already been deleted.</p>";
	            		}
	            	}
	            }
	            else
	            {
	            	echo "<p>Unable to find member.</p>";
	            }
			}
		}
		else
		{
			echo "<p>Member ID has not been set.</p>";
		}
	?>
	<div onclick="history.back()"class="back" id ="historicback">&larr;&nbsp;Go Back</div>
</body>
</html>