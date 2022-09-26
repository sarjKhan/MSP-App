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

		if (isset($_POST['sales_id']))
		{
			$sales_id = $_POST['sales_id'];

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

	            $deletequery = "DELETE FROM sales_records WHERE sales_id=$sales_id";

	            if ($conn->query($deletequery)===TRUE)
	            {
	            	echo "<p>Sales Record Successfully Deleted</p>";
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