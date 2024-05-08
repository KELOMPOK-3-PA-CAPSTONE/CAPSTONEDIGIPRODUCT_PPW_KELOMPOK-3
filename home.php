<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit(); // Pastikan tidak ada output sebelum header
}

$user_id = $_SESSION['user_id'];

$message = array(); // Inisialisasi pesan

if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = 1;

    // Periksa apakah produk sudah ada dalam keranjang atau telah di-checkout
    $check_cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
    $check_order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE product_name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_query) > 0 || mysqli_num_rows($check_order_query) > 0) {
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
    <title>Home</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .card-img-top {
            height: 200px; /* Sesuaikan tinggi gambar sesuai kebutuhan */
            object-fit: cover; /* Biarkan gambar terisi penuh pada area yang diberikan */
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <section class="home">

        <div class="content">
            <h3>Siapakan dirimu menjadi wirausaha </h3>
            <p> platform terbuka bagi pemuda untuk mengembangkan keterampilan wirausaha melalui kelas berbayar yang dirancang oleh para ahli..</p>
            <a href="shop.php" class="white-btn">Daftar Sekarang</a>
        </div>

    </section>

    <section class="insight">
    <h1 class="title">Insight</h1>
        <div class="container">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card" style="width: 100%;">
                                    <img class="card-img-top" src="images/1.png" alt="Image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">Insight 1</h5>
                                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card" style="width: 100%;">
                                    <img class="card-img-top" src="images/insight.png" alt="Image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">Insight 2</h5>
                                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </section>


    <section class="products">

        <h1 class="title">Kami Menyediakan Berbagai Course</h1>

        <div class="box-container">
            <?php  
                $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE name NOT IN (SELECT name FROM cart WHERE user_id = '$user_id') AND name NOT IN (SELECT product_name FROM orders WHERE user_id = '$user_id') LIMIT 6") or die('query failed');
                if(mysqli_num_rows($select_products) > 0){
                    while($fetch_products = mysqli_fetch_assoc($select_products)){
            ?>
            <form action="" method="post" class="box">
                <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                <div class="name"><?php echo $fetch_products['name']; ?></div>
                <div class="price">Rp<?php echo $fetch_products['price']; ?>.000</div>
                <!-- Removed quantity input and added two buttons -->
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                <button type="submit" class="btn" name="add_to_cart">Add to Cart</button>
                <a href="detail.php?product_id=<?php echo $fetch_products['id']; ?>" class="btn">Show Detail</a>
            </form>
            <?php
                }
            } else {
                echo '<p class="empty">no products added yet!</p>';
            }
            ?>
        </div>

        <div class="load-more" style="margin-top: 2rem; text-align:center">
            <a href="shop.php" class="option-btn">Go to course</a>
        </div>

    </section>

    <section class="about">

        <div class="flex">

            <div class="image">
                <img src="images/home.jpeg" alt="">
            </div>

            <div class="content">
                <h3>about us</h3>
                <p>Wirainsipirasi adalah platform terbuka bagi pemuda Indonesia untuk mengembangkan keterampilan wirausaha melalui kelas berbayar yang dirancang oleh para ahli.</p>
                <a href="about.php" class="btn">read more</a>
            </div>

        </div>

    </section>

    <section class="home-contact">

        <div class="content">
            <h3>have any questions?</h3>
            <p>Jika Anda memiliki pertanyaan tentang materi kursus atau membutuhkan bantuan tambahan. Kami akan dengan senang hati membantu Anda!</p>
            <a href="contact.php" class="white-btn">contact us</a>
        </div>

    </section>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
