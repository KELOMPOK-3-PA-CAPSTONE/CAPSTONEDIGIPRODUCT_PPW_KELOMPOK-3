<?php
// Sertakan file konfigurasi database
include 'config.php';

// Mulai sesi
session_start();

// Periksa apakah pengguna sudah login
$admin_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : null;
if (!$admin_id) {
    header('location:login.php');
    exit;
}

// Proses pembaruan status pembayaran jika form "update_order" dikirim
if (isset($_POST['update_order'])) {
    // Ambil id pesanan yang akan diperbarui
    $order_update_id = isset($_POST['order_id']) ? $_POST['order_id'] : null;
    
    // Periksa apakah 'update_payment' ada dalam $_POST
    $update_payment = isset($_POST['update_payment']) ? $_POST['update_payment'] : '';
    
    // Pastikan 'update_payment' tidak kosong
    if (!empty($update_payment) && $order_update_id) {
        // Update status pembayaran dalam database
        $update_query = "UPDATE `orders` SET payment_status = '$update_payment' WHERE order_id = '$order_update_id'";
        if (mysqli_query($conn, $update_query)) {
            $message[] = 'Payment status has been updated!';
        } else {
            $message[] = 'Failed to update payment status!'; // Pesan kesalahan jika 'update_payment' tidak tersedia
        }
    }
}

// Proses penghapusan pesanan jika parameter GET 'delete' tersedia
if (isset($_GET['delete'])) {
    // Ambil id pesanan yang akan dihapus
    $delete_id = isset($_GET['delete']) ? $_GET['delete'] : null;
    
    // Hapus pesanan dari database
    if ($delete_id) {
        $delete_query = "DELETE FROM `orders` WHERE order_id = '$delete_id'";
        if (mysqli_query($conn, $delete_query)) {
            header('location:admin_orders.php');
            exit;
        } else {
            $message[] = 'Failed to delete order!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">

   <h1 class="title">Pemesanan Kelas</h1>

   <div class="box-container">
      <?php
      // Ambil semua pesanan dari database
      $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('Query failed');
      if (mysqli_num_rows($select_orders) > 0) {
         while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
      ?>
      <div class="box">
         <p>Nama kelas: <span><?php echo $fetch_orders['product_name']; ?></span></p>
         <p>User ID: <span><?php echo $fetch_orders['user_id']; ?></span></p>
         <p>TGL Pemesanan: <span><?php echo $fetch_orders['placed_on']; ?></span></p>
         <p>Alamat: <span><?php echo $fetch_orders['address']; ?></span></p>
         <p>Total Harga: <span>Rp.<?php echo $fetch_orders['total_price']; ?>.000</span></p>
         <p>Metode pembayaran : <span><?php echo $fetch_orders['method']; ?></span></p>
         <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['order_id']; ?>">
            <select name="update_payment">
               <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
               <option value="pending">Pending</option>
               <option value="completed">Completed</option>
            </select>
            <input type="submit" value="Update" name="update_order" class="option-btn">
            <a href="admin_orders.php?delete=<?php echo $fetch_orders['order_id']; ?>" onclick="return confirm('Delete this order?');" class="delete-btn">Delete</a>
         </form>
      </div>
      <?php
         }
      } else {
         echo '<p class="empty">No orders placed yet!</p>';
      }
      ?>
   </div>
</section>

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
