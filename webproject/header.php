<header class="header">

   <div class="flex">

      <a href="#" class="logo">FOODS</a>

      <nav class="nav">
         <a href="admin.php">Add Products</a>
         <a href="products.php">View Products</a>
         <a href="logout.php" >logout</a>

      </nav>

      <?php

      $select_rows = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
      $row_count = mysqli_num_rows($select_rows);

      ?>
      <a href="cart.php" class="cart">Cart <span><?php echo $row_count; ?></span> </a>



         </div>

      </header>
