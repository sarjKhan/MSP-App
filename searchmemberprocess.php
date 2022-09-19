<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
    <meta name="Title" content="GotoGro Memeber Management Sysytem"/>
   	<meta name="Authors" content="Sartaj Khan, Eddie Taing"/>
    <link rel="stylesheet" href="styles.css"/>
</head>
<body>
	<?php
		require_once("settings.php");

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

		//Check if any search has been made.
		if ($criteriacount > 0)
		{
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

			$selectquery = substr($selectquery, 0, -5);

			$result = $conn->query($selectquery);

			//Checking if result has any records/rows
			if ($result->num_rows > 0)
			{
				while ($row = $result->fetch_assoc())
				{
					
					echo "<table>";
					echo "<tr><td>Member ID: </td><td>" . $row['member_id'] . "</td></tr>";
					echo "<tr><td>First Name: </td><td>" . $row['fname'] . "</td></tr>";
					echo "<tr><td>Last Name: </td><td>" . $row['lname'] . "</td></tr>";
					echo "<tr><td>Email: </td><td>" . $row['email'] . "</td></tr>";
					echo "<tr><td>Phone: </td><td>" . $row['phone'] . "</td></tr>";
					echo "</table>";
					echo "<a href='addsales.php?member_id=" . $row['member_id'] . "'>Add Sales For " . $row["fname"] . "</a>";
					echo "<br/>";
					echo "<a href='updatememberform.php?member_id=" . $row['member_id'] . "'>Update Member</a>";	
				}
			}
			else
			{
				echo "<p>0 results:</p>";
			}
				
			$conn->close();
		}
		else
		{
			echo "<p>No Search Terms Have Been Added</p>";
		}
	?>
</body>
</html>