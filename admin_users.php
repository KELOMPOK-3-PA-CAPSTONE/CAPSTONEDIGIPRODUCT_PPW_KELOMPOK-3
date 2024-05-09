<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

$message = '';

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   // Cek apakah pengguna yang akan dihapus bukanlah admin
   $select_user_type = mysqli_query($conn, "SELECT user_type FROM `users` WHERE id = '$delete_id'");
   if(!$select_user_type) {
       die("Error: " . mysqli_error($conn)); // Menampilkan pesan kesalahan jika terjadi kesalahan pada kueri
   }
   $fetch_user_type = mysqli_fetch_assoc($select_user_type);
   if($fetch_user_type['user_type'] !== 'admin'){
      $delete_query = mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'");
      if(!$delete_query) {
          die("Error: " . mysqli_error($conn)); // Menampilkan pesan kesalahan jika terjadi kesalahan saat menghapus pengguna
      } else {
          $message = 'User berhasil dihapus.';
      }
   } else {
       $message = 'Anda tidak dapat menghapus akun admin.';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Users</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="users">

   <h1 class="title">User Accounts</h1>

   <div class="box-container">
      <?php
         $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
         while($fetch_users = mysqli_fetch_assoc($select_users)){
            // Tambahkan kondisi untuk memeriksa jika pengguna bukanlah admin
            if($fetch_users['user_type'] !== 'admin'){
      ?>
      <div class="box">
         <p>User ID: <span><?php echo $fetch_users['id']; ?></span></p>
         <p>Username: <span><?php echo $fetch_users['name']; ?></span></p>
         <p>Email: <span><?php echo $fetch_users['email']; ?></span></p>
         <p>User Type: <span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'var(--orange)'; } ?>"><?php echo $fetch_users['user_type']; ?></span></p>
         <!-- Hanya tampilkan tombol hapus jika pengguna bukanlah admin -->
         <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Delete this user?');" class="delete-btn">Delete User</a>
      </div>
      <?php
            }
         };
      ?>
   </div>

</section>

<?php if(!empty($message)): ?>
    <div class="message"><?php echo $message; ?></div>
<?php endif; ?>

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
