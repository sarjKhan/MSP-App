<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Title" content="GotoGro Memeber Management Sysytem"/>
    <meta name="Authors" content="Sartaj Khan, Eddie Taing, Conrad Kotz, Jack Wylde"/>
    <link rel="stylesheet" href="styles.css"/>
    <title>Update Member Form</title>
</head>
<body>
<?php include 'nav.php' ?>
    <h1>Update Member Form</h1>
    <?php
        require_once("settings.php");
        require_once("phpfunctions.php");

        //Checking form input
        if (isset($_GET['member_id']))
        {
            $errorMsg = array();
            $member_id = sanitiseInput($_GET['member_id']);

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

            createMemberTable($conn);
            
            //Query to check sales record in database
            $querychecksales = "SELECT * FROM members WHERE member_id = $member_id AND active = TRUE";

            //Executing query and getting result
            $result = $conn->query($querychecksales);

            if ($result->num_rows == 0) 
            {
                $errorMsg[] = "Sales record with ID $member_id does not exist or is inactive.";
            }

            //Check if no errors
            if (sizeof($errorMsg) == 0)
            {
                //https://riptutorial.com/php/example/9382/loop-through-mysqli-results
                //Creating form with information to update form
                while ($row = $result->fetch_assoc())
                {
                    //Setting up form with values from database as values in form.
                    echo "<form id='members_form' method='POST' action='updatememberprocess.php'>";
                    echo "<fieldset class='add_form'>";
                    echo "<legend>Update Member Details:</legend>";
                    echo "<input type='hidden' name='member_id' value='" . $row['member_id'] . "' />";
                    echo "<label for='f_name'>First Name: </label><br>";
                    echo "<input type='text' name='f_name' id='f_name' value='" . $row['fname'] ."' />";
                    echo "<br/>";
                    echo "<label for='l_name'>Last Name:</label><br>";
                    echo "<input type='text' name='l_name' id='l_name' value='" . $row['lname'] . "' />";
                    echo "<br/>";
                    echo "<label for='email'>Email:</label><br>";
                    echo "<input type='text' name='email' id='email' value='". $row['email'] . "' />";
                    echo "<br/>";
                    echo "<label for='phone'>Phone:</label><br>";
                    echo "<input type='text' name='phone' id='phone' value='" . $row['phone'] . "' />";
                    echo "<br/>";
                    echo "<button type='submit' name='Update Member Record' class='button'>Save Changes</button>";
                    echo "</fieldset>";
                    echo "</form>";
                }
            }
            else
            {
                displayErrors($errorMsg);
            }

            //Closing connection
            $conn->close();
        }
        else
        {
            echo "<p>No form input</p>";
        }
    ?>
    <div onclick="history.back()"class="back" id ="historicback">&larr;&nbsp;Go Back</div>
</body>
</html>