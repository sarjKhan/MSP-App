<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="Title" content="GotoGro Memeber Management Sysytem"/>
        <meta name="Authors" content="Sartaj Khan, Eddie Taing"/>
        <link rel="stylesheet" href="styles.css"/>
    </head>
    <body>
        <h1>Update Sales Form</h1>
        <?php
            require_once("settings.php");

            //Checking form input
            if (isset($_POST['sales_id']) && isset($_POST['member_id']) && isset($_POST['transaction_id']) && isset($_POST['item_name']) && isset($_POST['item_quantity']) && isset($_POST['date_sold']))
            {
                $errorMsg = array();

                $sales_id = $_POST['sales_id'];

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
                    if ($result->num_rows == 0) 
                    {
                        $errorMsg[] = "Sales record with ID $sales_id does not exist.";
                    }

                    //Closing connection
                    $conn->close();
                }

                //Assigning transaction id to variable
                $transaction_id = $_POST['transaction_id'];

                //Validating transaction id is numeric
                if (is_numeric($transaction_id))
                {
                    //Checking number of digits
                    if (strlen($transaction_id) != 8)
                    {
                        $errorMsg[] = "Transaction ID ($transaction_id) is not 8 in length";
                    }
                    else
                    {
                        $transaction_id = (int) $transaction_id;
                    }
                }
                else
                {
                    $errorMsg[] = "Transaction ID ($transaction_id) is not numeric";
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
                $date_sold = $_POST['date_sold'];
                if (empty($date_sold))
                {
                    $errorMsg[] = "Date sold has not been set.";
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
                        transaction_id INT NOT NULL,
                        item_name varchar(20) NOT NULL,
                        item_quantity INT NOT NULL,
                        date_sold DATE NOT NULL,
                        PRIMARY KEY (sales_id),
                        FOREIGN KEY (member_id) REFERENCES members(member_id)
                    );";

                    //Execute table creation query
                    if ($conn->query($tablequery) === FALSE)
                    {
                        echo "<p>Error with database: " . $conn->error . "</p>";
                    }

                    $updatquery = "UPDATE `sales_records` SET `member_id` = $member_id , `transaction_id` = $transaction_id , `item_name` = '$item_name' , `item_quantity` = $item_quantity , `date_sold` = $date_sold WHERE `sales_id` = $sales_id;";

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
                    echo "<p>The following list of error(s) were encountered:</p>";
                    echo "<ul>";
                    foreach($errorMsg as $error)
                    {
                        echo "<li>$error</li>";
                    }
                    echo "</ul>";
                }
            }
            else
            {
                echo "<p>Form inputs have not been entered.</p>";
            }
        ?>
    </body>
</html>