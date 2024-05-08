<?php
include 'config.php';

$message = ""; // Inisialisasi variabel pesan kesalahan

if(isset($_POST['submit'])){
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = mysqli_real_escape_string($conn, $_POST['password']);
   $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
   $user_type = $_POST['user_type'];

   // Pastikan panjang password adalah 10 karakter
   if(strlen($password) !== 10){
      $message = 'Password must be exactly 10 characters long!';
   } else {
      // Hash password
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

      if(mysqli_num_rows($select_users) > 0){
         // Jika email sudah terdaftar, tampilkan pesan kesalahan menggunakan alert JavaScript
         $message = 'Email telah terdaftar!';
      } else {
         if($password != $cpassword){
            $message = 'Confirm password does not match!';
         } else {
            mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$hashed_password', '$user_type')") or die('query failed');
            $message = 'Registered successfully!';
            header('location:login.php');
            exit; // Pastikan keluar dari skrip setelah mengarahkan pengguna ke halaman login
         }
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
   <title>Register</title>
   <!-- Font Awesome CDN link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- Custom CSS file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <?php if(!empty($message)): ?>
      <script>alert("<?php echo $message; ?>");</script>
   <?php endif; ?>

   <div class="form-container">
      <form action="" method="post">
         <h3>DAFTAR AKUN</h3>
         <input type="text" name="name" placeholder="Masukkan nama anda" required pattern="[A-Za-z\s]+" title="Invalid name!" class="box">
         <input type="email" name="email" placeholder="Masukkan email anda" required class="box">
         <input type="password" name="password" placeholder="Masukkan password anda (10 karakter)" required class="box" minlength="10" maxlength="10">
         <input type="password" name="cpassword" placeholder="Masukkan ulang password anda" required class="box">
         <input type="hidden" name="user_type" value="user"> 
         <input type="submit" name="submit" value="Daftar Sekarang" class="btn">
         <p>Sudah punya akun? <a href="login.php">Masuk</a></p>
      </form>
   </div>
</body>
</html>
