<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Title" content="GotoGro Memeber Management Sysytem"/>
    <meta name="Authors" content="Sartaj Khan, Eddie Taing, Conrad Kotz, Jack Wylde"/>
    <link rel="stylesheet" href="styles.css"/>
    <title>Search Sales Results</title>
</head>
<body>
<?php include 'nav.php' ?>
	<h1>Search Sales Result:</h1>
	<?php
		require_once("settings.php");
		require_once("phpfunctions.php");

		$selectquery = "SELECT * FROM `sales_records` WHERE ";
		$criteriacount = 0;

		//Checking if member id was set
		if (isset($_POST['member_id']) && isset($_POST['item_name']) && isset($_POST['item_quantity']) && isset($_POST['due_date']))
		{
			$member_id = $_POST['member_id'];
			//Validating member id
			if (is_numeric($member_id) && $member_id > 0)
			{
				//Adding member id to query
				$selectquery .= "`member_id`=$member_id AND ";
				$criteriacount++;
			}

			$item_name = $_POST['item_name'];
			$pattern = "/^[a-zA-Z0-9- ]+$/";
			//Validating item name
			if (strlen($item_name) > 0 && preg_match($pattern, $item_name))
			{
				//Adding item name to query
				$selectquery .= "`item_name`='$item_name' AND ";
				$criteriacount++;
			}

			$item_quantity = $_POST['item_quantity'];
			//Validating item quantity
			if (is_numeric($item_quantity))
            {
            	if ($item_quantity > 0)
            	{	
            		//Adding item quantity to query.
            		$selectquery .= "`item_quantity` = $item_quantity AND ";
            		$criteriacount++;
            	}    
            }

            //Validating date
            $due_date = $_POST['due_date'];
            //https://stackoverflow.com/questions/30243775/get-date-from-input-form-within-php
            if (!empty($due_date))
            {
            	$due_date = strtotime($due_date);
                $due_date = date("Y-m-d", $due_date);

                //Adding due date to query
                $selectquery .= "`due_date`=$due_date AND ";
                $criteriacount++;
            }
		}

		if (isset($_GET['member_id']))
		{
			$member_id = $_GET['member_id'];

			if (is_numeric($member_id) && $member_id > 0)
			{
				//Adding member id to query
				$selectquery .= "`member_id`=$member_id AND";
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

        createSalesTable($conn);

        $searchresultsarray = array();

		//Checking if any search was added.
		if ($criteriacount > 0)
		{
            //https://stackoverflow.com/questions/4915753/how-can-i-remove-three-characters-at-the-end-of-a-string-in-php
			$selectquery .= " active = TRUE ORDER BY due_date ASC";
			$result = $conn->query($selectquery);

			//Check if any rows in results
			if ($result->num_rows > 0)
			{
				//Iterating through rows and adding to table.
				while ($row = $result->fetch_assoc())
				{
					$searchresultsarray[] = $row;					
				}
			}
			else
			{
				echo "<p>0 results: ". $conn->error."</p>";
			}
				
			$conn->close();
		}
		else
		{
			//If no search criteria get all data from sales records table
			$selectquery = "SELECT * FROM sales_records WHERE active=TRUE ORDER BY due_date ASC";
			$result = $conn->query($selectquery);

			//Check if any records.
			if ($result->num_rows > 0)
			{
				while ($row = $result->fetch_assoc())
				{
					//Put row into array to display.
					$searchresultsarray[] = $row;
				}
			}
			else
			{
				"<p>0 results. " . $conn->error . "</p>";
			}
		}

		if (sizeof($searchresultsarray) > 0)
		{
			echo "<table class='content-table'>";
			echo "<tr><th>Sales ID</th><th>Member ID</th><th>Item Name</th><th>Item Quantity</th><th>Due Date</th><th>Update</th><th>Delete</th></tr>";

			foreach ($searchresultsarray as $searchresult)
			{
				echo "<tr>";
				echo "<td>" . $searchresult['sales_id'] . "</td>";
				echo "<td>" . $searchresult['member_id'] . "</td>";
				echo "<td>" . $searchresult['item_name'] . "</td>";
				echo "<td>" . $searchresult['item_quantity'] . "</td>";
				echo "<td>" . $searchresult['due_date'] . "</td>";
				echo "<td><a href='updatesalesform.php?sales_id=" . $searchresult['sales_id'] . "' class='update_php'>Update</a></td>";
				echo "<td><a href='deletesalesform.php?sales_id=" . $searchresult['sales_id'] . "' class='delete_php'>Delete</a></td>";
				echo "</tr>";
			}

			echo "</table>";
		}
	?>
	<a href="search_sales.php" class="choose_back"><p class="back">&larr;&nbsp;Go Back</p></a>
	
</body>
</html>