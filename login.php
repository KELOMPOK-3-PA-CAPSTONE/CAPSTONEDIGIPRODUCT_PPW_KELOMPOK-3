<?php
include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){

      $row = mysqli_fetch_assoc($select_users);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];

         // Set cookie if "Remember Me" is checked
         if(isset($_POST['remember'])) {
            setcookie('user_email', $row['email'], time() + (86400 * 30), "/"); // 30 days
         }

         header('location:admin_page.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];

         // Set cookie if "Remember Me" is checked
         if(isset($_POST['remember'])) {
            setcookie('user_email', $row['email'], time() + (86400 * 30), "/"); // 30 days
         }

         header('location:home.php');

      }

   }else{
      $message[] = 'Incorrect email or password!';
   }

}

// Check if user_email cookie is set, then automatically fill the email field
if(isset($_COOKIE['user_email'])) {
   $remembered_email = $_COOKIE['user_email'];
} else {
   $remembered_email = '';
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
      /* CSS untuk pesan kesalahan */
      .error-message {
         color: red;
         margin-bottom: 10px;
      }
   </style>
</head>
<body>
   <div class="form-container">
      <form action="" method="post">
         <h3>Login Now</h3>
         <?php
         // Tampilkan pesan kesalahan jika ada
         if(!empty($message)){
            echo '<div class="error-message">';
            foreach($message as $msg){
               echo '<p>'.$msg.'</p>';
            }
            echo '</div>';
         }
         ?>
         <input type="email" name="email" placeholder="Enter your email" required class="box" value="<?php echo $remembered_email; ?>">
         <input type="password" name="password" placeholder="Enter your password" required class="box">
         <div class="remember-me">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Remember Me</label>
         </div>
         <input type="submit" name="submit" value="Login Now" class="btn">
         <p>Don't have an account? <a href="register.php">Register Now</a></p>
      </form>
   </div>
</body>
</html>
