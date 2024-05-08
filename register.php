<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = mysqli_real_escape_string($conn, $_POST['password']);
   $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
   $user_type = $_POST['user_type'];

   // Pastikan panjang password adalah 10 karakter
   if(strlen($password) !== 10){
      $message[] = 'Password must be exactly 10 characters long!';
   } else {

      // Hash password
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

      if(mysqli_num_rows($select_users) > 0){
         $message[] = 'User already exists!';
      }else{
         if($password != $cpassword){
            $message[] = 'Confirm password does not match!';
         }else{
            mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$hashed_password', '$user_type')") or die('query failed');
            $message[] = 'Registered successfully!';
            header('location:login.php');
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

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<div class="form-container">
   <form action="" method="post">
      <h3>Register Now</h3>
      <input type="text" name="name" placeholder="Enter your name" required pattern="[A-Za-z\s]+" title="Invalid name!" class="box">
      <input type="email" name="email" placeholder="Enter your email" required class="box">
      <input type="password" name="password" placeholder="Enter your password (10 characters)" required class="box" minlength="10" maxlength="10">
      <input type="password" name="cpassword" placeholder="Confirm your password" required class="box">
      <input type="hidden" name="user_type" value="user"> 
      <input type="submit" name="submit" value="Register Now" class="btn">
      <p>Already have an account? <a href="login.php">Login Now</a></p>
   </form>
</div>

</body>
</html>
