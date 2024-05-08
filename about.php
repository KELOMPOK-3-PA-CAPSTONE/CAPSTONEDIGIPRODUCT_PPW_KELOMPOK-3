<?php

include 'config.php';

session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Tentang kami</h3>
   <p> <a href="home.php">Beranda</a> / Tentang kami </p>
</div>


<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/home.jpeg" alt="">
      </div>

      <div class="content">
         <h3>Kenapa harus memilih Wirainsipirasi?</h3>
         <p>Wirainsipirasi adalah platform terbuka bagi pemuda Indonesia untuk mengembangkan keterampilan wirausaha melalui kelas berbayar yang dirancang oleh para ahli.</p>
         <p>Tujuan utama kami adalah meningkatkan efisiensi dan efektivitas pembelajaran, serta meningkatkan aksesibilitas dan fleksibilitas waktu bagi peserta didik. </p>
         <a href="contact.php" class="btn">Hubungi Kami</a>
      </div>

   </div>


<section class="reviews">

<?php

$wirainspirasi = "Wirainspirasi?"; 
?>

<h1 class="title">Apa Kata Mereka Tentang <spa class="highlight"><?php echo $wirainspirasi; ?></spa</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/pic-11.png" alt="">
         <p>Saya sangat terkesan dengan pengalaman belajar saya di Wirainspirasi. Kelas-kelas mereka memberikan wawasan yang mendalam tentang bagaimana memulai dan mengelola bisnis</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Fatim</h3>
      </div>

      <div class="box">
         <img src="images/pic-12.png" alt="">
         <p>Saya merekomendasikan Wirainspirasi ke mahasiswa pascasarjana. Materi yang ada tidak hanya relevan dengan kehidupan bisnis saat ini, tetapi juga memberikan perspektif tentang tren dan perubahan di pasar global. </p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Tia</h3>
      </div>

      <div class="box">
         <img src="images/pic-13.png" alt="">
         <p>Saya selalu memimpikan untuk memiliki bisnis sendiri, tetapi saya merasa kebingungan tentang langkah-langkah yang harus diambil. Mengikuti kursus di Wirainspirasi telah membantu saya mengatasi keraguan saya.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Ephan</h3>
      </div>

      <div class="box">
         <img src="images/pic-14.png" alt="">
         <p>Pengalaman saya dengan Wirainspirasi mengubah pandangan saya sepenuhnya. Mereka menawarkan kelas-kelas yang sangat interaktif dan menghadirkan materi dengan cara yang menarik</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Novilda</h3>
      </div>

      <div class="box">
         <img src="images/pic-15.png" alt="">
         <p>Saya telah mengikuti kelas di Wirainspirasi, dan pengalaman belajar saya sangat memuaskan. Saya merasa lebih percaya diri dalam menghadapi tantangan di masa depan</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Caesar</h3>
      </div>

      <div class="box">
         <img src="images/pic-16.png" alt="">
         <p>Wirainspirasi memberikan wawasan bisnis yang mendalam pendekatan praktis dan materi yang relevan membuat saya lebih siap dan yakin untuk tantangan di pasar kerja.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Naya</h3>
      </div>

   </div>
   </section>
   <section class="authors">

<h1 class="title">Mentor yang berpengalaman</h1>

<div class="box-container">

   <div class="box">
      <img src="images/mentor1.jpeg" alt="">
      <h3>Muthmainnah, S.T.</h3>
      <p>Experience: 3 years</p>
   </div>

   <div class="box">
      <img src="images/mentor2.jpeg" alt="">
      <h3>Kayla, S.M.B.</h3>
      <p>Experience: 5 years</p>
   </div>

   <div class="box">
      <img src="images/mentor3.jpg" alt="">
      <h3>Harry, S.M.B.</h3>
      <p>Experience: 7 years</p>
   </div>

   <div class="box">
      <img src="images/mentor4.jpeg" alt="">
      <h3>Aufa, S.M.B.</h3>
      <p>Experience: 4 years</p>
   </div>

   <div class="box">
      <img src="images/mentor5.jpg" alt="">
      <h3>Zaki, S.M.B.</h3>
      <p>Experience: 6 years</p>
   </div>

   <div class="box">
      <img src="images/mentor6.jpeg" alt="">
      <h3>Fazry, S.M.B.</h3>
      <p>Experience: 8 years</p>
   </div>

</div>

</section>


<?php include 'footer.php'; ?>

<!-- custom js file link -->
<script src="js/script.js"></script>

</body>
</html>
