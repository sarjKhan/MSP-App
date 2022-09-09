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
            if (isset($_POST['sales_id']))
            {
                $errorMsg = array();
                $sales_id = $_POST['sales_id'];

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

                //Query to check sales record in database
                $querychecksales = "SELECT * FROM sales_records WHERE sales_id = $sales_id";

                //Executing query and getting result
                $result = $conn->query($querychecksales);

                //Checking result from uery
                if ($result === TRUE)
                {
                    $rows = mysqli_num_rows($result);

                    if ($rows != 1)
                    {
                        $errorMsg[] = "Sales ID ($sales_id) not found";
                    }
                }
                else
                {
                    $errorMsg[] = "Sales ID ($sales_id) does not exist." . $conn->error;
                }

                //Check if no errors
                if (sizeof($errorMsg) == 0)
                {
                    //https://riptutorial.com/php/example/9382/loop-through-mysqli-results
                    //Creating form with information to update form
                    while ($row = $result->fetch_assoc())
                    {
                        //Setting up form with values from database as values in form.
                        echo "<form method='updatesalesprocess.php' action='POST'>";
                        echo "<input type='hidden' name='sales_id' value='" . $row['sales_id'] . "' />";
                        echo "<label for='member_id'>Member ID: </label>";
                        echo "<input type='text' name='member_id' id='member_id' value='" . $row['member_id'] ."' />";
                        echo "<br/>";
                        echo "<label for='transaction_id'>Transaction ID:</label>";
                        echo "<input type='text' name='transaction_id' id='transaction_id' value='" . $row['transaction_id'] . "' />";
                        echo "<br/>";
                        echo "<label for='item_name'>Item Name:</label>";
                        echo "<input type='text' name='item_name' id='item_name' value='" . $row['item_name'] . "' />";
                        echo "<br/>";
                        echo "<label for='item_quantity'>Item Quantity:</label>";
                        echo "<input type='text' name='item_quantity' id='item_quantity' value='". $row['item_quantity'] . "' />";
                        echo "<br/>";
                        echo "<label for='date_sold'>Date Sold:</label>";
                        echo "<input type='date' name='date_sold' id='date_sold' />";
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