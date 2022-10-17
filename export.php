<?php
    session_start();
    if (isset($_SESSION['searchresults']))
    {
        $data = $_SESSION['searchresults'];
        $delimiter = ",";
        $filename = "Sales_data_".date('Y-m-d').".csv";

        //create file pointer
        $f = fopen('php://memory', 'w');

        //set column headers
        $fields = array('SALES ID', 'MEMBER ID', 'PRODUCT NAME', 'QUANTITY', 'DUE DATE');
        fputcsv($f, $fields, $delimiter);

        //output each row of the data
        foreach ($data as $result) {
            // code...
            $date = $result['due_date'];
            settype($date, 'string');
            $lineData = array($result['sales_id'], $result['member_id'], $result['item_name'], $result['item_quantity'], $date);
            fputcsv($f, $lineData, $delimiter);
        }

        fseek($f, 0);

        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="'. $filename .'";');

        fpassthru($f);

        unset($_SESSION['searchresults']);
        
    }
?>