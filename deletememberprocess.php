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
		require_once("settings.php");

		//Checking if member id was set
		if (isset($_POST['member_id']))
		{
			$member_id = $_POST['member_id'];
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

	            //Query to create table if it does not exist
	           	$tablequery = "CREATE TABLE IF NOT EXISTS members (
	                member_id INT NOT NULL AUTO_INCREMENT,
	                fname varchar(20) NOT NULL,
	                lname varchar(20) NOT NULL,
	              	email varchar(255) NOT NULL,
	                phone varchar(255) NOT NULL,
	                PRIMARY KEY (member_id)
	            );";
	                    
	            //Execute table creation query
	            $conn->query($tablequery);

	            $deleterecords = "DELETE FROM `sales_records` WHERE `member_id`=$member_id";

	            if ($conn->query($deleterecords) === TRUE)
	            {
	            	echo "<p>Member's records have been deleted.</p>";
	            }
	            else
	            {
	            	echo "<p>Unable";
	            }

	            $deletemember = "DELETE FROM `members` WHERE `member_id`=$member_id";

	            if ($conn->query($deletemember) == TRUE)
	            {
	            	echo "<p>Member successfully deleted.</p>";
	            }
	            else
	            {
	            	echo "<p>Unable to delete member: ". $conn->error. "</p>";
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