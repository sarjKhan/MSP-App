<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Title" content="GotoGro Memeber Management Sysytem"/>
    <meta name="Authors" content="Sartaj Khan, Eddie Taing, Conrad Kotz, Jack Wylde"/>
    <link rel="stylesheet" href="styles.css"/>
    <title>Add Member Process</title>
</head>
<body>
<?php include 'nav.php' ?>
    <?php
        require_once("settings.php");
        require_once("phpfunctions.php");

        session_start();

        if (!isset($_SESSION['loggedin']))
        {
            $_SESSION['message'] = "Must be logged in";
            header("location: log_in.php");
        }

        //Checking if form input has been entered.
        if (isset($_POST['f_name']) && isset($_POST['l_name']) && isset($_POST['email']) && isset($_POST['phone']))
        {
            $errorMsg = array();

            $fname = sanitiseInput($_POST['f_name']);

            $fnamepattern = "/^[a-zA-Z- ]+$/"; 
            //Validating first name meets format.
            if (strlen($fname) < 1 || strlen($fname) > 20 || !preg_match($fnamepattern, $fname))
            {
                $errorMsg[] = "First name is not in the correct format. It must be between 1 and 20 characters and contain only letters, hypens and spaces.";
            }
                
            $lname = sanitiseInput($_POST['l_name']);

            $lnamepattern = "/^[a-zA-Z]+$/";
            //Validating last name meets format.
            if (strlen($lname) < 1 || strlen($lname) > 20 || !preg_match($lnamepattern, $lname))
            {
                $errorMsg[] = "Last name is not in the correct format. It must be between 1 and 20 characters and contain only letters.";
            }

            $email = sanitiseInput($_POST['email']);

            $emailpattern = "/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/";
            //Validating email input.
            //Source for email pattern https://stackoverflow.com/questions/201323/how-can-i-validate-an-email-address-using-a-regular-expression
            if (!preg_match($emailpattern, $email))
            {
                $errorMsg[] = "Email is not in the correct format.";
            }

            $phone = sanitiseInput($_POST['phone']);

            $phonepattern = "/^(\+?\(61\)|\(\+?61\)|\+?61|\(0[1-9]\)|0[1-9])?( ?-?[0-9]){7,9}$/";
            //Validating phone number.
            //Source for phone pattern: https://stackoverflow.com/questions/39990179/regex-for-australian-phone-number-validation
            if (!preg_match($phonepattern, $phone))
            {
                $errorMsg[] = "Phone number in correct format.";
            }

            //Checking if errors exist.
            if (sizeof($errorMsg) > 0)
            {
                //Displaying errors in list
                displayErrors($errorMsg);
            }
            else
            {
                //Setting up database connection with details from settings.php
                $conn = new mysqli($host, $user, $pswd, $db);

                //Check if error with connection
                if ($conn->connect_errno)
                {
                    echo "<p>Failed to connect to database: " . $conn->connect_error . "</p>";
                    exit();
                }

                createMemberTable($conn);

                //Query to insert new member into members table with form data.
                $insertquery = "INSERT INTO `members` (`fname`, `lname`, `email`, `phone`, `active`) VALUES ('$fname', '$lname', '$email', '$phone', TRUE);";
                //Executes insert query and checks results from query.
                if ($conn->query($insertquery) === TRUE)
                {
                    echo "<p>$fname $lname has been added to the system</p>";
                }
                else
                {
                    //If theres an error with query, display error.
                    echo "<p>Error with insert</p>";
                    echo "<p>" . $conn->error . "</p>";
                }

                //Closing connection
                $conn->close();
            }
        }
        else
        {
            echo "<p>Input has not been entered.</p>";
        }
    ?>
    <div onclick="history.back()"class="back" id ="historicback">&larr;&nbsp;Go Back</div>
</body>
</html>