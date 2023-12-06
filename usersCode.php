<?php
include('./config/database.php');
include('./config/functions.php');
// <----------------PHP FOR USERS------------------------------------//
// PHP form handler to register user
if (isset($_POST['register_user'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $selected_account = $_POST['account-type'];
    $confirmPassword = $_POST['confirmPassword'];

    //Validating the input
    $firstname = htmlspecialchars($firstname);
    $lastname = htmlspecialchars($lastname);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $username = htmlspecialchars($username);

    // Checking if all inputs are not empty
    if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($username) && !empty($password) && !empty($confirmPassword) && !is_numeric($username)) {
        if ($password === $confirmPassword) 
        {
            // Check account type and create a query to where it will insert
            if ($selected_account == 'Admin') {
                $query = "INSERT INTO admins (`username`, `first_name`, `last_name`, `email`, `password`) VALUES ('$username', '$firstname', '$lastname', '$email',  '$password')";
            }
            else {
                $query = "INSERT INTO cashiers (`username`, `first_name`, `last_name`, `email`, `password`) VALUES ('$username', '$firstname', '$lastname', '$email',  '$password')";
            }

            $result = mysqli_query($conn, $query);

            //Checking if the connection and query are success
            if ($result) 
            {
                $response = [
                    'status' => 200, 
                    'message'=> 'User created successfully'
                ];
        
                echo json_encode($response);
                return;

            } 
            else 
            {
                $response = [
                    'status' => 500, //Error
                    'message'=> 'User did not added'
                ];
        
                echo json_encode($response);
                return;
            }
        } 
        else 
        {
            $response = [
                'status' => 422, //Error
                'message'=> 'Password does not match'
            ];

            echo json_encode($response);
            return;
        }
    }
    else 
    {
        $response = [
            'status' => 422, //Error
            'message'=> 'Please enter valid information'
        ];

        echo json_encode($response);
        return;
        
    }
}

//PHP form handler to delete admin
if(isset($_POST['delete_admin']))
{
    $admin_id = $_POST['admin_id'];

    $deleteQuery = "DELETE FROM `admins` WHERE admin_id = '$admin_id'";
    $result= mysqli_query($conn, $deleteQuery);

    if($result)
    {
        $response = [
            'status' => 200,
            'message' => 'Admin Deleted Successfully'
        ];
        echo json_encode($response);
        return;
    }
    else
    {
        $response = [
            'status' => 500,
            'message' => 'Admin Not Deleted'
        ];
        echo json_encode($response);
        return;
    }
}

//PHP form handler to delete cashier
if(isset($_POST['delete_cashier']))
{
    $cashier_id = $_POST['cashier_id'];

    $deleteQuery = "DELETE FROM `cashiers` WHERE cashier_id = '$cashier_id'";
    $result= mysqli_query($conn, $deleteQuery);

    if($result)
    {
        $response = [
            'status' => 200,
            'message' => 'Cashier Deleted Successfully'
        ];
        echo json_encode($response);
        return;
    }
    else
    {
        $response = [
            'status' => 500,
            'message' => 'Cashier Not Deleted'
        ];
        echo json_encode($response);
        return;
    }
}

// <----------------END PHP FOR USERS------------------------------------//


?>