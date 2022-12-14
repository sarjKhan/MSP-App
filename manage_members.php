<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Title" content="GotoGro Memeber Management Sysytem"/>
    <meta name="Authors" content="Sartaj Khan, Eddie Taing, Conrad Kotz, Jack Wylde"/>
    <link rel="stylesheet" href="styles.css"/>
    <script src="./scripts.js"></script>
    <title>Manage Members</title>
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
    
    <h1 class="index_h1">What would you like to do:</h1>
    <a href="add_members.php"><button class="button" id="index_button">Add New Member</button></a>
    <a href="search_members.php"><button class="button" id="index_button">Search Existing Member</button></a>
    <a href="index.php" class="choose_back"><p class="back">&larr;&nbsp;Go Back</p></a>
</body>
</html>