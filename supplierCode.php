<?php
include('./config/database.php');
include('./config/functions.php');

// <----------------PHP FOR SUPPLIER------------------------------------//

// <________ADDING SUPPLIER FORM HANDLER_______________>
if(isset($_POST['add_supplier'])){
    $businessName = $_POST['business-name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $totalOrder = $_POST['total-order'];
    
    
    //Validating
    $businessName = htmlspecialchars($businessName);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    //Checking if all inputs are not empty
    if(!empty($businessName) && !empty($contact) && !empty($email) && !empty($email)) 
    {


        //Inserting to database
        $query = "INSERT INTO `suppliers`(`business_name`, `contact_number`, `email`, `total_order`) VALUES ('$businessName','$contact','$email','$totalOrder')";

        if (mysqli_query($conn, $query)) 
        {
            $response = [
                'status' => 200, 
                'message'=> 'Supplier Added Successfully'
            ];
    
            echo json_encode($response);
            return;
        }
        else 
        {
            $response = [
                'status' => 500, //Error
                'message'=> 'Supplier did not added'
            ];
    
            echo json_encode($response);
            return;
        }

    }
    else
    {
        $response = [
            'status' => 422, //Error
            'message'=> 'All suppliers details should be completed'
        ];

        echo json_encode($response);
        return;
    }
}

// <________UPDATING PRODUCT FORM HANDLER_______________>

if (isset($_GET['editSupplier'])) {
    $supplier_id = $_GET['supplier_id'];

    $query = "SELECT * FROM suppliers WHERE supplier_id='$supplier_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $supplier = mysqli_fetch_array($result);
        $response = [
            'status' => 200,
            'message' => 'Supplier Details',
            'data' => $supplier
        ];

        echo json_encode($response);
    } else {
        $response = [
            'status' => 404,
            'message' => 'Supplier Id did not found'
        ];

        echo json_encode($response);
    }
}

if(isset($_POST['update_supplier'])){
    $supplier_id = $_POST['supplier_id'];
    $businessName = $_POST['business-name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $totalOrder = $_POST['total-order'];

    //Validating
    $businessName = htmlspecialchars($businessName);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);


    //Checking if all inputs are not empty
    if(!empty($businessName) && !empty($contact) && !empty($email) && !empty($totalOrder)) 
        {

            //Inserting to database
            $query = "UPDATE suppliers SET business_name='$businessName', contact_number='$contact', email='$email', total_order='$totalOrder' WHERE supplier_id= '$supplier_id'";
            if (mysqli_query($conn, $query)) 
            {
                $response = [
                    'status' => 200, 
                    'message'=> 'Supplier Updated Successfully'
                    
                ];
        
                echo json_encode($response);
                return;
            }
            else 
            {
                $response = [
                    'status' => 500, //Error
                    'message'=> 'Update supplier is not successful'
                ];
        
                echo json_encode($response);
                return;
            }

        }
        else
        {
            $response = [
                'status' => 422, //Error
                'message'=> 'All supplier details should be completed'
            ];

            echo json_encode($response);
            return;
        }
}

if(isset($_POST['delete_supplier']))
{
    $supplier_id = $_POST['supplier_id'];

    $query = "DELETE FROM suppliers WHERE supplier_id='$supplier_id'";
    $result= mysqli_query($conn, $query);

    if($result)
    {
        $response = [
            'status' => 200,
            'message' => 'Supplier Deleted Successfully'
        ];
        echo json_encode($response);
        return;
    }
    else
    {
        $response = [
            'status' => 500,
            'message' => 'Supplier Not Deleted'
        ];
        echo json_encode($response);
        return;
    }
}
