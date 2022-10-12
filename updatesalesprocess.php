<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Title" content="GotoGro Memeber Management Sysytem"/>
    <meta name="Authors" content="Sartaj Khan, Eddie Taing, Conrad Kotz, Jack Wylde"/>
    <link rel="stylesheet" href="styles.css"/>
    <title>Update Sales Result</title>
</head>
<body>
<?php include 'nav.php' ?>
    <h1>Update Sales Form</h1>
    <?php
        require_once("settings.php");
        require_once("phpfunctions.php");

        //Checking form input
        if (isset($_POST['sales_id']) && isset($_POST['member_id']) && isset($_POST['item_name']) && isset($_POST['item_quantity']) && isset($_POST['due_date']))
        {
            $errorMsg = array();

            $sales_id = sanitiseInput($_POST['sales_id']);

            //Validating sales id form input
            if (is_numeric($sales_id) && strlen($sales_id) > 0)
            {
                //Convert to integer
                $sales_id = (int) $sales_id;

                //Creating database connection.
                $conn = new mysqli($host, $user, $pswd, $db);

                //Check if error with connection
                if ($conn->connect_errno)
                {
                    echo "<p>Failed to connect to database: " . $conn->connect_error . "</p>";
                    exit();
                }

                //Query to check sales record in database
                $querychecksales = "SELECT * FROM sales_records WHERE sales_id = $sales_id";

                //Executing query and getting result
                $result = $conn->query($querychecksales);

                //Checking result from uery
                if ($result->num_rows == 0) 
                {
                    $errorMsg[] = "Sales record with ID $sales_id does not exist.";
                }

                $conn->close();
            }
            else
            {
                $errorMsg[] = "Sales ID is not a number.";
            }

            $member_id = sanitiseInput($_POST['member_id']);

            //Validating member id is not empty and is number
            if (strlen($member_id) > 0 && is_numeric($member_id))
            {
                //Check if member id in table
                //Creating database connection.
                $conn = new mysqli($host, $user, $pswd, $db);

                //Check if error with connection
                if ($conn->connect_errno)
                {
                    $errorMsg[] = $conn->error;
                    exit();
                }

                $member_id = (int) $member_id;

                //Query to check that member is in database.
                $checkmember = "SELECT * FROM members WHERE member_id = $member_id";

                //Querying database.
                $result = $conn->query($checkmember);

                //Checking result from query
                if ($result->num_rows == 0) 
                {
                    $errorMsg[] = "Sales record with ID $sales_id does not exist.";
                }

                //Closing connection
                $conn->close();
            }

            //Assigning item_name to variable
            $item_name = sanitiseInput($_POST['item_name']);

            //Validating item name
            if (strlen($item_name) > 0 || strlen($item_name) <= 20)
            {
                $pattern = "/^[a-zA-Z0-9- ]+$/";
                if (!preg_match($pattern, $item_name))
                {
                    $errorMsg[] = "Item name must contain only letters, numbers, hyphens, and spaces.";
                }
            }
            else
            {
                $errorMsg[] = "Item name must be between 1 and 20 characters long (inclusive).";
            }

            //Validating item quantity
            $item_quantity = sanitiseInput($_POST['item_quantity']);

            if (is_numeric($item_quantity))
            {
                if ((int) $item_quantity < 1)
                {
                    $errorMsg[] = "Item quantity must be 1 or greater.";
                }
                else
                {
                    $item_quantity = (int) $item_quantity;
                }
            }
            else
            {
                $errorMsg[] = "Item quantity is not a number.";
            }
                
            //Validating date
            $due_date = $_POST['due_date'];
            if (empty($due_date))
            {
                $errorMsg[] = "Due date has not been set.";
            }
            else
            {
                $due_date = date("Y-m-d", strtotime($due_date));
            }

            if (sizeof($errorMsg) == 0)
            {
                //Setting up database connection with details from settings.php
                $conn = new mysqli($host, $user, $pswd, $db);

                //Check if error with connection
                if ($conn->connect_errno)
                {
                    echo "<p>Failed to connect to database: " . $conn->connect_error . "</p>";
                    exit();
                }

                createSalesTable($conn);

                $checkactivity = "SELECT active FROM sales_records WHERE sales_id = $sales_id";
                $activity = $conn->query($checkactivity);
                if ($activity->num_rows > 0)
                {
                    $row = $activity->fetch_assoc();
                    if ($row['active'] == TRUE)
                    {
                        $updatquery = "UPDATE `sales_records` SET `member_id` = $member_id , `item_name` = '$item_name' , `item_quantity` = $item_quantity , `due_date` = '$due_date' WHERE `sales_id` = $sales_id";

                        if ($conn->query($updatquery) === TRUE)
                        {
                            echo "<p>Record updated successfully.</p>";
                        }
                        else
                        {
                            echo "<p>Error with updating record: " . $conn->error . "</p>";
                        }
                    }
                    else
                    {
                        echo "<p>Record has been deleted and cannot be updated.</p>";
                    }
                }
                else
                {
                    echo "<p>Unable to find sales record</p>";
                }             
            }
            else
            {
                displayErrors($errorMsg);
            }
        }
        else
        {
            echo "<p>Form inputs have not been entered.</p>";
        }
    ?>
    <div onclick="history.back()"class="back" id ="historicback">&larr;&nbsp;Go Back</div>
</body>
</html>