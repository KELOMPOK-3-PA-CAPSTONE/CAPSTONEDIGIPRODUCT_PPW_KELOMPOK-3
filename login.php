<?php
session_start();

include 'config.php';

$message = ""; // Inisialisasi variabel pesan kesalahan

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = mysqli_real_escape_string($conn, $_POST['password']);

   $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($select_user) > 0){
      $row = mysqli_fetch_assoc($select_user);
      $hashed_password = $row['password']; // Ambil hash kata sandi yang tersimpan di database
      // Verifikasi kata sandi yang dimasukkan oleh pengguna dengan hash yang tersimpan di database
      if(password_verify($password, $hashed_password)){
         // Jika verifikasi berhasil, atur sesi pengguna dan arahkan ke halaman yang sesuai
         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         header('location:home.php');
         exit; // Pastikan keluar dari skrip setelah mengarahkan pengguna ke halaman home
      } else {
         $message = 'Incorrect email or password!';
      }
   } else {
      $message = 'Incorrect email or password!';
   }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <!-- Font Awesome CDN link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- Custom CSS file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      /* CSS untuk mengatur ukuran kotak "Remember Me" */
      .remember-me {
         margin-top: 10px; /* Berikan margin atas agar terpisah dari inputan */
      }
      .remember-me label {
         display: inline-block;
         width: auto;
         margin-bottom: 0; /* Hilangkan margin bawah agar sesuai dengan kotak input */
      }
      .remember-me input[type="checkbox"] {
         margin-right: 5px; /* Berikan margin ke kanan agar sesuai dengan tata letak */
      }
   </style>
</head>
<body>
   <div class="form-container">
      <form action="" method="post">
         <h3>Login Now</h3>
         <input type="email" name="email" placeholder="Enter your email" required class="box" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
         <input type="password" name="password" placeholder="Enter your password" required class="box">
         <div class="remember-me">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Remember Me</label>
         </div>
         <input type="submit" name="submit" value="Login Now" class="btn">
         <p>Don't have an account? <a href="register.php">Register Now</a></p>
      </form>
   </div>

   <?php if (!empty($message)): ?>
      <script>
         alert("<?php echo $message; ?>");
      </script>
   <?php endif; ?>
</body>
</html>
