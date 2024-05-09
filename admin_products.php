<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

$message = array();

if (isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $tujuan = mysqli_real_escape_string($conn, $_POST['tujuan']);
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

    $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

    if (mysqli_num_rows($select_product_name) > 0) {
        $message[] = 'Nama produk sudah ada';
    } else {
        if ($price > 200000) {
            $message[] = 'Harga produk tidak boleh melebihi Rp200.000';
        } else {
            $add_product_query = mysqli_query($conn, "INSERT INTO `products`(name, price, deskripsi, tujuan, image) VALUES('$name', '$price', '$deskripsi', '$tujuan', '$image')") or die('query failed');

            if ($add_product_query) {
                if ($image_size > 2000000) {
                    $message[] = 'Ukuran gambar terlalu besar';
                } else {
                    move_uploaded_file($image_tmp_name, $image_folder);
                    $message[] = 'Produk berhasil ditambahkan!';
                }
            } else {
                $message[] = 'Produk tidak bisa ditambahkan!';
            }
        }
    }
}

if (isset($_POST['delete_product'])) {
    $delete_id = $_POST['delete_id'];
    $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
    unlink('uploaded_img/' . $fetch_delete_image['image']);
    mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_products.php');
}

if (isset($_POST['update_product'])) {
    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_price = $_POST['update_price'];
    $update_deskripsi = mysqli_real_escape_string($conn, $_POST['update_deskripsi']);
    $update_tujuan = mysqli_real_escape_string($conn, $_POST['update_tujuan']);

    mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price = '$update_price', deskripsi = '$update_deskripsi', tujuan = '$update_tujuan' WHERE id = '$update_p_id'") or die('query failed');

    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = 'uploaded_img/' . $update_image;
    $update_old_image = $_POST['update_old_image'];

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = 'Ukuran file gambar terlalu besar';
        } else {
            mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
            move_uploaded_file($update_image_tmp_name, $update_folder);
            unlink('uploaded_img/' . $update_old_image);
        }
    }

    header('location:admin_products.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link -->
    <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

    <?php include 'admin_header.php'; ?>

    <!-- bagian CRUD produk dimulai -->

    <section class="add-products">

        <h1 class="title">Produk Toko</h1>

        <?php
        if (!empty($message)) {
            echo '<div class="message">';
            foreach ($message as $msg) {
                echo '<p>' . $msg . '</p>';
            }
            echo '</div>';
        }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <h3>Tambah Produk</h3>
            <input type="text" name="name" class="box" placeholder="Masukkan Nama Produk" required>
            <input type="text" name="price" class="box" value=".000" required>
            <textarea name="deskripsi" class="box" placeholder="Masukkan Deskripsi Produk" required></textarea>
            <textarea name="tujuan" class="box" placeholder="Masukkan Tujuan Produk" required></textarea>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
            <input type="submit" value="Tambah Produk" name="add_product" class="btn">
        </form>

    </section>

    <!-- tampilkan produk -->

    <section class="show-products">

        <div class="box-container">

            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
                    <div class="box">
                        <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                        <div class="name"><?php echo $fetch_products['name']; ?></div>
                        <div class="price">Rp<?php echo $fetch_products['price']; ?>.000</div>
                        <form action="" method="post">
                            <input type="hidden" name="delete_id" value="<?php echo $fetch_products['id']; ?>">
                            <button type="submit" name="delete_product" class="delete-btn" onclick="return confirm('Hapus produk ini?');">Hapus</button>
                        </form>
                        <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">Update</a>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">Belum ada produk ditambahkan!</p>';
            }
            ?>
        </div>

    </section>

    <section class="edit-product-form">

        <?php
        if (isset($_GET['update'])) {
            $update_id = $_GET['update'];
            $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('query failed');
            if (mysqli_num_rows($update_query) > 0) {
                while ($fetch_update = mysqli_fetch_assoc($update_query)) {
        ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
                        <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
                        <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
                        <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="Masukkan Nama Produk">
                        <input type="text" name="update_price" value="<?php echo $fetch_update['price']; ?>" class="box" placeholder="Masukkan Harga Produk" required>
                        <textarea name="update_deskripsi" class="box" required placeholder="Masukkan Deskripsi Produk"><?php echo $fetch_update['deskripsi']; ?></textarea>
                        <textarea name="update_tujuan" class="box" required placeholder="Masukkan Tujuan Produk"><?php echo $fetch_update['tujuan']; ?></textarea>
                        <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
                        <input type="submit" value="Update" name="update_product" class="btn">
                        <input type="reset" value="Batal" id="close-update" class="option-btn">
                    </form>
        <?php
                }
            }
        } else {
            echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
        }
        ?>

    </section>

    <!-- custom admin js file link -->
    <script src="js/admin_script.js"></script>

</body>

</html>
