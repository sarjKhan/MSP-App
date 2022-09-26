<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Title" content="GotoGro Memeber Management Sysytem"/>
    <meta name="Authors" content="Sartaj Khan, Eddie Taing, Conrad Kotz, Jack Wylde"/>
    <link rel="stylesheet" href="styles.css"/>
    <title>Add Sales</title>
</head>
<body>
	<h1>Add sales</h1>
	<form action="addsalesprocess.php" method="POST">
		<label>Member ID:</label>
		<?php
			if (isset($_GET['member_id'])) 
			{
				$member_id = $_GET['member_id'];
				echo "<input type='text' name='member_id' id='member_id' value='$member_id'/>";
			}
			else
			{;
				echo "<input type='text' name='member_id' id='member_id'/>";
			}
		?>
		
		<br/>
		<label>Item Name:</label>
		<input type="text" name="item_name" id="item_name"/>
		<br/>
		<label>Item Quantity:</label>
		<input type="text" name="item_quantity" id="item_quantity"/>
		<br/>
		<label>Due Date:</label>
		<input type="date" name="due_date" id="due_date"/>
		<br/>
		<input type="submit" name="Submit"/>
	</form>
</body>
</html>