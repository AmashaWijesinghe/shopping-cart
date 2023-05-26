
<?php


@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login.php');
}


if(isset($_POST['add_product'])){
   $p_name = $_POST['p_name'];
   $p_price = $_POST['p_price'];
   $p_image = $_FILES['p_image']['name'];
   $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   $p_image_folder = 'uploaded_img/'.$p_image;

   $insert_query = mysqli_query($conn, "INSERT INTO `products`(name, price, image) VALUES('$p_name', '$p_price', '$p_image')") or die('query failed');

   if($insert_query){
      move_uploaded_file($p_image_tmp_name, $p_image_folder);
      $message[] = 'Product Add Succesfully';
   }else{
      $message[] = 'Could Not Add ';
   }
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_query = mysqli_query($conn, "DELETE FROM `products` WHERE id = $delete_id ") or die('query failed');
   if($delete_query){
      header('location:admin.php');
      $message[] = 'Product has been deleted';
   }else{
      header('location:admin.php');
      $message[] = 'Could not be deleted';
   };
};

if(isset($_POST['update_product'])){
   $update_p_id = $_POST['update_p_id'];
   $update_p_name = $_POST['update_p_name'];
   $update_p_price = $_POST['update_p_price'];
   $update_p_image = $_FILES['update_p_image']['name'];
   $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
   $update_p_image_folder = 'uploaded_img/'.$update_p_image;

   $update_query = mysqli_query($conn, "UPDATE `products` SET name = '$update_p_name', price = '$update_p_price', image = '$update_p_image' WHERE id = '$update_p_id'");

   if($update_query){
      move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
      $message[] = 'Product updated succesfully';
      header('location:admin.php');
   }else{
      $message[] = 'Could not be updated';
      header('location:admin.php');
   }

}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>admin</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>

    <?php

    if(isset($message)){
       foreach($message as $message){
          echo '<div class="msg"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
       };
    };

    ?>

   <?php include 'header.php'; ?>

    <div class="container">

    <section>

    <form action="" method="post" class="add" enctype="multipart/form-data">
       <h3>ADD THE PRODUCT</h3>
       <input type="text" name="p_name" placeholder="Product Name" class="box" required>
       <input type="number" name="p_price" min="0" placeholder="Product Price" class="box" required>
       <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
       <input type="submit" value="Add product" name="add_product" class="btn">
    </form>

    </section>

    <section class="display">

       <table>

          <thead>
             <th style="font-size:30px">Product Image</th>
             <th style="font-size:30px">Product Name</th>
             <th style="font-size:30px">Product Price</th>
             <th style="font-size:30px">Action</th>
          </thead>

          <tbody>
             <?php

                $select_products = mysqli_query($conn, "SELECT * FROM `products`");
                if(mysqli_num_rows($select_products) > 0){
                   while($row = mysqli_fetch_assoc($select_products)){
             ?>

             <tr>
                <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="120" alt="img"></td>
                <td style="font-size:25px"><?php echo $row['name']; ?></td>
                <td style="font-size:25px">Rs<?php echo $row['price']; ?>/-</td>
                <td >
                   <a href="admin.php?delete=<?php echo $row['id']; ?>" class="del-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> Delete </a>
                   <a href="admin.php?edit=<?php echo $row['id']; ?>" class="opt-btn"> <i class="fas fa-edit"></i> Update </a>
                </td>
             </tr>

             <?php
                };
                }else{
                   echo "<div class='empty'>Empty</div>";
                };
             ?>
          </tbody>
       </table>

    </section>

    <section class="edit">

       <?php

       if(isset($_GET['edit'])){
          $edit_id = $_GET['edit'];
          $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = $edit_id");
          if(mysqli_num_rows($edit_query) > 0){
             while($fetch_edit = mysqli_fetch_assoc($edit_query)){
       ?>

       <form action="" method="post" enctype="multipart/form-data">
          <img src="uploaded_img/<?php echo $fetch_edit['image']; ?>" height="200" alt="">
          <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">
          <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['name']; ?>">
          <input type="number" min="0" class="box" required name="update_p_price" value="<?php echo $fetch_edit['price']; ?>">
          <input type="file" class="box" required name="update_p_image" accept="image/png, image/jpg, image/jpeg">
          <input type="submit" value="Update the prodcut" name="update_product" class="btn">
          <input type="reset" value="Cancel" id="close-edit" class="opt-btn">
       </form>

       <?php
                };
             };
             echo "<script>document.querySelector('.edit').style.display = 'flex';</script>";
          };
       ?>

    </section>
    <script src="script.js"></script>

  </body>
</html>
