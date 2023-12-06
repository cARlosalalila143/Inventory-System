<?php
    include '../config/database.php';
    include 'functions_cashier.php';
if(isset($_POST['searchInput'])) {

    $searchInput = $_POST['searchInput'];
    $query = "SELECT * FROM products WHERE product_id='$searchInput' OR product LIKE '%{$searchInput}%' OR  category LIKE '%{$searchInput}%' OR  price LIKE '%{$searchInput}%' OR  quantity LIKE '%{$searchInput}%'";
    $result = mysqli_query($conn, $query);
         if($result) {
             if(mysqli_num_rows($result) > 0) {   
             ?>
             <table class="table search-table table-warning text-center table-hover">
             <thead class="table-dark">
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </thead>
             <tbody>
             
             <?php
                 while($fetch = mysqli_fetch_assoc($result)) {

                    $productId = $fetch['product_id'];
                    $productName = $fetch['product'];
                    $price = $fetch['price'];
                    $quantity = $fetch['quantity'];

                 
             ?>
                <tr class="item-choice">
                    <td><input type="hidden" value="<?php echo $productId ?>" id="product-choice-id"><?php echo $productId ?></td>
                    <td><input type="hidden" value="<?php echo $productName ?>" id="product-choice-name"><?php echo $productName ?></td>
                    <td><input type="hidden" value="<?php echo $price ?>" id="product-choice-price"><?php echo $price ?></td>
                    <td><?php echo $quantity ?></td>
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

?>