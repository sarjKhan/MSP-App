<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="Title" content="GotoGro Memeber Management Sysytem"/>
        <meta name="Authors" content="Sartaj Khan, Eddie Taing"/>
        <link rel="stylesheet" href="styles.css"/>
    </head>
    <body>
        <h1>Update Member Form</h1>
        <?php
            require_once("settings.php");

            //Checking form input
            if (isset($_GET['member_id']))
            {
                $errorMsg = array();
                $member_id = $_GET['member_id'];

                //Validating sales id form input
                if (is_numeric($member_id))
                {
                    //Convert to integer
                    $member_id = (int) $member_id;
                }
                else
                {
                    $errorMsg[] = "Member ID is not a number.";
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
                $querychecksales = "SELECT * FROM members WHERE member_id = $member_id";

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
                        echo "<form method='POST' action='updatememberprocess.php'>";
                        echo "<input type='hidden' name='member_id' value='" . $row['member_id'] . "' />";
                        echo "<label for='f_name'>First Name: </label>";
                        echo "<input type='text' name='f_name' id='f_name' value='" . $row['fname'] ."' />";
                        echo "<br/>";
                        echo "<label for='l_name'>Last Name:</label>";
                        echo "<input type='text' name='l_name' id='l_name' value='" . $row['lname'] . "' />";
                        echo "<br/>";
                        echo "<label for='email'>Email:</label>";
                        echo "<input type='text' name='email' id='email' value='". $row['email'] . "' />";
                        echo "<br/>";
                        echo "<label for='phone'>Phone:</label>";
                        echo "<input type='text' name='phone' id='phone' value='" . $row['phone'] . "' />";
                        echo "<br/>";
                        echo "<input type='submit' name='Update Member Record' value='Update Member Record' />";
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