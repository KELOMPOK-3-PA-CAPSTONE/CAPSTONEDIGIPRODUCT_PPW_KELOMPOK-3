<?php
// Sertakan file konfigurasi database
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit; // Keluar dari skrip jika pengguna tidak login
}

$message = array(); // Inisialisasi pesan

if (isset($_POST['order_btn'])) {
    // Ambil data dari form
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $placed_on = date('d-M-Y');

    // Ambil semua produk dari keranjang
    $cart_total = 0;
    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if (mysqli_num_rows($cart_query) > 0) {
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $product_name = $cart_item['name'];
            $product_quantity = $cart_item['quantity'];
            $product_price = $cart_item['price'];
            $sub_total = $product_price * $product_quantity;
            $cart_total += $sub_total;

            // Simpan setiap produk sebagai pesanan terpisah
            $order_query = mysqli_query($conn, "INSERT INTO `orders` (user_id, product_name, method, city, address, total_price, placed_on) VALUES ('$user_id', '$product_name', '$method', '$city', '$address', '$sub_total', '$placed_on')") or die('query failed');
        }
    }

    // Hapus semua item dari keranjang setelah pesanan berhasil disimpan
    if ($order_query) {
        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        $message[] = 'Order placed successfully!';
    } else {
        $message[] = 'Failed to place order!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>Checkout</h3>
        <p><a href="home.php">Home</a> / Checkout</p>
    </div>

    <section class="display-order">
        <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        if (mysqli_num_rows($select_cart) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
                $grand_total += $total_price;
        ?>
                <p><?php echo $fetch_cart['name']; ?><span>(<?php echo 'Rp.' . $fetch_cart['price'] . '.000' . ' x ' . $fetch_cart['quantity']; ?>)</span></p>
        <?php
            }
        } else {
            // Tampilkan pesan ketika keranjang kosong
            echo '<p class="empty">Your cart is empty</p>';
        }
        ?>
        <div class="grand-total">Total: <span>Rp<?php echo $grand_total; ?>.000</span></div>
    </section>

    <section class="checkout">
        <?php 
        // Tampilkan formulir pesanan hanya jika keranjang tidak kosong
        if (mysqli_num_rows($select_cart) > 0) {
        ?>
        <form action="" method="post">
            <h3>Lengkapi data pemesanan</h3>
            <div class="flex">

                <div class="inputBox">
                    <span>Metode pembayaran :</span>
                    <select name="method">
                        <option value="Ewallet">E-wallet</option>
                        <option value="credit card">Credit Card</option>
                        <option value="paypal">PayPal</option>
                        <option value="Mbangking">Mbangking</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>Kota :</span>
                    <input type="text" name="city" required placeholder="Contoh: Samarinda">
                </div>
                <div class="inputBox">
                     <span>Alamat :</span>
                     <input type="text" name="address" required placeholder="Contoh: Jl. Pramuka">
                  </div>
            </div>
            <input type="submit" value="Order Now" class="btn" name="order_btn">
        </form>
        <?php } ?>
    </section>

    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>
