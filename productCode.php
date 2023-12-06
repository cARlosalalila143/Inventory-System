<?php
include('./config/database.php');
include('./config/functions.php');


// <----------------PHP FOR PRODUCT------------------------------------//

// <________ADDING PRODUCT FORM HANDLER_______________>
if(isset($_POST['add_product'])){
    $productName = $_POST['product-name'];
    $category = $_POST['category'];
    $unit = $_POST['unit'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $supplier = $_POST['supplier'];

    //Validating
    $productName = htmlspecialchars($productName);
    $category = htmlspecialchars($category);
    $unit = htmlspecialchars($unit);
    $supplier = htmlspecialchars($supplier);

    //Checking if all inputs are not empty
    if(!empty($productName) && !empty($category) && !empty($unit) && !empty($price) && !empty($quantity) && !empty($supplier)) 
    {
        $stock_status = check_stock_status(intval($quantity));

        //Inserting to database
        $query = "INSERT INTO `products`(`product`, `category`, `unit`, `price`, `quantity`, `stock_status`, `supplier`) VALUES ('$productName','$category','$unit','$price','$quantity','$stock_status','$supplier')";

        if (mysqli_query($conn, $query)) 
        {
            $response = [
                'status' => 200, 
                'message'=> 'Product Added Successfully'
            ];
    
            echo json_encode($response);
            return;
        }
        else 
        {
            $response = [
                'status' => 500, //Error
                'message'=> 'Product did not added'
            ];
    
            echo json_encode($response);
            return;
        }

    }
    else
    {
        $response = [
            'status' => 422, //Error
            'message'=> 'All product details should be completed'
        ];

        echo json_encode($response);
        return;
    }
}

// <________UPDATING PRODUCT FORM HANDLER_______________>

if (isset($_GET['editProduct'])) {
    $product_id = $_GET['product_id'];

    $query = "SELECT * FROM products WHERE product_id='$product_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $product = mysqli_fetch_array($result);
        $response = [
            'status' => 200,
            'message' => 'Product Details',
            'data' => $product
        ];

        echo json_encode($response);
    } else {
        $response = [
            'status' => 404,
            'message' => 'Product Id did not found'
        ];

        echo json_encode($response);
    }
}

if(isset($_POST['update_product'])){
    $product_id = $_POST['product_id'];
    $productName = $_POST['product-name'];
    $category = $_POST['category'];
    $unit = $_POST['unit'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $supplier = $_POST['supplier'];
    $status= "";

    //Checking if all inputs are not empty
    if(!empty($productName) && !empty($category) && !empty($unit) && !empty($price) && !empty($quantity) && !empty($supplier)) 
    {
        $stock_status = check_stock_status(intval($quantity));

        //Inserting to database
        $query = "UPDATE products SET product='$productName',category='$category', unit='$unit', price='$price',quantity='$quantity', stock_status='$stock_status', supplier='$supplier' WHERE product_id= '$product_id'";

        if (mysqli_query($conn, $query)) 
        {
            $response = [
                'status' => 200, 
                'message'=> 'Product Updated Successfully'
                
            ];
    
            echo json_encode($response);
            return;
        }
        else 
        {
            $response = [
                'status' => 500, //Error
                'message'=> 'Update product is not successful'
            ];
    
            echo json_encode($response);
            return;
        }

    }
    else
    {
        $response = [
            'status' => 422, //Error
            'message'=> 'All product details should be completed'
        ];

        echo json_encode($response);
        return;
    }
}





if(isset($_POST['delete_product'])){
    $product_id = $_POST['product_id'];

    $query = "DELETE FROM products WHERE product_id='$product_id'";
    $result= mysqli_query($conn, $query);

    if($result)
    {
        $response = [
            'status' => 200,
            'message' => 'Product Deleted Successfully'
        ];
        echo json_encode($response);
        return;
    }
    else
    {
        $response = [
            'status' => 500,
            'message' => 'Product Not Deleted'
        ];
        echo json_encode($response);
        return;
    }
}

if(isset($_POST['searchInput'])) {

   $searchInput = $_POST['searchInput'];

   $query = "SELECT * FROM products WHERE  product_id='$searchInput' OR product LIKE '%{$searchInput}%' OR  category LIKE '%{$searchInput}%' OR  unit LIKE '%{$searchInput}%' OR  price LIKE '%{$searchInput}%' OR  quantity LIKE '%{$searchInput}%'  OR  supplier LIKE '%{$searchInput}%' OR  stock_status LIKE '%{$searchInput}%'";
   $result = mysqli_query($conn, $query);
        if($result) {
            if(mysqli_num_rows($result) > 0) {   
            
            ?>
            <table class="table search-table table-warning text-center">
            <thead class="">
                <tr>
                    <th>Code</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Unit</th></th>
                    <th>Price</th> 
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Supplier</th>
                    <th>Action</th>
                </tr> 
            </thead>    
            <tbody>
            
            <?php
                while($fetch = mysqli_fetch_assoc($result)) {
                    $productId = $fetch['product_id'];
                    $productName = $fetch['product'];
                    $category = $fetch['category'];
                    $unit = $fetch['unit'];
                    $price = $fetch['price'];
                    $quantity = $fetch['quantity'];
                    $supplier = $fetch['supplier'];
                
            ?>
                <tr>
                    <td><?php echo $productId ?></td>
                    <td><?php echo $productName ?></td>
                    <td><?php echo $category?></td>
                    <td><?php echo $unit ?></td>
                    <td><?php echo $price ?></td>
                    <td><?php echo $quantity ?></td>
                    <?php $status = check_stock_status($quantity);?>
                    <td><?php echo $status?></td>
                    <td><?php echo $supplier?></td>

                    
                    <td class='action'>
                        <button type='button' value='<?php echo $productId?>' class='editProductBtn action-btn opacity-btn'  data-bs-toggle='modal' data-bs-target='#editProductModal' tabindex='-1' >
                        <i class='fa-regular fa-pen-to-square p-2 bgYellow text-white'></i>
                        </button>
                        <button type='button' value='<?php echo $productId?>' class='deleteProductBtn delete-btn action-btn opacity-btn'>
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


