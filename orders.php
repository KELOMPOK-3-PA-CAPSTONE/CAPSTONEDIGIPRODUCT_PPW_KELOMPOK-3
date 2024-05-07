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
         background-color: #4CAF50; /* Green */
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
         background-color: #45a049; /* Darker Green */
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
      <p><a href="home.php">Home</a> / Orders</p>
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

               if ($payment_status == 'completed') {
                  $total_price_without_comma = str_replace(',', '', $total_price);
                  $product_query = mysqli_query($conn, "SELECT * FROM products WHERE price = '$total_price_without_comma'") or die('Query failed');
                  if (mysqli_num_rows($product_query) > 0) {
                     $product_row = mysqli_fetch_assoc($product_query);
                     $video_url = $product_row['lesson_video'];
                  }
               }
         ?>
               <div class="box">
                  <p>Nama kelas: <span><?php echo $product_name; ?></span></p>
                  <p>Metode pembayaran: <span><?php echo $fetch_orders['method']; ?></span></p>
                  <p>Harga: <span>Rp<?php echo $total_price; ?>.000</span></p>
                  <p>Status pembayaran: <span style="color:<?php echo $payment_status == 'pending' ? 'red' : 'green'; ?>"><?php echo $payment_status == 'pending' ? 'Menunggu verifikasi admin' : $payment_status; ?></span></p>
                  <?php if ($video_url) : ?>
                     <!-- Tombol "Tonton Video" -->
                     <button class="watch-video-btn" <?php echo $payment_status == 'pending' ? 'disabled' : ''; ?> data-video-url="<?php echo $video_url; ?>">Tonton Video</button>
                  <?php endif; ?>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">No orders placed yet!</p>';
         }
         ?>
      </div>
   </section>

   <?php include 'footer.php'; ?>

   <!-- Custom JS file link -->
   <script src="js/script.js"></script>

   <!-- JavaScript for video pop-up -->
   <script>
      document.addEventListener('DOMContentLoaded', function() {
         var videoPopup = document.getElementById('video-popup');
         var closeBtn = document.getElementById('close-btn');
         var popupVideo = document.getElementById('popup-video');

         // Function to open video pop-up
         function openVideoPopup(videoUrl) {
            popupVideo.src = videoUrl;
            videoPopup.style.display = 'block';
         }

         // Function to close video pop-up
         function closeVideoPopup() {
            popupVideo.pause(); // Pause the video
            videoPopup.style.display = 'none';
         }

         // Close video pop-up when close button is clicked
         closeBtn.addEventListener('click', closeVideoPopup);

         // Close video pop-up when clicking outside the pop-up
         window.addEventListener('click', function(event) {
            if (event.target == videoPopup) {
               closeVideoPopup();
            }
         });

         // Get all "Tonton Video" buttons
         var watchVideoBtns = document.querySelectorAll('.watch-video-btn');

         // Loop through each button and add click event listener
         watchVideoBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
               var videoUrl = this.getAttribute('data-video-url');
               openVideoPopup(videoUrl);
            });
         });
      });
   </script>
</body>
</html>