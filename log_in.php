<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="Title" content="GotoGro Memeber Management Sysytem" />
        <meta name="Authors" content="Sartaj Khan, Eddie Taing, Conrad Kotz, Jack Wylde"/>
        <title>Log In</title>
        <link rel="stylesheet" href="styles.css" />
        <script src="./features.js"></script>
    </head>
    <body>
        <?php

            include 'nav.php'

        ?>
        <h1>GoToGro Member login</h1>
        <center>
        <form method="post" action="login_process.php">
            <fieldset class="add_form">
            <div class="input">
                <label for="usrname">Username: </label>
                <input type="text" name="usrname" id = "username" placeholder="abcd1234">
            </div>
            <div>
                <label for="psswrd">Password: </label>
                <input type="password" name="psswrd" id="password" placeholder=" ***********">
            </div>
            <button type="submit" name = "login" class="button">Log In</button>
            <div onclick = "updates()" id ="forgotpw"><u> Forgot password?</u></div>
        </fieldset>
        </form>
        </center>
    </body>
</html>