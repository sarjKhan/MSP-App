<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Title" content="GotoGro Memeber Management Sysytem"/>
    <meta name="Authors" content="Sartaj Khan, Eddie Taing, Conrad Kotz, Jack Wylde"/>
    <link rel="stylesheet" href="styles.css"/>
    <title>Add Sales Process</title>
</head>
<body>
<?php include 'nav.php' ?>
	<?php
		require_once("settings.php");

		session_start();

        if (!isset($_SESSION['loggedin']))
        {
            $_SESSION['message'] = "Must be logged in";
            header("location: log_in.php");
        }

		if (isset($_GET['sales_id']))
		{
			$sales_id = sanitiseInput($_GET['sales_id']);

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

	            $selectquery = "SELECT * FROM sales_records WHERE sales_id=$sales_id";

	            $result = $conn->query($selectquery);

	            if ($result->num_rows === 1)
	            {
	            	while ($row = $result->fetch_assoc())
	            	{
	            		if ($row['active'] == TRUE)
	            		{
	            			echo "<h1>Would you like to delete the following?</h1>";
		            		echo "<table>";
		            		echo "<tr><td>Sales ID:</td><td>" . $row['sales_id'] . "</td></tr>";
		            		echo "<tr><td>Member ID:</td><td>" . $row['member_id'] . "</td></tr>";
		            		echo "<tr><td>Item Name:</td><td>" . $row['item_name'] . "</td></tr>";
		            		echo "<tr><td>Item Quantity:</td><td>" . $row['item_quantity'] . "</td></tr>";
		            		echo "<tr><td>Due Date:</td><td>" . $row['due_date'] . "</td></tr>";
		            		echo "</table>";
		            		echo "<form method='POST' action='deletesalesprocess.php'>";
		            		echo "<input type='hidden' name='sales_id' id='sales_id' value='".$row['sales_id']."'/>";
		            		echo "<input type='submit' name='Delete' value='Delete Sales Record'/>";
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
	            	echo "<p>No results</p>";
	            }
			}
		}
		else
		{
			echo "<p>No sales record to delete</p>";
		}
	?>
	<div onclick="history.back()"class="back" id ="historicback">&larr;&nbsp;Go Back</div>
</body>
</html>