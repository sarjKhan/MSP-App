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
                <label for="username">Username: </label>
                <input type="text" name="username" id = "username" placeholder="abcd1234">
            </div>
            <div>
                <label for="psswrd">Password: </label>
                <input type="password" name="password" id="password" placeholder=" ***********">
            </div>
            <input type="submit" name="Submit" value="Login"/>
            <div onclick = "updates()" id ="forgotpw"><u> Forgot password?</u></div>
        </fieldset>
        </form>
        </center>
    </body>
</html>