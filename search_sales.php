<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Title" content="GotoGro Memeber Management Sysytem"/>
    <meta name="Authors" content="Sartaj Khan, Eddie Taing, Conrad Kotz, Jack Wylde"/>
    <link rel="stylesheet" href="styles.css"/>
    <script defer src="./validate_search_sales.js"></script>
    <title>Search Sales</title>
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
    <form method="POST" action="searchsalesprocess.php">
        <fieldset class="add_form">
            <legend>Search:</legend>
            <div>
                <div class="input">
                    <br><label for="member_id">Customer Number:&nbsp;</label><br>
                    <input type="number" name="member_id" id="member_id"placeholder="xxxxxxx"/>
                </div>
                <div class="input">
                    <br><label for="item_name">Item Name:&nbsp;</label><br>
                    <input type="text" name="item_name" id="item_name" placeholder="Name of item"/>
                </div>
                <div class="input">
                    <br><label for="item_quantity">Item Quantity:&nbsp;</label><br>
                    <input type="number" name="item_quantity" id="item_quantity" placeholder="xx"/>
                </div>
                <div class="input">
                    <br><label for="due_date">Due Date:&nbsp;</label><br>
                    <input type="date" name="due_date" id="due_date"/>
                </div>
                <button type="submit" class="button">Search</button>
                <button type="reset" class="button">Reset</button>
            </div>
        </fieldset>
    </form>
    <a href="index.php"><p class="back">&larr;&nbsp;Go Back</p></a>
</body>
</html>