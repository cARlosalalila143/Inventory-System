<?php
session_start(); 
    include("./config/database.php");
    include("./config/functions.php");
    $user_data = check_login($conn);

    if (!($user_data['admin_id'])) {
      header('Location: admin.php');
      die;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="css/header_sidebar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">

</head>
<body>
  <div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="sidebar-menu bg-success" id="sidebar">
      <div class="sidebar-heading ms-3 text-white py-5 fs-5 fw-bold text-uppercase bg-success"><span class="py-5 text-white" id="menu-close"><i class="fa-solid fa-circle-xmark fa-2xl"></i></span></div>
      <div class="list-group list-group-flush my-3 bg-success" id="list-link">
        <a href="dashboard.php" class="list-group-item bg-success text-white ms-3 mb-4  border border-end-0 rounded-2 rounded-end-0"><i class="me-3 fa-solid fa-gauge"></i>Dashboard</a>
        <a href="product.php" class="list-group-item bg-success text-white ms-3 mb-2  border border-end-0 rounded-2 rounded-end-0"><i class="me-3 fa-solid fa-gift"></i>Products</a>
        <a href="supplier.php" class="list-group-item bg-success text-white ms-3 mb-2  border border-end-0 rounded-2 rounded-end-0"><i class="me-3 fa-solid fa-truck-field"></i>Supplier</a>
        <a href="purchases.php" class="list-group-item bg-success text-white ms-3 mb-2  border border-end-0 rounded-2 rounded-end-0"><i class="me-3 fa-solid fa-cart-shopping"></i>Purchases</a>
        <a href="sales.html" class="list-group-item bg-success text-white ms-3 mb-2  border border-end-0 rounded-2 rounded-end-0"><i class="me-3 bi bi-card-checklist"></i>Sales</a>
        <a href="reports.html" class="list-group-item bg-success text-white ms-3 mb-2  border border-end-0 rounded-2 rounded-end-0"><i class="me-3 fa-solid fa-arrow-trend-up"></i>Reports</a>
        <a href="users.php" class="list-group-item bg-success text-white ms-3 mb-2  border border-end-0 rounded-2 rounded-end-0"><i class="me-3 fa-regular fa-user"></i>Users</a>
      </div>
      <a href="/logout.php" class="list-group-item bg-dark text-white p-3 rounded-0"><i class="me-3 fa-solid fa-right-from-bracket"></i>Logout</a>   
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper">
      <nav class="navbar navbar-light bg-transparent py-2 px-4">
          <div class="d-flex align-items-center">
              <i class="fa-solid fa-bars primary-text fs-3 me-5 text-warning" id="menu-toggle"></i>
              <div>
                <h3 class="m-0 text-success fw-bold"><?php echo $pageName;?></h3>
                <h6 class="fs-6 fw-light " id="date"></h6>
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
