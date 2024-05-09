<?php
// Mulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inisialisasi variabel $user_id dengan nilai default null
$user_id = null;

// Periksa apakah session 'user_id' telah di-set
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}


?>

<header class="header">

   <div class="header-1">
      <div class="flex">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
         </div>
         <!-- Sesuaikan tautan login/register sesuai kebutuhan -->
         <?php if (!$user_id) : ?>
            <p> <a href="login.php">login</a> | <a href="register.php">register</a> </p>
         <?php endif; ?>
      </div>
   </div>

   <div class="header-2">
      <div class="flex">
         <a href="index.php" class="logo">Wirainsipirasi</a>

         <nav class="navbar">
            <a href="home.php">Beranda</a>
            <a href="about.php">Tentang Kami</a>
            <a href="shop.php">Kelas</a>
            <a href="contact.php">Kontak</a>
            <a href="orders.php">Pesanan</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
               
               if ($user_id) {
                  $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                  $cart_rows_number = mysqli_num_rows($select_cart_number);
            ?>
               <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
            <?php } ?>
         </div>

         <!-- Tambahkan kotak pengguna sesuai kebutuhan -->
         <?php if ($user_id) : ?>
            <div class="user-box">
               <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
               <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
               <a href="logout.php" class="delete-btn">logout</a>
            </div>
         <?php endif; ?>
      </div>
   </div>

</header>
