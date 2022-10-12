<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Title" content="GotoGro Memeber Management Sysytem"/>
    <meta name="Authors" content="Sartaj Khan, Eddie Taing, Conrad Kotz, Jack Wylde"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css">
		/*Styles for php echos*/
		@font-face {
			font-family: 'Avenir';
			src: url('../fonts/Avenir.eot?#iefix') format('embedded-opentype'), url('../fonts/Avenir.woff') format('woff'), url('../fonts/Avenir.ttf') format('truetype'), url('../fonts/Avenir.svg#Avenir') format('svg');
			}
		* {
			font-family: 'Avenir', Helvetica, sans-serif;
			color: white;
		}
		html {
			background-color: #152733;
			color: white;
			display: flex;
			justify-content: center;
			text-align: center;
		}
		.update_php {
			color: greenyellow;
		}
		.update_php:hover {
			text-decoration: underline greenyellow;
		}

		.delete_php {
			color: red;
		}

		.delete_php:hover {
			text-decoration: underline red;
		}
		.content-table {
			border-collapse: collapse;
			margin: 25px 0;
			font-size: 1.2em;
			min-width: 400px;
			border-radius: 5px 5px 0 0;
			overflow: hidden;
			box-shadow: 0 0 20px rgba(255, 255, 255, 0.20);
		}
		.content-table th tr {
			background-color: #009879;
			color: white;
			text-align: center;
		}
		.content-table th, .content-table tr {
			padding: 12px 15px;
		}
		.content-table tr {
			border-bottom: 1px solid #dddddd;
		}
		.content-table tr:last-of-type{
			border-bottom: 2px solid #dddddd;
		}
		.float-left{
			position: relative;
			left: 360px;
			background-color: green;
			margin: auto;
			width: 90px;
			border-radius: 5px 5px 5px 5px;
		}
		.float-left a{
			text-decoration: none;
		}
		#export {
			padding: 6px 2px 6px 2px;
			text-decoration: none;
			font-weight: bold;
			font-size: 18px;
		}
	</style>
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
			echo "<div class='float-left'><a href='export.php'><p id='export'><i class='fa fa-download' style='font-size:20px'></i> Export</p></a></div>";
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
	<a href="search_sales.html" class="choose_back"><p class="back">&larr;&nbsp;Go Back</p></a>
	
</body>
</html>