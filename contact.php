<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

$message = ''; // Inisialisasi variabel pesan

if(isset($_POST['send'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $number = $_POST['number'];
   $msg = mysqli_real_escape_string($conn, $_POST['message']);

   $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

   if(mysqli_num_rows($select_message) > 0){
      $message = 'Message sent already!';
   }else{
      mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
      $message = 'Message sent successfully!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact</title>

   <!-- Font Awesome CDN link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
      /* Background form */
      .contact form {
         background-color: var(--purple); 
      }

      .submit-btn {
         background-color: var(--orange);
         padding: 10px 20px; /* Padding untuk menentukan ukuran tombol */
         border: none; /* Menghapus border */
         border-radius: 5px; /* Membuat sudut tombol menjadi melengkung */
         cursor: pointer; /* Mengubah kursor menjadi tanda arah saat diarahkan ke tombol */
         transition: background-color 0.3s ease; /* Transisi smooth ketika dihover */
      }

      .submit-btn:hover {
         background-color: var(--white); /* Warna latar belakang saat dihover */
         color: black;
      }

      .message {
         color: green; /* Warna pesan berhasil */
         margin-top: 10px; /* Ruang atas pesan */
      }
   </style>

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Contact Us</h3>
   <p> <a href="home.php">Beranda</a> / Kontak Kami </p>
</div>

<section class="contact">

   <form action="" method="post">
      <h3 style="color: white;">Ada yang ingin ditanyakan?</h3>
      <input type="text" name="name" required placeholder="Masukkan nama anda" class="box">
      <input type="email" name="email" required placeholder="Masukkan email anda" class="box">
      <input type="number" name="number" required placeholder="Masukkan Nomor Anda (maksimal 13 digit)" class="box" id="number" maxlength="13">
      <textarea name="message" class="box" placeholder="Masukkan Pesan" id="" cols="30" rows="10"></textarea>
      <input type="submit" value="Kirim Pesan" name="send" class="btn submit-btn">
   </form>

   <div class="message"><?php echo $message; ?></div> <!-- Menampilkan pesan hasil kirim -->

</section>

<?php include 'footer.php'; ?>

<!-- Custom JS file link -->
<script src="js/script.js"></script>

<!-- JavaScript for limiting number input -->
<script>
   document.getElementById('number').addEventListener('input', function() {
      if (this.value.length > 13) {
         this.value = this.value.slice(0, 13); // Hanya menerima 13 karakter pertama
      }
   });
</script>

</body>
</html>
