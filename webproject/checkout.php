<?php

@include 'config.php';

if(isset($_POST['order_btn'])){

   $name = $_POST['name'];
   $number = $_POST['number'];
   $email = $_POST['email'];
   $method = $_POST['method'];
   $address = $_POST['address'];
   $country = $_POST['country'];

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
   $price_total = 0;
   if(mysqli_num_rows($cart_query) > 0){
      while($product_item = mysqli_fetch_assoc($cart_query)){
         $product_name[] = $product_item['name'] .' ('. $product_item['quantity'] .') ';
         $product_price = number_format($product_item['price'] * $product_item['quantity']);
         $price_total += $product_price;
      };
   };

   $total_product = implode(', ',$product_name);
   $detail_query = mysqli_query($conn, "INSERT INTO `order`(name, number, email, method, address, country, total_products, total_price)
   VALUES('$name','$number','$email','$method','$address','$country','$total_product','$price_total')") or die('query failed');

   if($cart_query && $detail_query){
         echo "
         <div class='order-message-container'>
         <div class='message-container'>
            <h3>Thank You!</h3>
            <div class='order-detail'>
               <span>".$total_product."</span>
               <span class='total'> Total : Rs".$price_total."/-  </span>
            </div>
            <div class='customer-details'>
               <p> Name : <span>".$name."</span> </p>
               <p> Number : <span>".$number."</span> </p>
               <p> Email : <span>".$email."</span> </p>
               <p> Address : <span>".$address.", ".$country." </span> </p>
               <p> Payment mode : <span>".$method."</span> </p>
            </div>
               <a href='products.php' class='btn'>Continue shopping</a>
            </div>
         </div>
         ";
      }

   }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>checkout</title>

<link rel="stylesheet" href="style.css">

  </head>
  <body>

    <?php include 'head.php'; ?>

<div class="container">

<section class="checkout">

   <h1 class="heading">Complete the order</h1>

   <form action="" method="post">

   <div class="display-order">
      <?php
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
         $total = 0;
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = number_format($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total = $total += $total_price;
      ?>
      <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
      <?php
         }
      }else{
         echo "<div class='display-order'><span>Cart is empty!</span></div>";
      }
      ?>
      <span class="grand-total"> Total : Rs<?= $grand_total; ?>/- </span>
   </div>

      <div class="flex">
         <div class="inputBox">
            <span>Name</span>
            <input type="text" placeholder="Your name" name="name" required>
         </div>
         <div class="inputBox">
            <span>your number</span>
            <input type="number" placeholder="Your number" name="number" required>
         </div>
         <div class="inputBox">
            <span>your email</span>
            <input type="email" placeholder="Your email" name="email" required>
         </div>
         <div class="inputBox">
            <span>Payment method</span>
            <select name="method">
               <option value="cash on delivery" selected>Cash on devlivery</option>
               <option value="credit cart">Credit cart</option>
               <option value="paypal">Paypal</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Address</span>
            <input type="text" placeholder="e.g. Address" name="address" required>
         </div>
         <div class="inputBox">
            <span>Country</span>
            <input type="text" placeholder="e.g. Sri Lanka" name="country" required>
         </div>
      </div>
      <input type="submit" value="Order now" name="order_btn" class="btn">
   </form>

</section>

</div>


  <script src="script.js"></script>

  </body>
</html>
