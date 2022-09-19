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
            if (isset($_POST['member_id']) && isset($_POST['f_name']) && isset($_POST['l_name']) && isset($_POST['email']) && isset($_POST['phone']))
            {
                $errorMsg = array();


                $member_id = stripslashes($_POST['member_id']);


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

                $fname = stripslashes($_POST['f_name']); 

                $fnamepattern = "/^[a-zA-Z- ]+$/"; 
                //Validating first name meets format.
                if (strlen($fname) < 1 || strlen($fname) > 20 || !preg_match($fnamepattern, $fname))
                {
                    $errorMsg[] = "First name is not in the correct format. It must be between 1 and 20 characters and contain only letters, hypens and spaces.\n";
                }

                $lname = stripslashes($_POST['l_name']);

                $lnamepattern = "/^[a-zA-Z]+$/";
                //Validating last name meets format.
                if (strlen($lname) < 1 || strlen($lname) > 20 || !preg_match($lnamepattern, $lname))
                {
                    $errorMsg[] = "Last name is not in the correct format. It must be between 1 and 20 characters and contain only letters.\n";
                }

                $email = stripslashes($_POST['email']);

                $emailpattern = "/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/";
                //Validating email input.
                //Source for email pattern https://stackoverflow.com/questions/201323/how-can-i-validate-an-email-address-using-a-regular-expression
                if (!preg_match($emailpattern, $email))
                {
                    $errorMsg[] = "Email is not in the correct format.\n";
                }

                $phone = stripslashes($_POST['phone']);

                $phonepattern = "/^(\+?\(61\)|\(\+?61\)|\+?61|\(0[1-9]\)|0[1-9])?( ?-?[0-9]){7,9}$/";
                //Validating phone number.
                //Source for phone pattern: https://stackoverflow.com/questions/39990179/regex-for-australian-phone-number-validation
                if (!preg_match($phonepattern, $phone))
                {
                    $errorMsg .= "Phone number in correct format.\n";
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
                    $tablequery = "CREATE TABLE IF NOT EXISTS members (
                        member_id INT NOT NULL AUTO_INCREMENT,
                        fname varchar(20) NOT NULL,
                        lname varchar(20) NOT NULL,
                        email varchar(255) NOT NULL,
                        phone varchar(255) NOT NULL,
                        PRIMARY KEY (member_id)
                    );";

                    //Execute table creation query
                    if ($conn->query($tablequery) === FALSE)
                    {
                        echo "<p>Error with database: " . $conn->error . "</p>";
                    }

                    $updatquery = "UPDATE `members` SET `member_id` = $member_id , `fname` = '$fname' , `lname` = '$lname' , `email` = '$email' , `phone` = '$phone' WHERE `member_id` = $member_id;";

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