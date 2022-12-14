<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Title" content="GotoGro Memeber Management Sysytem"/>
    <meta name="Authors" content="Sartaj Khan, Eddie Taing, Conrad Kotz, Jack Wylde"/>
    <link rel="stylesheet" href="styles.css"/>
    <title>Delete Member Process</title>
</head>
<body>
<?php include 'nav.php' ?>
	<h1>Delete Member</h1>
	<?php
		require("phpfunctions.php");
		require_once("settings.php");

		session_start();

        if (!isset($_SESSION['loggedin']))
        {
            $_SESSION['message'] = "Must be logged in";
            header("location: log_in.php");
        }

		//Checking if member id was set
		if (isset($_POST['member_id']))
		{
			$member_id = sanitiseInput($_POST['member_id']);
			//Validating member id
			if (!is_numeric($member_id))
			{
				echo "<p>Member ID is not a number.</p>";
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

	            $checkactivity = "SELECT active FROM members WHERE member_id = $member_id";
	            $activity = $conn->query($checkactivity);

	            if ($activity->num_rows > 0)
	            {
	            	$row = $activity->fetch_assoc();
	            	if ($row['active'] == TRUE)
	            	{
	            		$deleterecords = "UPDATE `members` SET `active` = FALSE WHERE `member_id` = $member_id";

			            if ($conn->query($deleterecords) === TRUE)
			            {
			            	echo "<p>Member's records have been deleted.</p>";
			            }
			            else
			            {
			            	echo "<p>Unable to delete records</p>";
			            }
	            	}
	            	else
	            	{
	            		echo "<p>Member Has Already Been Deleted.</p>";
	            	}
	            }
	            else
	            {
	            	echo "<p>Unable to find member record.</p>";
	            }

	            $conn->close();
			}
		}
		else
		{
			echo "<p>Member ID has not been set.</p>";
		}
	?>
    <a href="index.php" class="choose_back"><p class="back">&larr;&nbsp;Return Home</p></a>

</body>
</html>