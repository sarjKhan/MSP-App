<?php
	function createMemberTable($conn)
	{
        //Query to create table if it does not exist
        $tablequery = "CREATE TABLE IF NOT EXISTS members (
            member_id INT NOT NULL AUTO_INCREMENT,
            fname varchar(20) NOT NULL,
            lname varchar(20) NOT NULL,
            email varchar(255) NOT NULL,
            phone varchar(255) NOT NULL,
            active BOOLEAN NOT NULL,
            PRIMARY KEY (member_id)
        );";
                    
        //Execute table creation query
        $conn->query($tablequery);
	}

	function createSalesTable($conn)
	{
		//Query to create table if it does not exist
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

        //Execute table creation query
        $conn->query($tablequery);
	}

	function displayErrors($errors)
	{
		echo "<p>The following errors have been encountered:</p>";
		echo "<ul>";

		foreach ($errors as $error) 
		{
			echo "<li>$error</li>";
		}

		echo "</ul>";
	}

    function sanitiseInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlentities($data);
        return $data;
    }
?>