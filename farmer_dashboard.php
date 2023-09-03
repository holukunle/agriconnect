<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="css/fontawesome/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

   <?php include 'farmer_header.php'; ?>

   <section class="dashboard">

      <h1 class="title">dashboard</h1>

      <div class="box-container">

         <div class="box">
            <?php
            $total_pendings = 0;

            $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ? AND user_id = ?");

            $select_pendings->execute(['pending', $user_id]);

            while ($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)) {
               $total_pendings += $fetch_pendings['total_price'];
            };
            ?>

            <h3>&#8358;<?= $total_pendings; ?></h3>
            <p>Pending Orders</p>
            <a href="farmer_orders.php" class="btn">see orders</a>
         </div>

         <div class="box">
            <?php
            $total_completed = 0;
            $select_completed = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ? AND user_id = ?");
            $select_completed->execute(['completed', $user_id]);
            while ($fetch_completed = $select_completed->fetch(PDO::FETCH_ASSOC)) {
               $total_completed += $fetch_completed['total_price'];
            };
            ?>
            <h3>&#8358;<?= $total_completed; ?></h3>
            <p>Completed Orders</p>
            <a href="farmer_comp_orders.php" class="btn">see orders</a>
         </div>

         <div class="box">
            <?php
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE user_id = ?");
            $select_products->execute([$user_id]);
            $number_of_products = $select_products->rowCount();
            ?>
            <h3><?= $number_of_products; ?></h3>
            <p>Products Added</p>
            <a href="farmer_products.php" class="btn">see products</a>
         </div>

         <div class="box">
            <?php
            $select_users = $conn->prepare("SELECT * FROM `users` WHERE user_type = ?");
            $select_users->execute(['buyer']);
            $number_of_users = $select_users->rowCount();
            ?>
            <h3><?= $number_of_users; ?></h3>
            <p>Total Buyers</p>
            <a href="buyer_list.php" class="btn">see accounts</a>
         </div>

      </div>

   </section>


   <script src="js/script.js"></script>

</body>

</html>