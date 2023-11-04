<?php 
   $pageName = "Purchase Orders";
   include './inc/opening.php';

   //Creating table if not created

   mysqli_query($conn, $query);
?>

<!-------------------------------------- Main Page Content-------------------------------- -->
      <div class= "container-fluid p-4 d-flex-column" id="main-content">
               <div class="d-flex justify-content-between">
                     <input class="search px-3 rounded-4 border-1" type="text" placeholder="Search">
                     <button type="button" class="btn btn-danger add-btn px-4 fw-3" data-bs-toggle="modal" data-bs-target="#addProductModal" tabindex="-1" >
                        Add Product
                     </button>
                     <!-- Modal For Adding Product-->
                     <div class="modal fade modal-lg" id="addProductModal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
                        <div class="modal-dialog d-flex justify-content-center p-4 ">
                           <div class="modal-content" id="modal-form">
                              <div class="modal-header">
                                 <h4 class="modal-title textMaroon fw-bold text-center" id="modal-title">Add Orders</h4>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="'close"></button>
                              </div>
                              <div class="modal-body w-100">
                                 <div class="alert alert-warning d-none" id="errorMessage"></div>
                              <form id="add-product">
                                    <div class="row m-auto">
                                          <div class="col">
                                             <div class="form-group row mb-1">
                                                <label for="product_name" class="col-sm-3 col-form-label label">Product Name: </label>
                                                <input class="col-sm-5" type="text" name="product-name" >
                                             </div>
                                             <div class="form-group row mb-1">
                                                <label for="supplier" class="col-sm-3 col-form-label label">Supplier: </label>
                                                <input class="col-sm-5" type="text" name="supplier">
                                             </div> 
                                             <div class="form-group row mb-1">
                                                <label for="category" class="col-sm-3 col-form-label label">Category: </label>
                                                <input class="col-sm-5" type="text" name="category">
                                             </div> 
                                             <div class="form-group row mb-1">
                                                <label for="price" class="col-sm-3 col-form-label label">Price: </label>
                                                <input class="col-sm-5" type="number" name="price">
                                             </div>
                                             <div class="form-group row mb-1">
                                                <label for="unit" class="col-sm-3 col-form-label label">Unit: </label>
                                                <input class="col-sm-5" type="text" name="unit">
                                             </div>
                                             <div class="form-group row mb-1">
                                                <label for="quantity" class="col-sm-3 col-form-label label">Quantity: </label>
                                                <input class="col-sm-5" type="number" name="quantity">
                                             </div>
                                          </div>               
                                    </div>
                                    <div class="row form-down text-center mt-3">
                                          <button type="submit" class="add-btn rounded-2 py-3 px-4 w-25 mx-auto action-btn" name="add-inventory" id="submit">ADD</button>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
               </div>
               <!----------PRODUCT TABLE LIST----------->
               <div class="table-responsive-md pt-3" id="table">
                     <table class="table table-warning text-center">
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
                              //Getting the data from database
                              $query = "SELECT * from products";
                              $result = mysqli_query($conn, $query);
                              while ($fetch = mysqli_fetch_array($result)) {

                                    echo "<tr>";
                                    echo "<td> {$fetch['product_id']}</td>";
                                    echo "<td> {$fetch['product']}</td>";
                                    echo "<td> {$fetch['category']}</td>";
                                    echo "<td> {$fetch['unit']}</td>";
                                    echo "<td> {$fetch['price']}</td>";
                                    echo "<td> {$fetch['quantity']}</td>";
                                    $status = check_stock_status($fetch['quantity']);
                                    echo "<td> {$status}</td>";
                                    echo "<td> {$fetch['supplier']}</td>";
                                    echo "<td class='action'>
                                             <button type='button' value='{$fetch['product_id']}' class='editProductBtn action-btn opacity-btn'  data-bs-toggle='modal' data-bs-target='#editProductModal' tabindex='-1' >
                                                <i class='fa-regular fa-pen-to-square p-2 bgYellow text-white'></i>
                                             </button>
                                             <button type='button' value='{$fetch['product_id']}' class='deleteProductBtn delete-btn action-btn opacity-btn'>
                                                <i class='fa-solid fa-trash p-2  bgMaroon text-white'></i>
                                             </button>
                                          </td>";
                                    echo "</tr>";
                              }
                              ?>
                        </tbody>
                     </table>
               </div>

               <!-- Modal For Updating the Product -->
               <div class="modal fade modal-lg" id="editProductModal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
                        <div class="modal-dialog d-flex justify-content-center p-4 ">
                           <div class="modal-content" id="modal-form">
                              <div class="modal-header">
                                 <h4 class="modal-title textMaroon fw-bold text-center" id="modal-title">Update Product</h4>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="'close"></button>
                              </div>
                              <div class="modal-body w-100">
                                 <div class="alert alert-warning d-none" id="errorMessage_update"></div>
                              <form id="update-product">
                                    <div class="row m-auto">
                                          <input type="hidden" name="product_id" id="product_id">
                                          <div class="col">
                                             <div class="form-group row mb-1">
                                                <label for="product_name" class="col-sm-3 col-form-label label">Product Name: </label>
                                                <input class="col-sm-5" type="text" name="product-name" id="product-name">
                                             </div>
                                             <div class="form-group row mb-1">
                                                <label for="supplier" class="col-sm-3 col-form-label label">Supplier: </label>
                                                <input class="col-sm-5" type="text" name="supplier" id="supplier">
                                             </div> 
                                             <div class="form-group row mb-1">
                                                <label for="category" class="col-sm-3 col-form-label label">Category: </label>
                                                <input class="col-sm-5" type="text" name="category" id="category">
                                             </div> 
                                             <div class="form-group row mb-1">
                                                <label for="price" class="col-sm-3 col-form-label label">Price: </label>
                                                <input class="col-sm-5" type="number" name="price" id="price">
                                             </div>
                                             <div class="form-group row mb-1">
                                                <label for="unit" class="col-sm-3 col-form-label label">Unit: </label>
                                                <input class="col-sm-5" type="text" name="unit" id="unit">
                                             </div>
                                             <div class="form-group row mb-1">
                                                <label for="quantity" class="col-sm-3 col-form-label label">Quantity: </label>
                                                <input class="col-sm-5" type="number" name="quantity" id="quantity">
                                             </div>
                                          </div>               
                                    </div>
                                    <div class="row form-down text-center mt-3">
                                          <button type="submit" class="add-btn rounded-2 py-3 px-4 w-25 mx-auto action-btn" name="update-inventory" id="submit">UPDATE</button>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
               </div>
      </div>
   </div>
</div>   
<?php include './inc/closing.php';?>