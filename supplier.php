<?php 
   $pageName = "Supplier";
   include './inc/opening.php';

   //Creating a table for suppliers
   $query = "CREATE TABLE IF NOT EXISTS `suppliers` (
      `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
      `business_name` varchar(100) NOT NULL,
      `contact_number` varchar(100) NOT NULL,
      `email` varchar(100) NOT NULL,
      `total_order` int(11) NOT NULL,
      `data_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
       PRIMARY KEY (supplier_id) 
     ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";


     mysqli_query($conn, $query);
?>

<!-------------------------------------- Main Page Content-------------------------------- -->
      <div class= "container-fluid p-4 d-flex-column" id="main-content">
               <div class="d-flex justify-content-between">
                     <input class="search px-3 rounded-4 border-1" type="text" placeholder="Search">
                     <button type="button" class="btn btn-danger add-btn px-4 fw-3" data-bs-toggle="modal" data-bs-target="#addSupplierModal" tabindex="-1" >
                        Add Supplier
                     </button>
                     <!-- Modal For Adding Supplier-->
                     <div class="modal fade modal-lg" id="addSupplierModal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
                        <div class="modal-dialog d-flex justify-content-center p-4 ">
                           <div class="modal-content" id="modal-form">
                              <div class="modal-header">
                                 <h4 class="modal-title textMaroon fw-bold text-center" id="modal-title">Add Supplier</h4>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="'close"></button>
                              </div>
                              <div class="modal-body w-100">
                                 <div class="alert alert-warning d-none" id="errorMessage"></div>
                              <form id="add-supplier">
                                    <div class="row m-auto">
                                          <div class="col">
                                             <div class="form-group row mb-1">
                                                <label for="business-name" class="col-sm-3 col-form-label label">Business Name: </label>
                                                <input class="col-sm-5" type="text" name="business-name" >
                                             </div>
                                             <div class="form-group row mb-1">
                                                <label for="contact" class="col-sm-3 col-form-label label">Contact Number: </label>
                                                <input class="col-sm-5" type="text" name="contact">
                                             </div> 
                                             <div class="form-group row mb-1">
                                                <label for="email" class="col-sm-3 col-form-label label">Email: </label>
                                                <input class="col-sm-5" type="email" name="email">
                                             </div> 
                                             <div class="form-group row mb-1">
                                                   <label for="email" class="col-sm-3 col-form-label label">Total Order:</label>
                                                   <input class="col-sm-5" type="text" name="total-order">
                                             </div>  
                                          </div>               
                                    </div>
                                    <div class="row form-down text-center mt-3">
                                          <button type="submit" class="add-btn rounded-2 py-3 px-4 w-25 mx-auto action-btn">ADD SUPPLIER</button>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
               </div>
               <!----------SUPPLIER TABLE LIST----------->
               <div class="table-responsive-md pt-3" >
                     <table class="table table-warning text-center" id="table">
                        <thead class="">
                           <tr>
                              <th>Supplier Id</th>
                              <th>Business Name</th>
                              <th>Contact Number</th>
                              <th>Email</th>
                              <th>Total Orders</th>
                              <th>Action</th>
                           </tr> 
                        </thead>
                        <tbody>
                           <?php 
                              //Getting the data from the database
                              $query = "SELECT * FROM suppliers";
                              $result = mysqli_query($conn, $query);
                              while ($fetch = mysqli_fetch_array($result)) {
                                 //Displaying the data in table form
                                    echo "<tr>";
                                    echo "<td> {$fetch['supplier_id']}</td>";
                                    echo "<td> {$fetch['business_name']}</td>";
                                    echo "<td> {$fetch['contact_number']}</td>";
                                    echo "<td> {$fetch['email']}</td>";
                                    echo "<td> {$fetch['total_order']}</td>";
                                    echo "<td class='action'>
                                             <button type='button' value='{$fetch['supplier_id']}' class='editSupplierBtn action-btn opacity-btn'  data-bs-toggle='modal' data-bs-target='#editSupplierModal' tabindex='-1' >
                                                <i class='fa-regular fa-pen-to-square p-2 bgYellow text-white'></i>
                                             </button>
                                             <button type='button' value='{$fetch['supplier_id']}' class='deleteSupplierBtn delete-btn action-btn opacity-btn'>
                                                <i class='fa-solid fa-trash p-2  bgMaroon text-white'></i>
                                             </button>
                                          </td>";
                                    echo "</tr>";
                              }
                              ?>
                        </tbody>
                     </table>
               </div>

               <!-- Modal For Updating the Supplier -->
               <div class="modal fade modal-lg" id="editSupplierModal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
                        <div class="modal-dialog d-flex justify-content-center p-4 ">
                           <div class="modal-content" id="modal-form">
                              <div class="modal-header">
                                 <h4 class="modal-title textMaroon fw-bold text-center" id="modal-title">Update Supplier</h4>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="'close"></button>
                              </div>
                              <div class="modal-body w-100">
                                 <div class="alert alert-warning d-none" id="errorMessage-update"></div>
                              <form id="update-supplier">
                                    <div class="row m-auto">
                                             <input type="hidden" name="supplier_id" id="supplier_id">
                                             <div class="col">
                                                <div class="form-group row mb-1">
                                                   <label for="business-name" class="col-sm-3 col-form-label label">Business Name: </label>
                                                   <input class="col-sm-5" type="text" name="business-name" id="business-name">
                                                </div>
                                                <div class="form-group row mb-1">
                                                   <label for="contact" class="col-sm-3 col-form-label label">Contact Number: </label>
                                                   <input class="col-sm-5" type="text" name="contact" id="contact">
                                                </div> 
                                                <div class="form-group row mb-1">
                                                   <label for="email" class="col-sm-3 col-form-label label">Email: </label>
                                                   <input class="col-sm-5" type="email" name="email" id="email">
                                                </div>
                                                <div class="form-group row mb-1">
                                                   <label for="email" class="col-sm-3 col-form-label label">Total Order: </label>
                                                   <input class="col-sm-5" type="text" name="total-order" id="total-order">
                                                </div>  
                                             </div>              
                                    </div>
                                    <div class="row form-down text-center mt-3">
                                          <button type="submit" class="add-btn rounded-2 py-3 px-4 w-25 mx-auto action-btn">UPDATE SUPPLIER</button>
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
   //Adding supplier
