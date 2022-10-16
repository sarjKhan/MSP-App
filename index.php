<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Title" content="GotoGro Memeber Management Sysytem" />
    <meta name="Authors" content="Sartaj Khan, Eddie Taing, Conrad Kotz, Jack Wylde" />
    <link rel="stylesheet" href="styles.css" />
    <style>
        .content-table {
			border-collapse: collapse;
			font-size: 1.2em;
			min-width: 400px;
			border-radius: 5px 5px 0 0;
			overflow: hidden;
			box-shadow: 0 0 20px rgba(255, 255, 255, 0.20);
            margin: auto;
            
		}
		.content-table th tr {
			background-color: #009879;
			color: white;
			text-align: center;
		}
		.content-table th, .content-table tr {
			padding: 12px 15px;
		}
		.content-table tr {
			border-bottom: 1px solid #dddddd;
		}
		.content-table tr:last-of-type{
			border-bottom: 2px solid #dddddd;
		}
        

        #neworderbutton {
            position:relative;
            top: 100px;
            zoom: 150%;

            }
        
        @keyframes bloom {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }
        .reminder {
            opacity: 0;
            position:relative;
            top: 200px;
        }
        .reminder {
            animation: bloom 2s;
            animation-delay: 3s;
            animation-fill-mode: forwards;
        }
    </style>
    <script src="./features.js"></script>
    <title>Home Page</title>
</head>

<body>
    <?php
        include 'nav.php';

        session_start();

        if (!isset($_SESSION['loggedin']))
        {
            $_SESSION['message'] = "Must be logged in";
            header("location: log_in.php");
        }

        if (isset($_SESSION['message']))
        {
            echo "<p>" . $_SESSION['message'] . "</p>";
            unset($_SESSION['message']);
        }
    ?>

    <div>
        <h1 class="index_h1">Welcome to GoToGro Member Management System</h1>
        <h2 class="index_h2">What would you like to do today: </h2>

        <a href="manage_members.php"><button class="button" id="index_button">Manage Members</button></a>
        <a href="search_sales.php"><button class="button" id="index_button">Search Existing Customer
                Orders</button></a>

        <div>
            <a id="neworderbutton" class="index_h2" href="add_sales.php"><button class="button">Create New Customer Order</button></a>
        </div>
    </div>
    <!--Grocery Needs In Next 3 days-->
        <?php
            require_once('settings.php');
            require_once("phpfunctions.php");

            //Creating database connection
            $conn = new mysqli($host, $user, $pswd, $db);

            //Check if error with connection
            if ($conn->connect_errno)
            {
                echo "<p>Failed to connect to database: " . $conn->connect_error . "</p>";
                exit();
            }

            createSalesTable($conn);

            $selectquery = "SELECT * FROM sales_records WHERE due_date <= NOW() + INTERVAL 3 day";

            $result = $conn->query($selectquery);
            echo "<div class='reminder'>";
            echo "<h2>Upcoming Grocery Needs Due:</h2>";

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
                echo "</div>";
            }
            else
            {
                echo "<p>No upcoming grocery needs.</p>";
            }

            $conn->close();
        ?>
</body>

</html>