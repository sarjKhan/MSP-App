<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Title" content="GotoGro Memeber Management Sysytem"/>
    <meta name="Authors" content="Sartaj Khan, Eddie Taing, Conrad Kotz, Jack Wylde"/>
    <link rel="stylesheet" href="styles.css"/>
    <title>Update Sales Form</title>
</head>
<body>
<?php include 'nav.php' ?>
    <h1>Update Sales Form</h1>
    <?php
        require_once("settings.php");

        //Checking form input
        if (isset($_GET['sales_id']))
        {
            $errorMsg = array();
            $sales_id = $_GET['sales_id'];

            //Validating sales id form input
            if (is_numeric($sales_id))
            {
                 //Convert to integer
                $sales_id = (int) $sales_id;
            }
            else
            {
                $errorMsg[] = "Sales ID is not a number.";
            }


            //Check sales id exists in database
            $conn = new mysqli($host, $user, $pswd, $db);
            //Check if error with connection
            if ($conn->connect_errno)
            {
                echo "<p>Failed to connect to database: " . $conn->connect_error . "</p>";
                exit();
            }

            //Query to create table if it does not exist
            $tablequery = "CREATE TABLE IF NOT EXISTS sales_records (
                sales_id INT NOT NULL AUTO_INCREMENT,
                member_id INT NOT NULL,
                item_name varchar(20) NOT NULL,
                item_quantity INT NOT NULL,
                due_date DATE NOT NULL,
                PRIMARY KEY (sales_id),
                FOREIGN KEY (member_id) REFERENCES members(member_id)
            );";


            //Query to check sales record in database
            $querychecksales = "SELECT * FROM sales_records WHERE sales_id = $sales_id";

            //Executing query and getting result
            $result = $conn->query($querychecksales);

            if ($result->num_rows == 0) 
            {
                $errorMsg[] = "Sales record with ID $sales_id does not exist.";
            }

            //Check if no errors
            if (sizeof($errorMsg) == 0)
            {
                //https://riptutorial.com/php/example/9382/loop-through-mysqli-results
                //Creating form with information to update form
                while ($row = $result->fetch_assoc())
                {
                    //Setting up form with values from database as values in form.
                    echo "<form method='POST' action='updatesalesprocess.php'>";
                    echo "<input type='hidden' name='sales_id' value='" . $row['sales_id'] . "' />";
                    echo "<label for='member_id'>Member ID: </label>";
                    echo "<input type='text' name='member_id' id='member_id' value='" . $row['member_id'] ."' />";
                    echo "<br/>";
                    echo "<label for='item_name'>Item Name:</label>";
                    echo "<input type='text' name='item_name' id='item_name' value='" . $row['item_name'] . "' />";
                    echo "<br/>";
                    echo "<label for='item_quantity'>Item Quantity:</label>";
                    echo "<input type='text' name='item_quantity' id='item_quantity' value='". $row['item_quantity'] . "' />";
                    echo "<br/>";
                    echo "<label for='due_date'>Due Date:</label>";
                    echo "<input type='date' name='due_date' id='due_date' value='" . $row['due_date'] . "' />";
                    echo "<input type='submit' name='Update Sales Record' value='Update Sales Record' />";
                    echo "</form>";
                }
            }
            else
            {
                echo "<p>The following error(s)) have been encountered:</p>";
                echo "<ul>";
                foreach ($errorMsg as $error) {
                    echo "<li>$error</li>";
                }
                echo "</ul>";
            }

            //Closing connection
            $conn->close();
        }
        else
        {
            echo "<p>No form input</p>";
        }
    ?>
</body>
</html>