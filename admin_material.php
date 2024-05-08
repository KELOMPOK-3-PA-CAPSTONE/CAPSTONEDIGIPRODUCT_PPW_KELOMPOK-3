<?php
// Sertakan file konfigurasi database
include 'config.php';

// Mulai sesi
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['admin_id'])) {
    header('location: login.php');
    exit;
}

// Pesan kesalahan
$errors = [];
$success_message = "";

// Periksa apakah tombol submit untuk menambahkan materi ditekan
if (isset($_POST['add_video'])) {
    // Detail materi yang dimasukkan
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);

    // Detail file video yang diunggah
    $video_name = $_FILES['video']['name'];
    $video_tmp = $_FILES['video']['tmp_name'];
    $video_size = $_FILES['video']['size'];
    $video_type = $_FILES['video']['type'];

    // Lokasi folder untuk menyimpan video yang diunggah
    $target_directory = "uploaded_videos/";

    // Ubah nama file video sesuai dengan nama produk
    $video_extension = strtolower(pathinfo($video_name, PATHINFO_EXTENSION));
    $video_file = "uploaded_videos/" . strtolower(str_replace(' ', '_', $product_name)) . '.' . $video_extension;

    // Tentukan path lengkap untuk file yang akan diunggah
    $target_file = $target_directory . basename($video_file);

    // Periksa apakah file yang diunggah adalah file video
    $allowed_types = array('mp4', 'avi', 'mov', 'mpeg', 'mkv');
    $video_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (!in_array($video_extension, $allowed_types)) {
        $errors[] = "Hanya file video dengan format MP4, AVI, MOV, MPEG, dan MKV yang diizinkan.";
    } else {
        // Periksa ukuran file
        if ($video_size > 50000000) {
            $errors[] = "Ukuran file video terlalu besar. Harus kurang dari 50MB.";
        } else {
            // Pindahkan file ke folder yang ditentukan
            if (move_uploaded_file($video_tmp, $target_file)) {
                // Query untuk menyimpan nama file video ke kolom lesson_video di tabel products
                $query = "UPDATE `products` SET `lesson_video` = '$video_file' WHERE `name` = '$product_name'";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    $success_message = "Video berhasil diunggah untuk produk '$product_name'.";
                } else {
                    $errors[] = "Gagal mengunggah video. Silakan coba lagi.";
                }
            } else {
                $errors[] = "Terjadi kesalahan saat mengunggah video.";
            }
        }
    }
}

// Periksa apakah tombol submit untuk menambahkan link komunitas ditekan
if (isset($_POST['add_community_link'])) {
    // Detail link komunitas yang dimasukkan
    $community_link = mysqli_real_escape_string($conn, $_POST['community_link']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);

    // Validasi link komunitas
    if (empty($community_link)) {
        $errors[] = "Link komunitas harus diisi.";
    } else {
        // Masukkan link komunitas ke dalam database
        $insertQuery = "UPDATE products SET link = '$community_link' WHERE name = '$product_name'";
        $result = mysqli_query($conn, $insertQuery);
        if ($result) {
            $success_message = "Link komunitas berhasil ditambahkan untuk produk '$product_name'.";
        } else {
            $errors[] = "Gagal menambahkan link komunitas. Silakan coba lagi.";
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
   <title>Admin Materi</title>

   <!-- Font Awesome CDN link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom admin CSS file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">
    <h1 class="title">Tambahkan Materi dan Link Komunitas</h1>

    <div class="box-container">
        <!-- Kotak untuk menambahkan materi -->
        <div class="box">
            <h1 class="title">Upload Materi</h1>
            <div class="container">
                <?php foreach ($errors as $error) : ?>
                    <div class="error">
                        <?php echo $error; ?>
                    </div>
                <?php endforeach; ?>
                <?php if ($success_message != "") : ?>
                    <div class="success"><?php echo $success_message; ?></div>
                <?php endif; ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="product_name">Pilih Produk :</label>
                        <select name="product_name" id="product_name" required>
                            <option value="" disabled selected>Pilih produk</option>
                            <?php
                            $query = "SELECT name FROM products";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="video">Choose Video:</label>
                        <input type="file" name="video" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="add_video" class="btn">Upload Video</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Kotak untuk menambahkan link komunitas -->
        <div class="box">
            <h1 class="title">Tambahkan Link Komunitas</h1>
            <div class="container">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="product_name">Pilih Produk :</label>
                        <select name="product_name" id="product_name" required>
                            <option value="" disabled selected>Pilih produk</option>
                            <?php
                            $query = "SELECT name FROM products";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="community_link">Link Komunitas:</label>
                        <input type="text" name="community_link" placeholder="Enter Community Link" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="add_community_link" class="btn">Tambah Link Komunitas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
