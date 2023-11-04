<?php 
include '../config/database.php';
include 'functions_cashier.php';
$user_data = check_login($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point of Sale</title>
</head>
<body>
<div id="page-content-wrapper">
      <nav class="navbar navbar-light bg-transparent py-2 px-4">
          <div class="d-flex align-items-center">
              <i class="fa-solid fa-bars primary-text fs-3 me-5 text-warning" id="menu-toggle"></i>
              <div>
                <h3 class="m-0 text-success fw-bold"><?php echo $pageName;?></h3>
                <h6 class="fs-6 fw-light" id="date"></h6>
              </div>
          </div>
          <div class="position-absolute end-0 me-5 zindex-dropdown-1">
              <ul class="navbar-nav ms-auto mb-2 mb-lg-0 rounded-2 bg-success px-3">
                  <li class="nav-item dropdown position-relative end-0">
                      <a class="nav-link dropdown-toggle second-text fw-bold text-white" href="#" id="navbarDropdown"
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
</div> 
</body>
</html>