<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = 1;

    // Periksa apakah produk sudah ada dalam keranjang atau telah di-checkout
    $check_product_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
    $check_order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE product_name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_product_query) > 0 || mysqli_num_rows($check_order_query) > 0) {
        $message[] = 'Product already added or checked out!';
    } else {
        mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'Product added to cart!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelas</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>Kelas Wirainsipirasi</h3>
        <p> <a href="home.php">Beranda</a> / Kelas </p>
    </div>

    <section class="products">

        <h1 class="title">Kelas Yang Tersedia</h1>

        <div class="box-container">

            <?php
            // Mengambil produk yang belum ada di keranjang atau belum di-checkout
            $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE name NOT IN (SELECT name FROM cart WHERE user_id = '$user_id') AND name NOT IN (SELECT product_name FROM orders WHERE user_id = '$user_id')") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
                    <form action="" method="post" class="box">
                        <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                        <div class="name"><?php echo $fetch_products['name']; ?></div>
                        <div class="price">Rp.<?php echo $fetch_products['price']; ?>.000</div>
                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                        <input type="submit" value="Add to Cart" name="add_to_cart" class="btn">
                        <a href="detail.php?product_id=<?php echo $fetch_products['id']; ?>" class="btn">Show Detail</a>
                    </form>
            <?php
                }
            } else {
                echo '<p class="empty">Tidak ada kelas yang tersedia</p>';
            }
            ?>
        </div>

    </section>

    <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>
