<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Title" content="GotoGro Memeber Management Sysytem"/>
    <meta name="Authors" content="Sartaj Khan, Eddie Taing, Conrad Kotz, Jack Wylde"/>
    <link rel="stylesheet" href="styles.css"/>
    <title>Delete Sales Process</title>
</head>
<body>
<?php include 'nav.php' ?>
	<?php
		require_once("settings.php");
		require("phpfunctions.php");

		session_start();

        if (!isset($_SESSION['loggedin']))
        {
            $_SESSION['message'] = "Must be logged in";
            header("location: log_in.php");
        }

		if (isset($_POST['sales_id']))
		{
			$sales_id = sanitiseInput($_POST['sales_id']);

			if (!is_numeric($sales_id))
			{
				echo "<p>Sales ID is not a number</p>";
			}
			else
			{
				//Creating database connection
				$conn = new mysqli($host, $user, $pswd, $db);

				//Check if error with connection
	           	if ($conn->connect_errno)
	            {
	             	echo "<p>Failed to connect to database: " . $conn->connect_error . "</p>";
	                exit();
	            }

	           	createSalesTable($conn);

	            $checkactivity = "SELECT active FROM sales_records WHERE sales_id = $sales_id";
	            $activity = $conn->query($checkactivity);

	            if ($activity->num_rows > 0)
	            {
	            	$row = $activity->fetch_assoc();
	            	if ($row['active'] == TRUE)
	            	{
	            		$deletequery = "UPDATE sales_records SET active=FALSE WHERE sales_id=$sales_id";

			            if ($conn->query($deletequery)===TRUE)
			            {
			            	echo "<p>Sales Record Successfully Deleted</p>";
			            }
			            else
			            {
			            	echo "<p>No results</p>";
			            }
	            	}
	            	else
	            	{
	            		echo "<p>Sales Record Has Already Been Deleted.</p>";
	            	}
	            }
	            else
	            {
	            	echo "<p>Unable to find sales record.</p>";
	            }

	            $conn->close();
			}
		}
		else
		{
			echo "<p>No sales record to delete</p>";
		}
	?>
    <a href="index.php" class="choose_back"><p class="back">&larr;&nbsp;Return Home</p></a>

</body>
</html>