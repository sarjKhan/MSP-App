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
		<fieldset class="add_form">
			<legend>Add Sales: </legend>
			<label>Customer number:</label><br>
			<?php
				if (isset($_GET['member_id'])) 
				{
					$member_id = $_GET['member_id'];
					echo "<input type='text' name='member_id' id='member_id' value='$member_id'/>";
				}
				else
				{;
					echo "<input type='text' name='member_id' id='member_id' placeholder = 'XXXXX'/>";
				}
			?>
			
			<br/>
			<div class="input">
				<label for="product">Product Name:&nbsp;</label><br>
				<input type="text" name="product" placeholder="Name of product">
			</div>
			<div class="input">
				<label for="qnt">Quantity:&nbsp;</label><br>
				<input type="number" name="qnt" min=0 placeholder="Enter Quantity">
			</div>
			<div class="input">
				<label for="due_date">Due Date:&nbsp;</label><br>
				<input type="date" name="due_date" placeholder="xx/xx/xxxx">
			</div>
			<button type="submit" name="Submit" class="button">Add</button>
		</fieldset>
	</form>
</body>
</html>