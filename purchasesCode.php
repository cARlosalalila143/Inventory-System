<?php
include('./config/database.php');
include('./config/functions.php');


// <----------------PHP FOR PURCHASES------------------------------------//

// <________ADDING PURCHASES FORM HANDLER_______________>
if(isset($_POST['new_purchase'])){
  $orderNumber = $_POST['order-number'];
  $productName = $_POST['product-name'];
  $category = $_POST['category'];
  $quantity = $_POST['quantity'];

  //Validating
  $orderNumber = htmlspecialchars($orderNumber);
  $productName = htmlspecialchars($productName);
  $category = htmlspecialchars($category);

  //Checking if all inputs are not empty
  if(!empty($orderNumber) && !empty($productName) && !empty($category) && !empty($quantity)) 
  {
      //Inserting to database
      $query = "INSERT INTO `purchases`(`order_number`, `product`, `category`, `quantity`) VALUES ('$orderNumber','$productName','$category','$quantity')";

      if (mysqli_query($conn, $query)) 
      {
          $response = [
              'status' => 200, 
              'message'=> 'New Purchase Order is Successful'
          ];
  
          echo json_encode($response);
          return;
      }
      else 
      {
          $response = [
              'status' => 500, //Error
              'message'=> 'Purchase Order did not added'
          ];
  
          echo json_encode($response);
          return;
      }
    }

    else
    {
        $response = [
            'status' => 422, //Error
            'message'=> 'All purchase order details should be completed'
        ];

        echo json_encode($response);
        return;
    }
  }
// <________UPDATING PURCHASE FORM HANDLER_______________>

if (isset($_GET['editPurchase'])) {
    $purchase_id = $_GET['purchase_id'];

    $query = "SELECT * FROM purchases WHERE purchase_id='$purchase_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $purchase = mysqli_fetch_array($result);
        $response = [
            'status' => 200,
            'message' => 'Purchase Order Details',
            'data' => $purchase
        ];

        echo json_encode($response);
    } else {
        $response = [
            'status' => 404,
            'message' => 'Purchase ID did not found'
        ];

        echo json_encode($response);
    }
}

if(isset($_POST['update_purchase'])){
    $purchase_id = $_POST['purchase_id'];
    $orderNumber = $_POST['order-number'];
    $productName = $_POST['product-name'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];

    //Checking if all inputs are not empty
    if(!empty($orderNumber) && !empty($productName) && !empty($category) && !empty($quantity)) 
    {
        
        //Inserting to database
        $query = "UPDATE purchases SET order_number ='$orderNumber', product='$productName', category='$category', quantity='$quantity' WHERE purchase_id= '$purchase_id'";


        if (mysqli_query($conn, $query)) 
        {
            $response = [
                'status' => 200, 
                'message'=> 'Purchases Updated Successfully'
                
            ];
    
            echo json_encode($response);
            return;
        }
        else 
        {
            $response = [
                'status' => 500, //Error
                'message'=> 'Update purchase order is not successful'
            ];
    
            echo json_encode($response);
            return;
        }

    }
    else
    {
        $response = [
            'status' => 422, //Error
            'message'=> 'All purchase order details should be completed'
        ];

        echo json_encode($response);
        return;
    }
}




if(isset($_POST['delete_purchase'])){
    $purchase_id = $_POST['purchase_id'];

    $query = "DELETE FROM purchases WHERE purchase_id='$purchase_id'";
    $result= mysqli_query($conn, $query);

    if($result)
    {
        $response = [
            'status' => 200,
            'message' => 'Purchase Order Deleted Successfully'
        ];
        echo json_encode($response);
        return;
    }
    else
    {
        $response = [
            'status' => 500,
            'message' => 'Purchase Order Not Deleted'
        ];
        echo json_encode($response);
        return;
    }
}

if(isset($_POST['searchInput'])) {

   $searchInput = $_POST['searchInput'];

   $query = "SELECT * FROM purchases WHERE  purchase_id='$searchInput' OR order_number LIKE '{$searchInput}%' OR  product LIKE '{$searchInput}%' OR  category LIKE '{$searchInput}%' OR  quantity LIKE '{$searchInput}%' ";
   $result = mysqli_query($conn, $query);
        if($result) {
            if(mysqli_num_rows($result) > 0) {   
            
            ?>
            <table class="table search-table table-warning text-center">
            <thead class="">
                <tr>
                <th>Code</th>
                <th>Order Number</th>
                <th>Product</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Order Date</th>
                <th>Action</th>
                </tr> 
            </thead>    
            <tbody>
            
            <?php
                while($fetch = mysqli_fetch_assoc($result)) {
                    $purchaseId = $fetch['purchase_id'];
                    $orderNumber = $fetch['order_number'];
                    $productName = $fetch['product'];
                    $category = $fetch['category'];
                    $quantity = $fetch['quantity'];
                    $date_added = $fetch['date_added'];
                
            ?>
                <tr>
                    <td><?php echo $purchaseId ?></td>
                    <td><?php echo $orderNumber ?></td>
                    <td><?php echo $productName?></td>
                    <td><?php echo $category ?></td>
                    <td><?php echo $quantity ?></td>
                    <td><?php echo $date_added ?></td>
                    
                    <td class='action'>
                        <button type='button' value='<?php echo $purchaseId?>' class='editPurchBtn action-btn opacity-btn'  data-bs-toggle='modal' data-bs-target='#editPurchModal' tabindex='-1' >
                        <i class='fa-regular fa-pen-to-square p-2 bgYellow text-white'></i>
                        </button>
                        <button type='button' value='<?php echo $purchaseId?>' class='deletePurchBtn delete-btn action-btn opacity-btn'>
                        <i class='fa-solid fa-trash p-2  bgMaroon text-white'></i>
                        </button>
                    </td>
                </tr>
            
                <?php } ?>
            </tbody>

            </table>
            <?php
            }else {
                echo "<h3 class='text-danger text-center search-table'> Data not found</h3>";
            }
}

}


