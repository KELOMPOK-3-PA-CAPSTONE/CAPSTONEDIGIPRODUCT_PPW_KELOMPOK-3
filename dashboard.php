<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
if(!isset($user_id)){
   header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Dashboard</h3>
   <p> <a href="home.php">Home</a> / Dashboard </p>
</div>

<section class="dashboard">
   <h1 class="title">Video Pembelajaran</h1>

   <div class="orders-container">
      <?php
         // Periksa apakah parameter URL dikirimkan dari halaman Orders untuk menampilkan video pembelajaran
         if(isset($_GET['show_video']) && $_GET['show_video'] === 'true' && isset($_GET['product_name'])) {
            // Ambil nama kelas dari parameter URL
            $selected_product_name = $_GET['product_name'];
            // Query untuk mendapatkan informasi produk berdasarkan nama kelas
            $product_query = mysqli_query($conn, "SELECT * FROM products WHERE name = '$selected_product_name' AND lesson_video IS NOT NULL LIMIT 1") or die('Query failed');
            if(mysqli_num_rows($product_query) > 0){
               $product = mysqli_fetch_assoc($product_query);
      ?>
      <div class="order">
         <p>Product Name: <?php echo $product['name']; ?></p>
         <p>Product Description: <?php echo $product['deskripsi']; ?></p>
         <!-- Kontainer video yang ditampilkan -->
         <div class="video-container">
            <video controls>
               <source src="<?php echo $product['lesson_video']; ?>" type="video/mp4">
               Your browser does not support the video tag.
            </video>
         </div>
      </div>
      <?php
            } else {
               // Jika tidak ada produk dengan video pembelajaran yang sesuai, tampilkan pesan
               echo '<p class="empty">No lesson video available for the selected product!</p>';
            }
         } else {
            // Jika parameter URL tidak lengkap, tampilkan pesan
            echo '<p class="empty">Please select a product from Orders to view its lesson video.</p>';
         }
      ?>
   </div>
</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
