<?php
include_once 'connection.php';
include_once 'function.php';
session_start();
if (!isset($_SESSION['username'])) {
   header("location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Vedikroots</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
      crossorigin="anonymous"></script>
   <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="css/style.css">
   <script src="js/cdn.bootcss.com_jquery_3.3.1_jquery.js"></script>
   <script src="js/unpkg.com_sweetalert@2.1.2_dist_sweetalert.min.js"></script>
   <link rel="icon" href="images/logo.webp" sizes="32x32" />
   <style>
      ol,
      ul {
         padding-left: 0rem;
      }
   </style>
   <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
   <!-- <script src="js/script.js"></script> -->
</head>

<body>

   <nav class="sidebar open">
      <header>
         <div class="image-text">
            <div class="text logo-text">
               <img src="images/logo.webp" class="logo">
            </div>
         </div>
      </header>
      <div class="menu-bar">
         <div class="menu">
            <ul class="menu-links">
               <li class="nav-link">
                  <a href="dashboard.php">
                     <i class='fa fa-life-ring icon' style=color:#715252></i>
                     <span class="text nav-text">Dashboard</span>
                  </a>
               </li>
               <?php if ($_SESSION['role'] == '1') { ?>
                  <li class="nav-link">
                     <a href="users.php">
                        <i class='fa fa-users icon' style=color:#715252></i>
                        <span class="text nav-text">Users</span>
                     </a>
                  </li>
               <?php } ?>
               <li class="nav-link">
                  <a href="vendors.php">
                     <i class='fa fa-user-circle-o icon' style=color:#715252></i>
                     <span class="text nav-text">Vendors</span>
                  </a>
               </li>
               <li class="nav-link">
                  <a href="plateform.php">
                     <i class='fa fa-globe icon' style=color:#715252></i>
                     <span class="text nav-text">Platform</span>
                  </a>
               </li>
               <li class="nav-link">
                  <a href="warehouse.php">
                     <i class='fa fa-sitemap icon' style=color:#715252></i>
                     <span class="text nav-text">Warehouse</span>
                  </a>
               </li>
               <li class="nav-link">
                  <a href="category.php">
                     <i class='fa fa-codiepie icon' style=color:#715252></i>
                     <span class="text nav-text">Category</span>
                  </a>
               </li>
               <li class="nav-link">
                  <a href="products.php">
                     <i class='fa fa-product-hunt icon' style=color:#715252></i>
                     <span class="text nav-text">Products</span>
                  </a>
               </li>
               <li class="nav-link">
                  <a href="stocks.php">
                     <i class='fa fa-shopping-cart icon' style=color:#715252></i>
                     <span class="text nav-text">Stocks</span>
                  </a>
               </li>
               <li class="nav-link">
                  <a href="remaining_stocks.php">
                     <i class='fa fa-cubes icon' style=color:#715252></i>
                     <span class="text nav-text">Remaining Stocks </span>
                  </a>
               </li>
               <li class="nav-link">
                  <a href="sales.php">
                     <i class='fa fa-cog icon' style=color:#715252></i>
                     <span class="text nav-text">Sales</span>
                  </a>
               </li>
               <li class="nav-link">
                  <a href="return.php">
                     <i class='fa fa-registered icon' style=color:#715252></i>
                     <span class="text nav-text">Return</span>
                  </a>
               </li>
               <li class="nav-link">
                  <a href="lost_products.php">
                     <i class='fa fa-linode icon' style=color:#715252></i>
                     <span class="text nav-text">Lost Product</span>
                  </a>
               </li>
               <li class="nav-link">
                  <a href="gifts.php">
                     <i class='fa fa-gift icon' style=color:#715252></i>
                     <span class="text nav-text">Gifts</span>
                  </a>
               </li>
               <li class="nav-link logout">
                  <a href="logout.php">
                     <i class='bx bx-log-out icon' style=color:red></i>
                     <span class="text nav-text">Logout</span>
                  </a>
               </li>
            </ul>
         </div>
      </div>
   </nav>
  