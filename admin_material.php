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

// Ambil nama-nama produk yang ada
$query = "SELECT DISTINCT name FROM products";
$result = mysqli_query($conn, $query);
$productNames = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $productNames[] = $row['name'];
    }
} else {
    // Handle jika query tidak mengembalikan hasil yang diharapkan
    $productNames = []; // Inisialisasi variabel $productNames sebagai array kosong
}

// Pesan kesalahan
$errors = [];

// Periksa apakah tombol submit ditekan
if (isset($_POST['add_video'])) {
    $product_name = $_POST['product_name'];

    // Detail file yang diunggah
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
                    $message = "Video berhasil diunggah.";
                } else {
                    $errors[] = "Gagal mengunggah video. Silakan coba lagi.";
                }
            } else {
                $errors[] = "Terjadi kesalahan saat mengunggah video.";
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
   <title>Admin Materi</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">
    <h1 class="title">Tambahkan Materi</h1>

    <div class="box-container">
        <div class="box">
            <h1 class="title">Upload Materi</h1>
            <div class="container">
                <?php foreach ($errors as $error) : ?>
                    <div class="error">
                        <?php echo $error; ?>
                    </div>
                <?php endforeach; ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="product_name">Pilih Produk :</label>
                        <select name="product_name" id="product_name" required>
                            <option value="" disabled selected>Pilih produk</option>
                            <?php foreach ($productNames as $productName) : ?>
                                <option value="<?php echo $productName; ?>"><?php echo $productName; ?></option>
                            <?php endforeach; ?>
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
    </div>
</section>

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
