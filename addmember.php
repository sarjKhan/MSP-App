<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="Title" content="GotoGro Memeber Management Sysytem"/>
        <meta name="Authors" content="Sartaj Khan, Eddie Taing"/>
        <link rel="stylesheet" href="styles.css"/>
    </head>
    <body>
        <?php
            require_once("settings.php");

            //Checking if form input has been entered.
            if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['phone']))
            {
                $errorMsg = "";

                $fname = stripslashes($_POST['fname']); 

                $fnamepattern = "/^[a-zA-Z- ]+$/"; 
                //Validating first name meets format.
                if (strlen($fname) < 1 || strlen($fname) > 20 || !preg_match($fnamepattern, $fname))
                {
                    $errorMsg .= "First name is not in the correct format. It must be between 1 and 20 characters and contain only letters, hypens and spaces.\n";
                }
                
                $lname = stripslashes($_POST['lname']);

                $lnamepattern = "/^[a-zA-Z]+$/";
                //Validating last name meets format.
                if (strlen($lname) < 1 || strlen($lname) > 20 || !preg_match($lnamepattern, $lname))
                {
                    $errorMsg .= "Last name is not in the correct format. It must be between 1 and 20 characters and contain only letters.\n";
                }

                $email = stripslashes($_POST['email']);

                $emailpattern = "/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/";
                //Validating email input.
                //Source for email pattern https://stackoverflow.com/questions/201323/how-can-i-validate-an-email-address-using-a-regular-expression
                if (!preg_match($emailpattern, $email))
                {
                    $errorMsg .= "Email is not in the correct format.\n";
                }

                $phone = stripslashes($_POST['phone']);

                $phonepattern = "/^(\+?\(61\)|\(\+?61\)|\+?61|\(0[1-9]\)|0[1-9])?( ?-?[0-9]){7,9}$/";
                //Validating phone number.
                //Source for phone pattern: https://stackoverflow.com/questions/39990179/regex-for-australian-phone-number-validation
                if (!preg_match($phonepattern, $phone))
                {
                    $errorMsg .= "Phone number in correct format.\n";
                }

                //Checking if errors exist.
                if (strlen($errorMsg) > 0)
                {
                    //Displaying errors in list
                    $errorarray = explode("\n", $errorMsg);

                    echo "<p>The following issue(s) have been encountered:</p>";
                    echo "<ul>";

                    foreach ($errorarray as $error) 
                    {
                        if ($error != "")
                        {
                            echo "<li>$error</li>";
                        }
                    }

                    echo "</ul>";
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

                    //Query to create table if it does not exist
                    $tablequery = "CREATE TABLE IF NOT EXISTS members (
                        'member_id' INT NOT NULL AUTO_INCREMENT,
                        'fname' varchar(20) NOT NULL,
                        'lname' varchar(20) NOT NULL,
                        'email' varchar(255) NOT NULL,
                        'phone' varchar(255) NOT NULL,
                        PRIMARY KEY (member_id)
                    );";
                    
                    //Execute table creation query
                    $conn->query($tablequery);

                    //Query to insert new member into members table with form data.
                    $insertquery = "INSERT INTO `members` (`fname`, `lname`, `email`, `phone`) VALUES ('$fname', '$lname', '$email', '$phone');";

                    //Executes insert query and checks results from query.
                    if ($conn->query($insertquery) === TRUE)
                    {
                        echo "<p>New member has been added to the system</p>";
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
    </body>
</html>