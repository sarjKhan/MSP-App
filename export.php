<?php
    include_once 'settings.php';

    $selectquery = "SELECT * FROM `sales_records` WHERE ";
    $criteriacount = 0;

    //Checking if member id was set
    if (isset($_POST['member_id']) && isset($_POST['item_name']) && isset($_POST['item_quantity']) && isset($_POST['due_date']))
    {
        $member_id = $_POST['member_id'];
        //Validating member id
        if (is_numeric($member_id) && $member_id > 0)
        {
            //Adding member id to query
            $selectquery .= "`member_id`=$member_id AND ";
            $criteriacount++;
        }

        $item_name = $_POST['item_name'];
        $pattern = "/^[a-zA-Z0-9- ]+$/";
        //Validating item name
        if (strlen($item_name) > 0 && preg_match($pattern, $item_name))
        {
            //Adding item name to query
            $selectquery .= "`item_name`='$item_name' AND ";
            $criteriacount++;
        }

        $item_quantity = $_POST['item_quantity'];
        //Validating item quantity
        if (is_numeric($item_quantity))
        {
            if ($item_quantity > 0)
            {	
                //Adding item quantity to query.
                $selectquery .= "`item_quantity` = $item_quantity AND ";
                $criteriacount++;
            }    
        }

        //Validating date
        $due_date = $_POST['due_date'];
        //https://stackoverflow.com/questions/30243775/get-date-from-input-form-within-php
        if (!empty($due_date))
        {
            $due_date = strtotime($due_date);
            $due_date = date("Y-m-d", $due_date);

            //Adding due date to query
            $selectquery .= "`due_date`=$due_date AND ";
            $criteriacount++;
        }
    }

    if (isset($_GET['member_id']))
    {
        $member_id = $_GET['member_id'];

        if (is_numeric($member_id) && $member_id > 0)
        {
            //Adding member id to query
            $selectquery .= "`member_id`=$member_id AND";
            $criteriacount++;
        }
    }

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
    //Execute table creation query
    $conn->query($tablequery);

    $searchresultsarray = array();

    //Checking if any search was added.
    if ($criteriacount > 0)
    {
        //https://stackoverflow.com/questions/4915753/how-can-i-remove-three-characters-at-the-end-of-a-string-in-php
        $selectquery .= " active = TRUE ORDER BY due_date ASC";
        $result = $conn->query($selectquery);

    }
    else
    {
        //If no search criteria get all data from sales records table
        $selectquery = "SELECT * FROM sales_records WHERE active=TRUE ORDER BY due_date ASC";
        $result = $conn->query($selectquery);

    }

   if ($result->num_rows > 0){
        $delimiter = ",";
        $filename = "Sales_data_".date('Y-m-d').".csv";

        //create file pointer
        $f = fopen('php://memory', 'w');

        //set column headers
        $fields = array('SALES ID', 'MEMBER ID', 'PRODUCT NAME', 'QUANTITY', 'DUE DATE');
        fputcsv($f, $fields, $delimiter);

        //output each row of the data
        while($row = $result->fetch_assoc()){
            $date = strval($row['due_date']);
            $lineData = array($row['sales_id'], $row['member_id'], $row['item_name'], $row['item_quantity'], $date);
            fputcsv($f, $lineData, $delimiter);
        }

        fseek($f, 0);

        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="'. $filename .'";');

        fpassthru($f);
   } 
   exit;
