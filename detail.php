<?php
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Query untuk mengambil detail produk berdasarkan product_id
    $query = "SELECT * FROM products WHERE id = '$product_id'";
    $result = mysqli_query($conn, $query);
 
    // Pastikan produk dengan product_id yang diberikan ditemukan
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        // Redirect jika produk tidak ditemukan
        header('location:home.php');
        exit;
    }
} else {
    // Redirect jika parameter product_id tidak ditemukan
    header('location:home.php');
    exit;
}

// Pesan yang akan ditampilkan setelah produk berhasil ditambahkan ke keranjang
$message = [];

// Proses penambahan ke keranjang saat tombol "Add to Cart" ditekan
if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = 1;

    // Periksa apakah produk sudah ada di keranjang pengguna
    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM cart WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'Already added to cart!';
    } else {
        // Tambahkan produk ke keranjang
        mysqli_query($conn, "INSERT INTO cart(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        // Tambahkan pesan ke dalam array $message
        $message[] = 'Product added to cart! Silahkan kembali untuk melanjutkan pembayaran.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Detail Produk</title>

   <!-- Font Awesome CDN link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS file link  -->
   <link rel="stylesheet" href="css/style.css">

   <!-- Custom CSS for product detail section -->
   <style>
      .container {
         margin-top: 50px;
      }
      .product-detail {
         display: flex;
         justify-content: space-between;
         align-items: flex-start;
         margin-top: 20px;
      }
      .product-box {
         width: 48%;
         padding: 20px;
         background-color: #f9f9f9;
         border: 1px solid #ddd;
         border-radius: 5px;
      }
      .product-info {
         margin-bottom: 20px;
      }
      .product-image img {
         max-width: 100%;
         height: auto;
         border: 1px solid #ddd;
         border-radius: 5px;
      }
      .product-image .image-container {
         position: relative;
      }
      .product-image .lifetime-access {
         position: absolute;
         bottom: 10px;
         left: 50%;
         transform: translateX(-50%);
         background-color: rgba(255, 255, 255, 0.7);
         padding: 5px 10px;
         border-radius: 5px;
         font-size: 14px;
      }
      .btn-container {
         text-align: center;
      }
   </style>
</head>
<body>
   
<?php include 'header.php'; ?>

<div class="container">
   <div class="row">
      <div class="col-12">
         <div class="jumbotron jumbotron-fluid" style="background-color: #e3f2fd;">
            <div class="container">
               <h1 class="display-4 text-center" style="color: rgb(55, 71, 133); font-weight: 200;">Informasi Kelas Wirausaha</h1>
            </div>
         </div>
      </div>
   </div>
</div>

<section class="product-detail">
   <div class="product-box product-info">
      <h1>Detail Kursus</h1>
      <?php if(isset($row)) : ?>
         <div class="product-name">
            <h2>Nama kelas:</h2>
            <h3><?php echo $row['name']; ?></h3>
         </div>
         <div class="product-description">
            <h2>Deskripsi:</h2>
            <h3><?php echo $row['deskripsi']; ?></h3>
         </div>
         <div class="product-purpose">
            <h2>Tujuan:</h2>
            <h3><?php echo $row['tujuan']; ?></h3>
         </div>
         <div class="product-price">
            <h2>Harga:</h2>
            <h3>Rp.<?php echo $row['price']; ?>.000</h3>
         </div>
         <div class="btn-container">
            <?php 
               if (!empty($message)) {
                  foreach ($message as $msg) {
                     echo "<p>$msg</p>";
                  }
               }
            ?>
            <form action="" method="post">
               <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
               <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
               <input type="hidden" name="product_image" value="<?php echo $row['image']; ?>">
               <input type="submit" value="Add to Cart" name="add_to_cart" class="btn">
            </form>
         </div>
      <?php else : ?>
         <p>Maaf, data kursus tidak ditemukan.</p>
      <?php endif; ?>
   </div>
   <div class="product-box product-image">
      <div class="image-container">
         <?php if(isset($row)) : ?>
            <img src="uploaded_img/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
            <p class="lifetime-access">Lifetime Access</p>
         <?php else : ?>
            <p>Gambar tidak tersedia.</p>
         <?php endif; ?>
      </div>
   </div>
</section>

<?php include 'footer.php'; ?>

<!-- Custom JS file link -->
<script src="js/script.js"></script>

</body>
</html>
