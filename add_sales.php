<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Title" content="GotoGro Memeber Management Sysytem" />
	<meta name="Authors" content="Sartaj Khan, Eddie Taing, Conrad Kotz, Jack Wylde" />
	<link rel="stylesheet" href="styles.css" />
	<link rel="stylesheet" href="styles.css" />
	<script defer src="./Validate_add_sales"></script>
	<script src="https://kit.fontawesome.com/5f307a1918.js" crossorigin="anonymous"></script>
	<title>Add Sales</title>
</head>

<body>
	<?php
	include 'nav.php';

	session_start();

	if (!isset($_SESSION['loggedin'])) {
		$_SESSION['message'] = "Must be logged in";
		header("location: log_in.php");
	}
	?>

	<h1>Add sales</h1>
	<div class="inherit_1">
		<form action="addsalesprocess.php" method="POST">
			<fieldset class="add_form">
				<legend>Add Sales: </legend>
				<label>Customer number:</label><br>

				<?php
				if (isset($_GET['member_id'])) {
					$member_id = $_GET['member_id'];
					echo "<input type='text' name='member_id' id='member_id' value='$member_id'/>";
				} else {;
					echo "<input type='text' name='member_id' id='member_id' placeholder = 'XXXXX'/>";
				}
				?>

				<br />
				<div class="input">
					<label for="item_name">Item Name:&nbsp;</label><br>
					<input type="text" name="item_name" placeholder="Name of product" onkeyup="validateItemName()">
				</div>
				<div class="input">
					<label for="item_quantity">Quantity:&nbsp;</label><br>
					<input type="number" name="item_quantity" min=0 placeholder="Enter Quantity" onkeyup="validateQuantity()">
				</div>
				<div class="input">
					<label for="due_date">Due Date:&nbsp;</label><br>
					<input id="due_date" type="date" name="due_date" placeholder="xx/xx/xxxx" onkeyup="validateDueDate()">
					<span id="due_date_error"></span>
				</div>
				<span id="submit_error"></span>
				<button type="submit" name="Submit" class="button" onclick="return validateForm()">Add</button>
				<div>
					<a href="search_members.php"> <br><u>Search for Member</a>
				</div>
			</fieldset>
		</form>
	</div>
	<div class="inherit">
		<a onclick="history.back()" class="choose_back">
			<p class="back">&larr;&nbsp;Go Back</p>
		</a>
	</div>
</body>

</html>