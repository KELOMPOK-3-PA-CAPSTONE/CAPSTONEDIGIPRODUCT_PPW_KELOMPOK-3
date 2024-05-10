<?php
// Sertakan file konfigurasi database
include 'config.php';

// Mulai sesi
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>

   <!-- Font Awesome CDN link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS file link  -->
   <link rel="stylesheet" href="css/style.css">

   <!-- CSS for video pop-up -->
   <style>
      .video-popup {
         display: none;
         position: fixed;
         z-index: 9999;
         left: 0;
         top: 0;
         width: 100%;
         height: 100%;
         background-color: rgba(0, 0, 0, 0.5);
         overflow: auto; /* Tambahkan overflow untuk memungkinkan scroll jika video melebihi ukuran layar */
      }

      .video-popup-content {
         position: relative; /* Ubah posisi menjadi relatif agar dapat diatur ulang */
         margin: auto; /* Pusatkan vertikal */
         max-width: 80%; /* Batasi lebar maksimum untuk menghindari penyebaran penuh */
         background-color: white;
         padding: 20px;
         border-radius: 10px;
      }

      .close-btn {
         position: absolute;
         top: 10px;
         right: 10px;
         cursor: pointer;
      }

      /* CSS for video */
      #popup-video {
         width: 100%; /* Sesuaikan lebar video dengan lebar konten */
         height: auto; /* Biarkan tinggi otomatis sesuai rasio aspek */
      }

      /* CSS for button */
      .watch-video-btn {
         background-color: var(--purple);
         border: none;
         color: white;
         padding: 10px 20px;
         text-align: center;
         text-decoration: none;
         display: inline-block;
         font-size: 16px;
         margin: 4px 2px;
         cursor: pointer;
         border-radius: 8px;
         transition-duration: 0.4s;
         outline: none;
      }

      .watch-video-btn:hover {
         background-color: var(--orange);
      }

      .watch-video-btn[disabled] {
         background-color: #cccccc; /* Grey */
         cursor: not-allowed;
      }
   </style>
</head>
<body>
   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>Your Orders</h3>
      <p><a href="home.php">Beranda</a> / Pesanan</p>
   </div>

   <!-- Video pop-up -->
   <div class="video-popup" id="video-popup">
      <div class="video-popup-content">
         <span class="close-btn" id="close-btn">&times;</span>
         <video controls id="popup-video" width="400">
            <source src="" type="video/mp4">
            Your browser does not support the video tag.
         </video>
      </div>
   </div>

   <section class="placed-orders">
      <h1 class="title">Placed Orders</h1>
      <div class="box-container">
         <?php
         $user_id = $_SESSION['user_id'];
         $order_query = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = '$user_id'") or die('query failed');
         if (mysqli_num_rows($order_query) > 0) {
            while ($fetch_orders = mysqli_fetch_assoc($order_query)) {
               $order_id = $fetch_orders['order_id'];
               $total_price = $fetch_orders['total_price'];
               $product_name = preg_replace('/[^A-Za-z\s]/', '', $fetch_orders['product_name']);
               $payment_status = $fetch_orders['payment_status'];
               $video_url = null;
               $community_link = null;

               if ($payment_status == 'completed') {
                  $total_price_without_comma = str_replace(',', '', $total_price);
                  $product_query = mysqli_query($conn, "SELECT * FROM products WHERE price = '$total_price_without_comma'") or die('Query failed');
                  if (mysqli_num_rows($product_query) > 0) {
                     $product_row = mysqli_fetch_assoc($product_query);
                     $video_url = $product_row['lesson_video'];
                     $community_link = $product_row['link']; // Menambahkan link komunitas
                  }
               }
         ?>
               <div class="box">
                  <p>Nama kelas: <span><?php echo $product_name; ?></span></p>
                  <p>Metode pembayaran: <span><?php echo $fetch_orders['method']; ?></span></p>
                  <p>Harga: <span>Rp<?php echo $total_price; ?>.000</span></p>
                  <p>Status pembayaran: <span style="color:<?php echo $payment_status == 'pending' ? 'red' : 'green'; ?>"><?php echo $payment_status == 'pending' ? 'Menunggu verifikasi admin' : $payment_status; ?></span></p>
                  <!-- Tombol video -->
                  <button class="watch-video-btn" <?php echo $payment_status == 'pending' ? 'disabled' : ''; ?> data-video-url="<?php echo $video_url; ?>">Tonton Video</button>
                  <!-- Tombol komunitas -->
                  <a href="<?php echo $community_link; ?>" class="watch-video-btn community-btn" <?php echo $payment_status == 'pending' ? 'disabled' : ''; ?>>Lihat Komunitas</a>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">Kamu belum ada melakukan pemesanan!</p>';
         }
         ?>
      </div>
   </section>

   <?php include 'footer.php'; ?>

   <!-- Custom JS file link -->
   <script src="js/script.js"></script>

   <!-- JavaScript for button behavior -->
   <script>
      document.addEventListener('DOMContentLoaded', function() {
         // Get all "Lihat Komunitas" buttons
         var communityBtns = document.querySelectorAll('.community-btn');

         // Loop through each button and add click event listener
         communityBtns.forEach(function(btn) {
            btn.addEventListener('click', function(event) {
               // Prevent the default behavior (opening video pop-up)
               event.preventDefault();

               // Get the community link from the button's href attribute
               var communityLink = this.getAttribute('href');

               // Redirect the user to the community link
               window.location.href = communityLink;
            });
         });

         // Get all "Tonton Video" buttons
         var videoBtns = document.querySelectorAll('.watch-video-btn');

         // Loop through each button and add click event listener
         videoBtns.forEach(function(btn) {
            btn.addEventListener('click', function(event) {
               // Prevent the default behavior (opening video pop-up or following link)
               event.preventDefault();

               // Get the video URL from the button's data attribute
               var videoUrl = this.getAttribute('data-video-url');

               // If video URL exists, open the video pop-up
               if (videoUrl) {
                  // Set the video source
                  var videoSource = document.getElementById('popup-video').querySelector('source');
                  videoSource.setAttribute('src', videoUrl);

                  // Reload the video
                  var popupVideo = document.getElementById('popup-video');
                  popupVideo.load();

                  // Display the video pop-up
                  document.getElementById('video-popup').style.display = 'block';
               }
            });
         });

         // Close video pop-up when close button is clicked
         document.getElementById('close-btn').addEventListener('click', function() {
            document.getElementById('video-popup').style.display = 'none';
         });
      });
   </script>
</body>
</html>
