<?php 
   $pageName = "Users";
   include './inc/opening.php';
   $messageError  = $passwordError = "";
?>

   <div class= "container-fluid p-4 d-flex-column" id="main-content">
            <div class="d-flex justify-content-between">
                  <input class="search px-3 rounded-4 border-1" type="text" placeholder="Search">
                  <button type="button" class="btn btn-danger add-btn px-4" data-bs-toggle="modal" data-bs-target="#addUserModal" tabindex="-1" >
                     Add user
                  </button>
                  <!-- Modal for Adding a User-->
                  <div class="modal fade modal-lg p-5" id="addUserModal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
                     <div class="modal-dialog d-flex justify-content-center p-4">
                        <div class="modal-content" id="modal-form">
                           <div class="modal-header text-center">
                              <h4 class="modal-title textMaroon fw-bold" id="modal-title">Add Another User</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="'close"></button>
                           </div>
                           <div class="modal-body">
                              <div class="alert alert-warning d-none" id="errorMessage"></div>
                           <form id="register-user" >
                                 <div class="row">
                                       <div class="col">
                                          <div class="form-group mb-1">
                                             <label class="w-50 label">First Name </label>
                                             <input class="w-100 px-2 py-1" type="text" name="firstname">
                                          </div>
                                          <div class="form-group mb-1">
                                             <label class="w-50 label">Last name</label>
                                             <input class="w-100 px-2 py-1" type="text" name="lastname">
                                          </div>
                                          <div class="form-group mb-1">
                                             <label class="w-50 label">Email</label>
                                             <input class="w-100 px-2 py-1" type="email" name="email">
                                          </div>
                                          <div class="form-group mb-1">
                                             <label class="w-50 label">Username </label>
                                             <input class="w-100 px-2 py-1" type="text" name="username">
                                          </div>
                                       </div>
                                       <div class="col">
                                          <div class="form-group mb-1">
                                             <label class="w-50 label">Password</label>
                                             <input class="w-100 px-2 py-1" type="password" name="password">
                                          </div>
                                          <div class="form-group mb-1">
                                             <label class="w-75 label">Confirm Password</label>
                                             <input class="w-100 px-2 py-1" type="password" name="confirmPassword"> 
                                             
                                          </div>
                                          <div class="form-group mb-1">
                                             <label class="w-50">Account Type</label>
                                             <select name="account-type" class="w-25">
                                                   <option>Admin</option>
                                                   <option>Cashier</option>
                                             </select>
                                          </div>
                                       </div>               
                                 </div>
                                 <div class="row form-down text-center">
                                       <button type="submit" class="add-btn rounded-4 py-2 w-25 mx-auto" name="register">REGISTER</button>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
            </div>
            <div id="tables">
               <div class="table-responsive-md pt-3">
                     <!-- Admin Table -->
                     <h5 class="fw-bold text-success">ADMINS</h5>
                     <table class="table table-warning text-center">
                        <thead>
                           <tr>
                                 <th>Admin Id</th>
                                 <th>Username</th>
                                 <th>Name</th>
                                 <th>Email</th>
                                 <th>Action</th>
                           </tr> 
                        </thead>
                        <tbody>
                           <?php 
                           //Getting the admin's data from databases
                           $query = "SELECT * FROM admins";
                           $result = mysqli_query($conn, $query);
                           while ($fetch = mysqli_fetch_array($result)) {
                              //Displayng admin's data
                                 echo "<tr>";
                                 echo "<td> {$fetch['admin_id']} </td>";
                                 echo "<td> {$fetch['username']} </td>";
                                 echo "<td> {$fetch['first_name']} {$fetch['last_name']} </td>";
                                 echo "<td> {$fetch['email']} </td>";
                                 echo "<td>
                                          <button type='button' value='{$fetch['admin_id']}' class='deleteAdminBtn delete-btn action-btn opacity-btn'>
                                             <i class='fa-solid fa-trash p-2  bgMaroon text-white'></i>
                                          </button>
                                       </td>";
                                 echo "</tr>";
                                 
                           }
                           ?>
                        </tbody>
                     </table>                 
               </div> 
               <div class="table-responsive-md pt-3">
                     <!-- Cashier Table -->
                     <h5 class="fw-bold text-success">CASHIERS</h5>
                     <table class="table table-warning text-center" id="table2">
                        <thead>
                           <tr>
                                 <th>Cashier Id</th>
                                 <th>Username</th>
                                 <th>Name</th>
                                 <th>Email</th>
                                 <th>Action</th>
                           </tr> 
                        </thead>
                        <tbody>
                           <?php 
                           $account_type = "";
                           //Getting the from cashier's database
                           $query = "SELECT * FROM cashiers";
                           $result = mysqli_query($conn, $query);
                           while ($fetch = mysqli_fetch_array($result)) {
                                 //Displaying cashier's data in table form
                                 echo "<tr>";
                                 echo "<td> {$fetch['cashier_id']} </td>";
                                 echo "<td> {$fetch['username']} </td>";
                                 echo "<td> {$fetch['first_name']} {$fetch['last_name']} </td>";
                                 echo "<td> {$fetch['email']} </td>";
                                 echo "<td>
                                          <button type='button' value='{$fetch['cashier_id']}' class='deleteCashierBtn delete-btn action-btn opacity-btn'>
                                             <i class='fa-solid fa-trash p-2  bgMaroon text-white'></i>
                                          </button>
                                       </td>";
                                 echo "</tr>";
                                 
                           }
                           ?>
                        </tbody>
                     </table>                 
               </div> 
            </div>  
   </div>

   </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   //Register users
   $(document).on('submit', '#register-user' , function(e) {
      e.preventDefault();

      var formData = new FormData(this);
      formData.append('register_user', true);

      $.ajax ( {
         type: 'POST',
         url: 'usersCode.php',
         data: formData,
         processData: false,
         contentType: false,
         success:function(response) {
            var res = jQuery.parseJSON(response);
            if(res.status == 422) {
               $('#errorMessage').removeClass('d-none');
               $('#errorMessage').text(res.message);
            } else if(res.status == 200) {
               $('#errorMessage').addClass('d-none');
               $('#addUserModal').modal('hide');
               $('#register-user')[0].reset();
               $('#tables').load(location.href + ' #tables');
            }
         }
      }
      )
   });

   //Deleting Admin
   $(document).on('click', '.deleteAdminBtn', function (e) {
               e.preventDefault();

               if(confirm('Are you sure you want to delete this admin?'))
               {
                  var admin_id = $(this).val();
                  $.ajax({
                     type: "POST",
                     url: "usersCode.php",
                     data: {
                           'delete_admin': true,
                           'admin_id': admin_id
                     },
                     success: function (response) {

                           var res = jQuery.parseJSON(response);
                           if(res.status == 500) {

                              alert(res.message);
                           }else
                           {
                              alert(res.message);
                              $('#tables').load(location.href + " #tables");
                           }
                     }
                  });
               }
         });

   //Deleting cashier
   $(document).on('click', '.deleteCashierBtn', function (e) {
               e.preventDefault();

               if(confirm('Are you sure you want to delete this cashier?'))
               {
                  var cashier_id = $(this).val();
                  $.ajax({
                     type: "POST",
                     url: "usersCode.php",
                     data: {
                           'delete_cashier': true,
                           'cashier_id': cashier_id
                     },
                     success: function (response) {
                           var res = jQuery.parseJSON(response);
                           if(res.status == 500) {
                              alert(res.message);
                           }else
                           {
                              alert(res.message);
                              $('#tables').load(location.href + " #tables");
                           }
                     }
                  });
               }
         });
</script>
<?php include './inc/closing.php';?>