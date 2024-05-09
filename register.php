<?php
include 'config.php';

$message = array();

if(isset($_POST['submit'])){
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, $_POST['password']);
   $cpass = mysqli_real_escape_string($conn, $_POST['cpassword']);
   $user_type = $_POST['user_type'];

   // Validasi kekuatan password (minimal 6 karakter)
   if(strlen($pass) < 6){
      $message[] = 'Password should be at least 6 characters long!';
   }

   // Validasi konfirmasi password
   if($pass != $cpass){
      $message[] = 'Confirm password not matched!';
   }

   // Cek apakah email sudah terdaftar
   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('Query failed');
   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'Email already registered!';
   }

   // Jika tidak ada pesan kesalahan, masukkan user ke database
   if(empty($message)){
      $pass = mysqli_real_escape_string($conn, md5($pass));
      mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$pass', '$user_type')") or die('Query failed');
      $message[] = 'Registered successfully!';
      header('location:login.php');
      exit(); // Penting untuk menghentikan eksekusi kode setelah melakukan redirect
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
if(!empty($message)){
   foreach($message as $msg){
      echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
   <div class="form-container">
      <form action="" method="post">
         <h3>register now</h3>
         <input type="text" name="name" placeholder="Enter your name" required pattern="[A-Za-z\s]+" title="Nama tidak valid!" class="box">
         <input type="email" name="email" placeholder="Enter your email" required class="box">
         <input type="password" name="password" placeholder="Enter your password (at least 6 characters)" required class="box">
         <input type="password" name="cpassword" placeholder="Confirm your password" required class="box">
         <input type="hidden" name="user_type" value="user"> 
         <input type="submit" name="submit" value="register now" class="btn">
         <p>Already have an account? <a href="login.php">Login now</a></p>
      </form>
   </div>

</body>
</html>
