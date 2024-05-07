<?php

include 'config.php';

// Session start dan user_id diinisialisasi dengan nilai default null
session_start();
$user_id = null;

// Periksa apakah session 'user_id' telah di-set
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<header class="header">
   <div class="header-1">
      
      <div class="flex">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
         </div>
    
            <p> <a href="login.php">login</a> | <a href="register.php">register</a> </p>
    
      </div>
   </div>
</header>

<section class="home">

   <div class="content">
      <h3>Siapakan Dirimu menjadi wirausaha</h3>
      <p> platform terbuka bagi pemuda Indonesia untuk mengembangkan keterampilan wirausaha melalui kelas berbayar yang dirancang oleh para ahli..</p>
      <a href="register.php" class="white-btn">Daftar Sekarang</a>
   </div>

</section>

<section class="insight">
   <div class="container box">
      <div class="content">
      <h1 class="title">Insight</h1>
         <p>Ini adalah bagian Insight..</p>
      </div>
   </div>
</section>

<section class="products">

   <h1 class="title">Kelas Yang tersedia</h1>

   <div class="box-container">

      <?php  
         // Sesuaikan query untuk mendapatkan produk dari database
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
    <form action="" method="post" class="box">
    <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
    <div class="name"><?php echo $fetch_products['name']; ?></div>
    <div class="price">Rp<?php echo $fetch_products['price']; ?>.000</div>
    <!-- Menghilangkan input hidden untuk user_id -->
    <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
    <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
    <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
    <?php if (!$user_id) : ?>
        <a href="register.php" class="btn">Daftar Sekarang</a>
    <?php else : ?>
        <input type="submit" value="Daftar Sekarang" name="add_to_cart" class="btn">
    <?php endif; ?>
</form>

      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="login.php" class="option-btn">Daftar Sekarang</a>
   </div>

</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/home.jpeg" alt="">
      </div>

      <div class="content">
         <h3>about us</h3>
         <p>WiraInspirasi dapat diakses seluruh Indonesia dengan fokus pada pemuda dalam meningkatkan semangat berwirausaha.</p>
      </div>

   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>Frequently Asked Questions</h3>
      <p><strong>What is included in class Wirainsipirasi?</strong></p>
      <p>Our class Wirainsipirasi includes comprehensive lessons covering various topics such as creativity, problem-solving, communication, and leadership. You'll have access to engaging video lectures, interactive quizzes, practical exercises, and downloadable resources to enhance your learning experience.</p>
   </div>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
