<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Title" content="GotoGro Memeber Management Sysytem" />
    <meta name="Authors" content="Sartaj Khan, Eddie Taing, Conrad Kotz, Jack Wylde" />
    <link rel="stylesheet" href="styles.css" />
    <script src="./features.js"></script>
    <title>Home Page</title>
</head>

<body>
    <div class="topnav">
        <img onclick="document.location.href='index.html'" id="logo" src="images/grocery icon.png" alt="logo"
            width="70" height="70">
        <a class="active" href="index.html">Home</a>
        <a href="log_in.php">Log-in</a>
    </div>


    <div>
        <h1 class="index_h1">Welcome to GoToGro Member Management System</h1>
        <h2 class="index_h2">What would you like to do today: </h2>

        <a href="manage_members.html"><button class="button" id="index_button">Manage Members</button></a>
        <a href="search_sales.html"><button class="button" id="index_button">Search Existing Customer
                Orders</button></a>

        <div>
            <a id="neworderbutton" class="index_h2" href="add_sales.php"><button class="button">Create New Customer Order</button></a>
        </div>
    </div>
    <!--Grocery Needs In Next 3 days-->
        <?php
            require_once('settings.php');

            //Creating database connection
            $conn = new mysqli($host, $user, $pswd, $db);

            //Check if error with connection
            if ($conn->connect_errno)
            {
                echo "<p>Failed to connect to database: " . $conn->connect_error . "</p>";
                exit();
            }

            $tablequery = "CREATE TABLE IF NOT EXISTS sales_records (
                sales_id INT NOT NULL AUTO_INCREMENT,
                member_id INT NOT NULL,
                item_name varchar(20) NOT NULL,
                item_quantity INT NOT NULL,
                due_date DATE NOT NULL,
                active BOOLEAN NOT NULL,
                PRIMARY KEY (sales_id),
                FOREIGN KEY (member_id) REFERENCES members(member_id)
            );";

            $conn->query($tablequery);

            $selectquery = "SELECT * FROM sales_records WHERE due_date <= NOW() + INTERVAL 3 day";

            $result = $conn->query($selectquery);

            echo "<h2>Upcoming Grocery Needs.</h2>";

            if ($result->num_rows > 0)
            {
                echo "<table class='content-table'>";
                echo "<tr><th>Sales ID</th><th>Member ID</th><th>Item Name</th><th>Item Quantity</th><th>Due Date</th></tr>";

                while ($searchresult = $result->fetch_assoc())
                {
                    echo "<tr>";
                    echo "<td>" . $searchresult['sales_id'] . "</td>";
                    echo "<td>" . $searchresult['member_id'] . "</td>";
                    echo "<td>" . $searchresult['item_name'] . "</td>";
                    echo "<td>" . $searchresult['item_quantity'] . "</td>";
                    echo "<td>" . $searchresult['due_date'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            }
            else
            {
                echo "<p>No upcoming grocery needs.</p>";
            }

            $conn->close();
        ?>
</body>

</html>