<?php 
   $pageName = "Purchases";
   include './inc/opening.php';

   //Creating table if not created
   $query = "CREATE TABLE IF NOT EXISTS `purchases` (
      `purchase_id` int(11) NOT NULL AUTO_INCREMENT,
      `order_number` int(11) NOT NULL,
      `product` varchar(100) NOT NULL,
      `category` varchar(100) NOT NULL,
      `quantity` varchar(100) NOT NULL,
      /*`total_stock` int(11) NOT NULL,*/
      `date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      PRIMARY KEY (purchase_id) 
    )";

   mysqli_query($conn, $query);
?>

<!-------------------------------------- Main Page Content-------------------------------- -->
      <div class= "container-fluid p-4 d-flex-column" id="main-content">
               <div class="d-flex justify-content-between">
                  <input class="p-2 w-25" type="search" placeholder="Search" id="search-input" name="search-input" autocomplete="off">
                     <div class="ms-0">
                        <select class="category form-select">
                           <option selected>Select Category</option>
                           <?php 
                              //Getting data from database
                              $query = "SELECT category FROM purchases";
                              $result = mysqli_query($conn, $query);
                              while ($fetch = mysqli_fetch_array($result)) {
                                    echo "<option>" . $fetch['category'] . "</option>";   
                              }
                              ?>
                        </select>
                     </div>
                     <button type="button" class="btn btn-danger add-btn px-4 fw-3" data-bs-toggle="modal" data-bs-target="#addPurchModal" tabindex="-1" >
                     New Purchase Order
                     </button>
                     <!-- Modal For New Purchase Order-->
                     <div class="modal fade modal-lg" id="addPurchModal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
                        <div class="modal-dialog d-flex justify-content-center p-4 ">
                           <div class="modal-content" id="modal-form">
                              <div class="modal-header">
                                 <h4 class="modal-title fw-bold text-center" id="modal-title">Item</h4>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="'close"></button>
                              </div>
                              <div class="modal-body w-100">
                                 <div class="alert alert-warning d-none" id="errorMessage"></div>
                              <form id="new-purchase">
                                    <div class="row m-auto">
                                          <div class="col">
                                             <div class="form-group row mb-1">
                                                <label for="order_number" class="col-sm-3 col-form-label label">Order Number: </label>
                                                <input class="col-sm-5" type="text" name="order-number" >
                                             </div>
                                             <div class="form-group row mb-1">
                                                <label for="product_name" class="col-sm-3 col-form-label label">Product Name: </label>
                                                <input class="col-sm-5" type="text" name="product-name">
                                             </div> 
                                             <div class="form-group row mb-1">
                                                <label for="category" class="col-sm-3 col-form-label label">Category: </label>
                                                <input class="col-sm-5" type="text" name="category">
                                             </div>
                                             <div class="form-group row mb-1">
                                                <label for="quantity" class="col-sm-3 col-form-label label">Quantity: </label>
                                                <input class="col-sm-5" type="number" name="quantity">
                                             </div>
                                          </div>               
                                    </div>
                                    <div class="row form-down mt-3">
                                          <button type="submit" class="add-order rounded-2 py-2 px-3 w-25 ms-5 me-3 mt-4 mb-4 action-btn btn btn-success" name="add-order" id="submit">Add Order</button>
                                          <button type="button" class="see-order rounded-2 py-2 px-3 w-25 ms-3 me-3 mt-4 mb-4 action-btn btn btn-dark " data-bs-dismiss="modal" aria-label="'close" name="see-order" id="see-order">See Order Details</button>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
               </div>
               <!----------PRODUCT TABLE LIST----------->

               <div class="table-responsive-md pt-3" id="table">
                     <table class="table table-warning text-center default-table">
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
                        <tbody id="purchase-details">
                           <?php 
                              //Getting the data from database
                              $query = "SELECT * from purchases";
                              $result = mysqli_query($conn, $query);
                              while ($fetch = mysqli_fetch_array($result)) {
                           
                           ?>

                           <tr >
                              <td><?php echo $fetch['purchase_id']?></td>
                              <td><?php echo $fetch['order_number']?></td>
                              <td><?php echo $fetch['product']?></td>
                              <td><?php echo $fetch['category']?></td>
                              <td><?php echo $fetch['quantity']?></td>
                              <td><?php echo $fetch['date_added']?></td>

                              <td class='action'>
                                 <button type='button' value='<?php echo $fetch['purchase_id']?>' class='editPurchBtn action-btn opacity-btn'  data-bs-toggle='modal' data-bs-target='#editPurchModal' tabindex='-1' >
                                    <i class='fa-regular fa-pen-to-square p-2 bgYellow text-white'></i>
                                 </button>
                                 <button type='button' value='<?php echo $fetch['purchase_id']?>' class='deletePurchBtn delete-btn action-btn opacity-btn'>
                                    <i class='fa-solid fa-trash p-2  bgMaroon text-white'></i>
                                 </button>
                              </td>
                           </tr>

                           <?php } ?>

                        </tbody>
                     </table>
               </div>

               <!-- Modal For Updating the Purchase -->
               <div class="modal fade modal-lg" id="editPurchModal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
                        <div class="modal-dialog d-flex justify-content-center p-4 ">
                           <div class="modal-content" id="modal-form">
                              <div class="modal-header">
                                 <h4 class="modal-title textMaroon fw-bold text-center" id="modal-title">Update Purchase</h4>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="'close"></button>
                              </div>
                              <div class="modal-body w-100">
                                 <div class="alert alert-warning d-none" id="errorMessage_update"></div>
                                 <form id="update-purchase">
                                    <input type="hidden" name="purchase_id" id="purchase_id">
                                    <div class="row m-auto">
                                          <div class="col">
                                             <div class="form-group row mb-1">
                                                <label for="order-number" class="col-sm-3 col-form-label label">Order Number: </label>
                                                <input class="col-sm-5" type="text" name="order-number" id="order-number">
                                             </div>
                                             <div class="form-group row mb-1">
                                                <label for="product-name" class="col-sm-3 col-form-label label">Product Name: </label>
                                                <input class="col-sm-5" type="text" name="product-name" id="product-name">
                                             </div> 
                                             <div class="form-group row mb-1">
                                                <label for="category" class="col-sm-3 col-form-label label">Category: </label>
                                                <input class="col-sm-5" type="text" name="category" id="category">
                                             </div>
                                             <div class="form-group row mb-1">
                                                <label for="quantity" class="col-sm-3 col-form-label label">Quantity: </label>
                                                <input class="col-sm-5" type="number" name="quantity" id="quantity">
                                             </div>
                                          </div>               
                                    </div>
                                    <div class="row form-down mt-3">
                                         <!-- <button type="submit" class="update-order rounded-2 py-2 px-3 w-25 ms-5 mt-4 mb-4 action-btn btn btn-success" name="update-order" id="submit">UPDATE</button> -->
                                          <button type="submit" class="update-order rounded-2 py-2 px-2 w-25 mx-auto mb-3 mt-2 action-btn btn btn-success" name="update-order" id="submit">UPDATE</button>
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>

   //Purchasing New Order
$(document).on('click', '#new-purchase', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append('new_purchase', true);

    $.ajax({
        type: 'POST',
        url: 'purchasesCode.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log(response);
            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                // Show error message inside the modal
                $('#errorMessage').removeClass('d-none');
                $('#errorMessage').text(res.message);
            } else if (res.status == 200) {
                $('#errorMessage').addClass('d-none');
                $('#addPurchModal').modal('hide');
                $('#new-purchase')[0].reset();

                // Reload the table
                $('#table').load(location.href + ' #table');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
        console.log("AJAX request failed: " + errorThrown);
    }
    });
});

 //Getting id of the purchase
 $(document).on('click', '.editPurchBtn', function() {
    var purchase_id = $(this).val();

    $.ajax({
        type: 'GET',
        url: 'purchasesCode.php',
        data: { editPurchase: true, purchase_id: purchase_id }, // Send 'editPurchase' parameter
        success: function(response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 404) {
                alert(res.message);
            } else if (res.status == 200) {
                // Data added successfully, close the modal and reset the form
                
                $('#purchase_id').val(res.data.purchase_id);
                $('#order-number').val(res.data.order_number);
                $('#product-name').val(res.data.product);
                $('#category').val(res.data.category);
                $('#quantity').val(res.data.quantity);
                $('#editPurchModal').modal('show');
            }
        }
    });
});

 //Updating the purchase
 $(document).on('submit', '#update-purchase', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append('update_purchase', true);

    $.ajax({
        type: 'POST',
        url: 'purchasesCode.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log(response);
            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                // Show error message inside the modal
                $('#errorMessage_update').removeClass('d-none');
                $('#errorMessage_update').text(res.message);
            } else if (res.status == 200) {
                alert(res.message);
                $('#errorMessage_update').addClass('d-none');
                $('#editPurchModal').modal('hide');
                $('#update-purchase')[0].reset();

                // Reload the table
                $('#table').load(location.href + ' #table');
            }else if(res.status == 500) {
               alert(res.message);
            }
        }
    });
});

//Deleting purchase order
$(document).on('click', '.deletePurchBtn', function (e) {
            e.preventDefault();

            if(confirm('Are you sure you want to delete this purchase order?'))
            {
                var purchase_id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "purchasesCode.php",
                    data: {
                        'delete_purchase': true,
                        'purchase_id': purchase_id
                    },
                    success: function (response) {
                        var res = jQuery.parseJSON(response);
                        if(res.status == 500) {

                            alert(res.message);
                        }else{
                            alert(res.message);
                            $('#table').load(location.href + " #table");
                        }
                    }
                });
            }
        });

// Search 
$(document).ready(function() {
   $('#search-input').keyup(function() {
      var searchInput = $(this).val();
      //alert(searchInput);

      if(searchInput != "") {
         $('.default-table').hide();
         $.ajax({
            url:'purchasesCode.php',
            method:'POST',
            data: {
               'searchInput':searchInput
            },

            success: function(response) {
               $('.search-table').remove();
               $('#table').append(response);
            }
         })
      }else {
        $('.default-table').show();
        $('.search-table').remove();
      }
   });

});

</script>
<?php include './inc/closing.php';?>