<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit(); // Pastikan tidak ada output sebelum header
}

$user_id = $_SESSION['user_id'];

$message = array(); // Inisialisasi pesan

if (isset($_POST['add_to_cart'])) {
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
    $product_quantity = 1;

    $select_product_id = mysqli_query($conn, "SELECT id FROM `products` WHERE name = '$product_name'");
    if ($select_product_id) {
        $product_id_row = mysqli_fetch_assoc($select_product_id);
        $product_id = $product_id_row['id'];
    }

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'already added to cart!';
    } else {
        mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'product added to cart!';
    }
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
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>Siapakan dirimu menjadi wirausaha </h3>
      <p> platform terbuka bagi pemuda untuk mengembangkan keterampilan wirausaha melalui kelas berbayar yang dirancang oleh para ahli..</p>
      <a href="shop.php" class="white-btn">Daftar Sekarang</a>
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

   <h1 class="title">Kami Menyediakan Berbagai Course</h1>

   <div class="box-container">
      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
     <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <div class="price">Rp<?php echo $fetch_products['price']; ?>.000</div>
      <!-- Removed quantity input and added two buttons -->
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <button type="submit" class="btn" name="add_to_cart">Add to Cart</button>
     
<a href="detail.php?product_id=<?php echo $fetch_products['id']; ?>" class="btn">Show Detail</a>

     </form>
      <?php
         }
      } else {
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="option-btn">Go to course</a>
   </div>

</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/home.jpeg" alt="">
      </div>

      <div class="content">
         <h3>about us</h3>
         <p>Wirainsipirasi adalah platform terbuka bagi pemuda Indonesia untuk mengembangkan keterampilan wirausaha melalui kelas berbayar yang dirancang oleh para ahli.</p>
         <a href="about.php" class="btn">read more</a>
      </div>

   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>have any questions?</h3>
      <p>Jika Anda memiliki pertanyaan tentang materi kursus atau membutuhkan bantuan tambahan. Kami akan dengan senang hati membantu Anda!</p>
      <a href="contact.php" class="white-btn">contact us</a>
   </div>

</section>

<?php include 'footer.php'; ?>


<script src="js/script.js"></script>

</body>
</html>
