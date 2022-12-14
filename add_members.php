<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Title" content="GotoGro Memeber Management Sysytem" />
    <meta name="Authors" content="Sartaj Khan, Eddie Taing, Conrad Kotz, Jack Wylde"/>
    <title>Add Member</title>
    <link rel="stylesheet" href="styles.css" />  
    <!--<script src="./scripts.js"></script> -->
    <script defer src="./validate_add_members.js"></script>
    <script src="https://kit.fontawesome.com/5f307a1918.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        include "nav.php";

        session_start();

        if (!isset($_SESSION['loggedin']))
        {
            $_SESSION['message'] = "Must be logged in";
            header("location: log_in.php");
        }
    ?>

    <h1>GotoGro Memeber Management System</h1>
    <form id="members_form" method="post" action="addmemberprocess.php">

        <fieldset class="add_form">
            <legend>Add Member:</legend><br>
            <div>
                <div class="input">
                    <label for="f_name">First Name:&nbsp;</label><br>
                    <input id="f_name" type="text" name="f_name" placeholder="John" onkeyup="validateFName()">
                    <span id="fname_error"></span>
                </div>
                <div class="input">
                    <br><label for="l_name">Last Name:&nbsp;</label><br>
                    <input id="l_name" type="text" name="l_name" placeholder="Smith" onkeyup="validateLName()">
                    <span id="lname_error"></span>
                </div>
                <div class="input">
                    <br><label for="email">Email:&nbsp;</label><br>
                    <input id="email" type="email" name="email" min="0" placeholder="abcd@domain.com" onkeyup="validateEmail()">
                    <span id="email_error"></span>
                </div>
                <div class="input">
                    <br><label for="phone">Phone Number:&nbsp;</label><br>
                    <input id="phone" type="text" name="phone" placeholder="xxxxxxxxxx" onkeyup="validatePhone()">
                    <span id="phone_error"></span>
                </div>
                <span id="submit_error"></span>
                <button type="submit" class="button" onclick="return validateForm()"> Add Member</button>
                <button type="reset" class="button">Reset</button>
            </div>
        </fieldset>
    </form>
    <a href="manage_members.php">
        <p class="back">&larr;&nbsp;Go Back</p>
    </a>
</body>

</html>