$(document).on('submit', '#add-supplier', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append('add_supplier', true);

    $.ajax({
        type: 'POST',
        url: 'supplierCode.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                // Show error message inside the modal
                $('#errorMessage').removeClass('d-none');
                $('#errorMessage').text(res.message);

            } else if (res.status == 200) {
                $('#errorMessage').addClass('d-none');
                $('#addSupplierModal').modal('hide');
                $('#add-supplier')[0].reset();

                // Reload the table
                $('#table').load(location.href + ' #table');
            }
         },

        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX request failed: " + errorThrown);
         }
       });
});

 //Getting id of supplier
 $(document).on('click', '.editSupplierBtn', function() {
    var supplier_id = $(this).val();
    $.ajax({
        type: 'GET',
        url: 'supplierCode.php',
        data: { editSupplier: true, supplier_id: supplier_id }, // Send 'editProduct' parameter
        success: function(response) {
            console.log("Response:", response); 
            var res = jQuery.parseJSON(response);
            if (res.status == 404) {
                alert(res.message);
            } else if (res.status == 200) {
                // Data added successfully, close the modal and reset the form
                
                $('#supplier_id').val(res.data.supplier_id);
                $('#business-name').val(res.data.business_name);
                $('#contact').val(res.data.contact_number);
                $('#email').val(res.data.email);
                $('#total-order').val(res.data.total_order);
                $('#editSupplierModal').modal('show');
            }
         }
    });
});

 //Updating the supplier
 $(document).on('submit', '#update-supplier', function(e) {
    e.preventDefault();

    var formData = new FormData(this);
    formData.append('update_supplier', true);

    $.ajax({
        type: 'POST',
        url: 'supplierCode.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log("Response:", response); 
            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                // Show error message inside the modal
                $('#errorMessage-update').removeClass('d-none');
                $('#errorMessage-update').text(res.message);
            } else if (res.status == 200) {
                alert(res.message);
                $('#errorMessage-update').addClass('d-none');
                $('#editSupplierModal').modal('hide');
                $('#update-supplier')[0].reset();

                // Reload the table
                $('#table').load(location.href + ' #table');
            }else if(res.status == 500) {
               alert(res.message);
            }
        }
    });
});

//Deleting supplier
$(document).on('click', '.deleteSupplierBtn', function (e) {
   e.preventDefault();

   if(confirm('Are you sure you want to delete this supplier?')){
      var supplier_id = $(this).val();
      $.ajax({
         type: "POST",
         url: "supplierCode.php",
         data: {
            'delete_supplier': true,
            'supplier_id': supplier_id
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
</script>
<?php include './inc/closing.php';?>