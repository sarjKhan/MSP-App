<?php     
	session_start();

    //Checking if form has been set
    //If empty($_POST['username']) can be used interchangeably 
    if (isset($_POST['username']) && isset($_POST['password']))
    {
        //Setting form input to variable
        $username = $_POST["username"];

        //Validation on username needs to be done.

        $password = $_POST["password"];

        //Validation on password needs to be done.

        require_once ("settings.php");

        //@mysqli_connect() can be used interchangeably
        $conn = new mysqli($host, $user, $pswd, $db);

        //Check if error with connection
        if ($conn->connect_errno)
        {
            echo "<p>Failed to connect to database: " . $conn->connect_error . "</p>";
            exit();
        }

        //Query to create table if it does not exist
        $logintable = "CREATE TABLE IF NOT EXISTS login (
            user_id INT NOT NULL AUTO_INCREMENT,
            username VARCHAR(20) NOT NULL,
            password VARCHAR(20) NOT NULL,
            PRIMARY KEY(user_id)
        );";

        //Executing create table query
        $conn->query($logintable);

        //Query to find login info
        $query = "SELECT * FROM login WHERE username='$username' AND password='$password'";

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            //Login succcess. Do something.
            $_SESSION['loggedin'] = "success";
            $_SESSION['message'] = "Successfully logged in.";
            header("location: index.php");
        }
        else {
            //Login failed. Go back to login screen.
            $_SESSION['message'] = "Failed to log in.";
            header("location: log_in.php");
        }
    }
    else
    {
        echo ("<script type='text/javascript'>alert('Username OR Password fields cannot be empty');
        history.go(-1);</script>");
    }

?>