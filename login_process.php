<?php     
	session_start();

    require_once ("settings.php");
    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
    if (!$conn) {
        echo "< p>Connection Failure </p>"; 
    }

    if (empty($_POST['usrname']) || empty($_POST['psswrd']))
        {
            echo ("<script type='text/javascript'>alert('Username OR Password fields cannot be empty');
            history.go(-1);</script>");
            die();
        }

    else {
        $user = $_POST["usrname"];

        $pass = $_POST["psswrd"];


        $query = "SELECT * FROM login WHERE username=$user AND password=$pass";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            echo "<script type='text/javascript'>
            document.location='index.html'</script>";
        }
        else {
            echo "<script type='text/javascript'>alert('Invalid Username or Password');
            history.go(-1);</script>";
        }
    }

?>