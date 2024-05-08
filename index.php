<?php
include 'config.php';

// Session start dan user_id diinisialisasi dengan nilai default null
session_start();
$user_id = null;

// Periksa apakah session 'user_id' telah di-set
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
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

    <header class="header">
        <div class="header-1">

            <div class="flex">
                <div class="share">
                    <a href="#" class="fab fa-facebook-f"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                </div>

                <p> <a href="login.php">login</a> | <a href="register.php">register</a> </p>

            </div>
        </div>
    </header>

    <section class="home">

        <div class="content">
            <h3>Siapakan Dirimu menjadi wirausaha</h3>
            <p> platform terbuka bagi pemuda Indonesia untuk mengembangkan keterampilan wirausaha melalui kelas berbayar yang dirancang oleh para ahli..</p>
            <a href="register.php" class="white-btn">Daftar Sekarang</a>
        </div>

    </section>

    <section class="insight">
        <h1 class="title">Insight</h1>
        <div class="container">
            <div id="carouselInsight" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselInsight" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselInsight" data-slide-to="1"></li>
                </ol>
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
                <a class="carousel-control-prev" href="#carouselInsight" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselInsight" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </section>

    <section class="products">

        <h1 class="title">Kelas Yang tersedia</h1>

        <div class="box-container">

            <?php
            // Sesuaikan query untuk mendapatkan produk dari database
            $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
                    <form action="" method="post" class="box">
                        <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                        <div class="name"><?php echo $fetch_products['name']; ?></div>
                        <div class="price">Rp<?php echo $fetch_products['price']; ?>.000</div>
                        <!-- Menghilangkan input hidden untuk user_id -->
                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                        <?php if (!$user_id) : ?>
                            <a href="register.php" class="btn">Daftar Sekarang</a>
                        <?php else : ?>
                            <input type="submit" value="Daftar Sekarang" name="add_to_cart" class="btn">
                        <?php endif; ?>
                    </form>

            <?php
                }
            } else {
                echo '<p class="empty">no products added yet!</p>';
            }
            ?>
        </div>

        <div class="load-more" style="margin-top: 2rem; text-align:center">
            <a href="login.php" class="option-btn">Daftar Sekarang</a>
        </div>

    </section>

    <section class="about">

        <div class="flex">

            <div class="image">
                <img src="images/home.jpeg" alt="">
            </div>

            <div class="content">
                <h3>about us</h3>
                <p>WiraInspirasi dapat diakses seluruh Indonesia dengan fokus pada pemuda dalam meningkatkan semangat berwirausaha.</p>
            </div>

        </div>

    </section>

    <section class="home-contact">

        <div class="content">
            <h3>Frequently Asked Questions</h3>
            <p><strong>What is included in class Wirainsipirasi?</strong></p>
            <p>Our class Wirainsipirasi includes comprehensive lessons covering various topics such as creativity, problem-solving, communication, and leadership. You'll have access to engaging video lectures, interactive quizzes, practical exercises, and downloadable resources to enhance your learning experience.</p>
        </div>

    </section>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>
