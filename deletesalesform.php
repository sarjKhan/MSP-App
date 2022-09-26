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
	<?php
		require_once("settings.php");

		if (isset($_GET['sales_id']))
		{
			$sales_id = $_GET['sales_id'];

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

	           	$tablequery = "CREATE TABLE IF NOT EXISTS sales_records (
	                sales_id INT NOT NULL AUTO_INCREMENT,
	                member_id INT NOT NULL,
	                item_name varchar(20) NOT NULL,
	                item_quantity INT NOT NULL,
	                due_date DATE NOT NULL,
	                PRIMARY KEY (sales_id),
	               	FOREIGN KEY (member_id) REFERENCES members(member_id)
	            );";
	            
	            $conn->query($tablequery);

	            $selectquery = "SELECT * FROM sales_records WHERE sales_id=$sales_id";

	            $result = $conn->query($selectquery);

	            if ($result->num_rows === 1)
	            {
	            	while ($row = $result->fetch_assoc())
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
</body>
</html>