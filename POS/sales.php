<?php 

session_start();
    $pageName = "Point of Sale";
    include '../config/database.php';
    include 'functions_cashier.php';
    $user_data = check_login($conn);

    $discount = [5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80];
    $count

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point of Sale</title>
    <link rel="stylesheet" href="pos.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
</head>
<body>
<div id="page-content-wrapper">
      <nav class="navbar navbar-light bg-success py-4 px-4">
          <div class="d-flex align-items-center">
              <div>
                <h3 class="m-0 text-white fw-bold"><?php echo $pageName;?></h3>
                <h6 class="fs-6 fw-light" id="date"></h6>
              </div>
          </div>
          <div class="position-absolute end-0 me-5 zindex-dropdown-1">
              <ul class="navbar-nav ms-auto mb-2 mb-lg-0 rounded-2 bg-white px-3">
                  <li class="nav-item dropdown position-relative end-0">
                      <a class="nav-link dropdown-toggle second-text fw-bold text-success" href="#" id="navbarDropdown"
                          role="button" data-bs-toggle="dropdown">
                          <i class="fas fa-user me-2"></i><?php  echo $user_data['first_name']?>
                      </a>
                      <ul class="dropdown-menu position-absolute end-50">
                          <li><a class="dropdown-item" href="#">Profile</a></li>
                          <li><a class="dropdown-item" href="#">Settings</a></li>
                          <li><a class="dropdown-item" href="/logout.php">Logout</a></li>
                      </ul>
                  </li>
              </ul>
          </div>
      </nav>
      <div class= "container-fluid p-4 d-flex-column row" id="main-content">
        <div class="col bg-dark text-white py-4 px-5 rounded">
            <div class="row sales-search">
                <form id="product-choice-sales">
                    <input class="p-2 form-control border-outline-dark" type="search" placeholder="Search" id="search-input" name="search-input" autocomplete="off">
                    <div class="row table-container my-2">
                    </div>
                    <input type="hidden" placeholder="" id="productChoiceId" name="productIdChoice" autocomplete="off">
                    <div class="form-group mb-1 row">
                        <label for="sales-product" class="form-label col">Product:</label>
                        <input class="p-2 form-control border-outline-dark col" type="text" placeholder="" id="productChoice" name="productChoice" autocomplete="off">
                    </div>
                    <div class="form-group mb-1 row">
                        <label for="sales-quantity" class="form-label col">Quantity:</label>
                        <input type="number" class="form-control col" id="productChoiceQuantity">
                    </div>
                    <div class="form-group mb-1 row">
                        <label for="sales-quantity" class="form-label col">Price:</label>
                        <input type="number" class="form-control col" id="productChoicePrice">
                    </div>
                    <div class="form-group mb-1 row">
                        <label for="discount" class="form-label col">Discount:</label>
                        <select class="form-control col" name="productChoiceDiscount"> 
                                <option selected>0 %</option>
                                <?php 
                                    for ($i=0; $i < sizeof($discount); $i++) {
                                ?>
                                    <option class="text-dark"><?php echo $discount[$i];?>%</option>
                                <?php 
                                    $count++;
                                    }
                                ?>
                        </select>
                    </div>
                    <div class="row">
                        <button type="submit" class="add-item btn btn-success mx-auto mt-3 w-50">add item</button>
                    </div>
                    
                </form> 
            </div>
            <div class="row payment-total">

            </div>

        </div>
        <div class="col col-md-7">
            <div class="row">
                <h4>Product</h4>
                <hr>
            </div>
            <div id="sales-table">
                <table class="table table-borderless table-warning table-hover w-100 text-center">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Item No.</th>
                            <th scope="col">Item</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Subtotal</th>
                        </tr>
                    </thead>
                        <tbody>
                            <tr>

                            </tr>

                        </tbody>
                </table>
            </div>

        </div>
      </div>

</div> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
// Search 
$(document).ready(function() {
   $('#search-input').keyup(function() {
      var searchInput = $(this).val();
      //alert(searchInput);

      if(searchInput != "") {
         $.ajax({
            url:'salesCode.php',
            method:'POST',
            data: {
               'searchInput':searchInput
            },

            success: function(response) {
               $('.search-table').remove();
               $('.table-container').append(response);


                // Attach click event to each .item-choice
                $('.item-choice').click(function() {
                    var productId = $(this).find('#product-choice-id').val();
                    var productName = $(this).find('#product-choice-name').val();
                    var productPrice = $(this).find('#product-choice-price').val();
                    $('#productChoiceId').val(productName);
                    $('#productChoice').val(productName);
                    $('#productChoicePrice').val(productPrice);
                    /* alert(`${productId} ${productName} ${productPrice}`) */
                });
            }
         })
      }else {
        $('.search-table').remove();
      }
   });

});

//Computing the subtotal and adding it to the table
$(document).on('submit', '#product-choice-sales', function(e){
    e.preventDefault();

    var formData = new FormData(this);
    formData.append('add_item', true);
    
    $.ajax({
        type: 'POST',
        url: 'salesCode.php',
        data: formData,
        processData: false,
        contentType: false,

        success: function(reponse) {
            var res = jQuery.parseJSON(response);
            console.log(response);

            if(res.status == 422) {
                //
            }
            
        }
    });
})

</script>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>