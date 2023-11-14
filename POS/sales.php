<?php 

session_start();
    $pageName = "Point of Sale";
    include '../config/database.php';
    include 'functions_cashier.php';
    $user_data = check_login($conn);

    $discount = [5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80];

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
      <nav class="navbar navbar-light bg-success py-2 px-4">
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
      <div class= "container-fluid p-4 d-flex-column" id="main-content">
        <div class="d-flex flex-column">
            <div class="d-flex justify-content-between align-items-center pb-2 border-bottom border-dark ">
                <h4 class="">Product</h4>
                <a href="#" class="btn btn-sm text-white bg-dark">See order list >></a>
            </div>
            <table >
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Discount</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="container product-row m-1">
                        <tr>
                            <td class=""><input type="search" placeholder="Product Name"></td>
                            <td><input type="number"></td>
                            <td>&#x20B1;<input type="number"></td>
                            <td>
                                <select> 
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
                            </td>
                            <td><input type="number"></td>
                        </tr>
                        <td><input type="text" placeholder="product category" class="w-100"></td>
                    </tr>
                    <tr class="container bg-warning mb-2">
                        <tr>
                            <td><input type="search" placeholder="Product Name"></td>
                            <td><input type="number"></td>
                            <td>&#x20B1;<input type="number"></td>
                            <td>
                                <select> 
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
                            </td>
                            <td><input type="number"></td>
                        </tr>
                        <td><input type="text" placeholder="product category" class="w-100"></td>
                    </tr>
                </tbody>
            </table>
        </div>

      </div>

</div> 
<script>
            $('#add').click(function() {
            $('tbody').append(`
            <tr>
                <tr>
                    <td><input type="search" placeholder="Product Name"></td>
                    <td><input type="number"></td>
                    <td>&#x20B1;<input type="number"></td>
                    <td>
                        <select> 
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
                    </td>
                    <td><input type="number"></td>
                </tr>
            </tr>
            `);
        });

        function getSubTotal() {
            
        }
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>