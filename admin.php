<?php 

session_start();
include './config/database.php';
include './config/functions.php';
$messageError = "";
// Check if the table exists
$tableCheckQuery = "SHOW TABLES LIKE 'admins'";
$tableCheckResult = mysqli_query($conn, $tableCheckQuery);

if (mysqli_num_rows($tableCheckResult) == 0) {
    // The table does not exist, create it
    $createQuery = "CREATE TABLE `admins` (
        `admin_id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(100) NOT NULL,
        `first_name` varchar(100) NOT NULL,
        `last_name` varchar(100) NOT NULL,
        `email` varchar(100) NOT NULL,
        `password` varchar(100) NOT NULL,
        `date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`admin_id`) 
    )";
    
    mysqli_query($conn, $createQuery);
}



// Check if the admin data already exists
$usernameCheck = "SELECT * FROM admins WHERE username = 'admin'";
$result = mysqli_query($conn, $usernameCheck);

if (mysqli_num_rows($result) == 0) {
    // The admin data does not exist, insert it
    $insertQuery = "INSERT INTO admins (`username`, `first_name`, `last_name`, `email`, `password`) VALUES ('admin', 'john', 'doe', 'jd@gmail.com',  '1234')";
    mysqli_query($conn, $insertQuery);
}

// Check if the table exists
$tableCheckQuery = "SHOW TABLES LIKE 'cashiers'";
$tableCheckResult = mysqli_query($conn, $tableCheckQuery);

if (mysqli_num_rows($tableCheckResult) == 0) {
    // The table does not exist, create it
    $createQuery = "CREATE TABLE `cashiers` (
        `cashier_id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(100) NOT NULL,
        `first_name` varchar(100) NOT NULL,
        `last_name` varchar(100) NOT NULL,
        `email` varchar(100) NOT NULL,
        `password` varchar(100) NOT NULL,
        `date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
        PRIMARY KEY (`cashier_id`) 
    )";
    
    mysqli_query($conn, $createQuery);
}



// Check if the cashier data already exists
$usernameCheck = "SELECT * FROM cashiers";
$result = mysqli_query($conn, $usernameCheck);

if (mysqli_num_rows($result) == 0) {
    // The admin data does not exist, insert it
    $insertQuery = "INSERT INTO cashiers (`username`, `first_name`, `last_name`, `email`, `password`) VALUES ('cashier', 'Jamie', 'Doe', 'jamied@gmail.com',  '123')";
    mysqli_query($conn, $insertQuery);
}



    //Checking if the user click submit
    if($_SERVER['REQUEST_METHOD'] == "POST") {
        //
        $username = $_POST['username'];
        $password = $_POST['password'];
        $messageError = "";
         
        //Checking if all inputs are not empty
        if(!empty($username) && !empty($password) && !is_numeric($username)) {

            //reading from database
            $query = "SELECT * FROM admins WHERE username = '$username' limit 1";
            $result = mysqli_query($conn, $query);

            //Checking if the results are true
            if ($result) {
                //Checking if the the no. of rows in results are greater than zero which can indicate if the username are associated to an account
                if (mysqli_num_rows($result) > 0)
                    {
                        //Assigning query result to the variable
                        $user_data = mysqli_fetch_assoc($result);

                        //Checking password and assigning the session id as user_data id
                            if($user_data['password'] === $password) {
                                $_SESSION['admin_id'] = $user_data['admin_id'];
                                //Checking if user is admin or not 
                                    header("Location: dashboard.php");
                                    die();

                            }
                            $messageError =  "Wrong password or username";
                    }
                    else {
                        $messageError =  "Your username is not associated to any account";
                    }
             }
        }
        else {
            $messageError = "Please enter some valid information";
        }
        } 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
        <div></div>
        <div class="left-container-img">
            <img src="img/Hardware.svg">
        </div>
        <form method="post">
            <div class="form-header">
                <h2>ADMIN LOGIN</h2>
            </div>
            <div class="form-group">
                <input type="text" name="username" placeholder="Enter your username">
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Enter your password">
            </div>
            <div class="form-group forgot-password">
                <a href="#">Forgot password?</a>
            </div>
            <p><?php echo $messageError?></p>
            <div class="form-group">
                <button id="submit-btn" name="submit" class="bg-warning">Sign in</button>
            </div>
        </form>
    </div>
</body>
</html>