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

		$selectquery = "SELECT * FROM `sales_records` WHERE ";
		$criteriacount = 0;

		//Checking if member id was set
		if (isset($_POST['member_id']))
		{
			$member_id = $_POST['member_id'];
			//Validating member id
			if (is_numeric($member_id) && $member_id)
			{
				//Adding member id to query
				$selectquery .= "`member_id`=$member_id AND ";
				$criteriacount++;
			}
		}
		
		//Check if emtpy -> return all results (ADDED BY CONRAD)
		if ($criteriacount == 0)
		{		
				//Adding item name to query
				$selectquery .= " ";
				$criteriacount++;	
		}

		//Checking if item name was set
		if (isset($_POST['item_name']))
		{
			$item_name = $_POST['item_name'];
			$pattern = "/^[a-zA-Z0-9- ]+$/";
			//Validating item name
			if (strlen($item_name) > 0 && preg_match($pattern, $item_name))
			{
				//Adding item name to query
				$selectquery .= "`item_name`='$item_name' AND ";
				$criteriacount++;
			}
		}

		//Checking if item quantity was set
		if (isset($_POST['item_quantity'])) 
		{
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
		}

		//Checking due date was set
		if (isset($_POST['due_date'])) 
		{
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
            active BOOLEAN NOT NULL,
            PRIMARY KEY (sales_id),
            FOREIGN KEY (member_id) REFERENCES members(member_id)
        );";
                    
        //Execute table creation query
        $conn->query($tablequery);

        $searchresultsarray = array();

		//Checking if any search was added.
		if ($criteriacount > 0)
		{
            //https://stackoverflow.com/questions/4915753/how-can-i-remove-three-characters-at-the-end-of-a-string-in-php
			$selectquery .= " active = TRUE";

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
			$selectquery = "SELECT * FROM sales_records";
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
			echo "<table>";
			echo "<tr><th>Sales ID:</th><th>Member ID:</th><th>Item Name:</th><th>Item Quantity:</th><th>Due Date:</th><th>Update:</th><th>Delete:</th></tr>";

			foreach ($searchresultsarray as $searchresult)
			{
				echo "<tr>";
				echo "<td>" . $searchresult['sales_id'] . "</td>";
				echo "<td>" . $searchresult['member_id'] . "</td>";
				echo "<td>" . $searchresult['item_name'] . "</td>";
				echo "<td>" . $searchresult['item_quantity'] . "</td>";
				echo "<td>" . $searchresult['due_date'] . "</td>";
				echo "<td><a href='updatesalesform.php?sales_id=" . $searchresult['sales_id'] . "'>Update</a></td>";
				echo "<td><a href='deletesalesform.php?sales_id=" . $searchresult['sales_id'] . "'>Delete</a></td>";
				echo "</tr>";
			}

			echo "</table>";
		}
	?>
	<a href="search_sales.html" class="choose_back"><p class="back">&larr;&nbsp;Go Back</p></a>
	
</body>
</html>