<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="Title" content="GotoGro Memeber Management Sysytem" />
    <meta name="Authors" content="Sartaj Khan, Eddie Taing, Conrad Kotz, Jack Wylde"/>
    <title>Search Member</title>
    <link rel="stylesheet" href="styles.css" />  
    <script src="./validate_add_member.js"></script>
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
    <form id="members_form" method="post" action="searchmemberprocess.php">

        <fieldset class="add_form">
            <legend>Search Member:</legend><br>
            <div>
                <div class="input">
                    <label for="member_id">Customer Number:&nbsp;</label><br>
                    <input id="member_id" type="number" name="member_id" placeholder="XXXX" onkeyup="validateMemId()">
                    <span id="mem_id_error"></span>
                </div>
                <div class="input">
                    <br><label for="f_name">First Name:&nbsp;</label><br>
                    <input id="f_name" type="text" name="f_name" placeholder="John" onkeyup="validateFName()">
                    <span id="fname_error"></span>
                                 
                </div>
                <div class="input">
                    <br><label for="l_name">Last Name:&nbsp;</label><br>
                    <input id="l_name" type="text" name="l_name" placeholder="Smith" onkeyup="validateLName()">
                    <span id="lname_error"></span>
                </div>
                <div class="input">
                    <br><label for="product">Phone Number:&nbsp;</label><br>
                    <input id="phone" type="text" name="product" placeholder="xxxx xxx xxx" onkeyup="validatePhone()">
                    <span id="phone_error"></span>
                </div>
                <div class="input">
                    <br><label for="qnt">Email:&nbsp;</label><br>
                    <input id="email" type="email" name="qnt" min="0" placeholder="abcd@domain.com" onkeyup="validateAddress()">
                    <span id="email_error"></span>
                </div>
                <span id="submit_error"></span>
                <button type="submit" class="button" onclick="return validateForm()">Search</button>
            </div>
        </fieldset>
    </form>
    <a href="manage_members.php">
        <p class="back">&larr;&nbsp;Go Back</p>
    </a>
</body>
</html>