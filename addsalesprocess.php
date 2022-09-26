<!DOCTYPE html>
<html lang="en">
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

        //Validate inputs
        if (isset($_POST['member_id']) && isset($_POST['item_name']) && isset($_POST['item_quantity']) && isset($_POST['due_date']))
        {
            //Variable to hold errors
            $errorMsg = array();

            //Getting value of member id from form
            $member_id = $_POST['member_id'];

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
                if ($result == TRUE)
                {      
                    //Checking if member data was retrieved from database.
                    $rows = mysqli_num_rows($result);

                    if ($rows != 1)
                    {
                        $errorMsg[] = "Member with id $member_id does not exist.";
                    }
                }
                else
                {
                    $errorMsg[] = "Error with SQL: [$checkmember]. " . $conn->error;
                }

                //Closing connection
                $conn->close();
            }

            //Assigning item_name to variable
            $item_name = $_POST['item_name'];

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
            $item_quantity = $_POST['item_quantity'];

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
            //https://stackoverflow.com/questions/30243775/get-date-from-input-form-within-php

            if (empty($due_date))
            {
                $errorMsg[] = "Date sold has not been set.";
            }
            else
            {
                $due_date = strtotime($due_date);
                $due_date = date("Y-m-d", $due_date);
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

                //Query to create table if it does not exist
                //Transaction id and datetime sold will be entered manually by user in form.
                $tablequery = "CREATE TABLE IF NOT EXISTS sales_records (
                    sales_id INT NOT NULL AUTO_INCREMENT,
                    member_id INT NOT NULL,
                    item_name varchar(20) NOT NULL,
                    item_quantity INT NOT NULL,
                    due_date DATE NOT NULL,
                    PRIMARY KEY (sales_id),
                    FOREIGN KEY (member_id) REFERENCES members(member_id)
                );";

                //Execute table creation query
                if ($conn->query($tablequery) === FALSE)
                {
                    echo "<p>Error with database: " . $conn->error . "</p>";
                }

                //Query to insert new sales into sales records table with form data.
                $insertsales = "INSERT INTO `sales_records` (`member_id`,  `item_name`, `item_quantity`, `due_date`) VALUES ('$member_id', '$item_name', '$item_quantity', '$due_date');";


                //Checking if query entered successfully.
                if ($conn->query($insertsales) === TRUE)
                {
                    echo "<p>Sales record has been successfully entered into system</p>";
                }
                else
                {
                    echo "<p>Error with entering sales: " . $conn->error ."</p>";
                }

                //Closing connection
                $conn->close();
            }
            else
            {
                //Display errors here in unordered list
                echo "<p>The following error(s) have been encountered:</p>";

                echo "<ul>";
                foreach($errorMsg as $error)
                {
                    if ($error != "")
                    {
                        echo "<li>$error</li>";
                    }
                }

                echo "</ul>";
            }
        }
        else
        {
            echo "<p>Form data has not been set</p>";
        }
    ?>
</body>
</html>