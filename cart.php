<?php
include 'config.php';

session_start();

$user_id =  $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['update_cart'])) {
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    mysqli_query($conn, "UPDATE cart SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
    $message[] = 'cart quantity updated';
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM cart WHERE id = '$delete_id'") or die('query failed');
    header('location:cart.php');
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="cart.css">
    <title>cart</title>
</head>

<body>

    <?php include 'header.php'; ?>

    <h1 class="text-center mt-4">shopping cart</h1>

    <div class="container box">

        <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'") or die('query failed');
        if (mysqli_num_rows($select_cart) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
        ?>
                <div class="card mt-4 mb-4 box" style="width: 10rem">
                    <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" style="width: 10rem" alt="">
                    <div><?php echo $fetch_cart['name']; ?></div>
                    <div><?php echo $fetch_cart['price'] ?>/-</div>
                    <form action="" method="post">
                        <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                        <input type="number" class="form-control" style="width: 10rem;" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                        <div>total price: $<?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']);  ?></div>
                        <input type="submit" name="update_cart" value="update" class="btn btn-primary">
                        <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="btn btn-danger" onclick="return confirm('remove from cart ');">remove</a>
                    </form>
                </div>
        <?php
                $grand_total += $sub_total;
            }
        } else {
            echo '<p class="text-center">your cart is empty</p>';
        }
        ?>
    </div>

    <div class="delete d-flex align-item-center justify-content-center my-4 bg-black py-4">
        <a href="cart.php?delete_all" class="btn btn-danger" onclick="return confirm('remove all from cart ');">delete all</a>
    </div>


    <div class="d-flex  justify-content-center  align-item-center">
        <div class="d-flex flex-column">
            <p class="form-control py-3">grand total : <span>$<?php echo $grand_total; ?>/-</span></p>
            <a href="shop.php" style="width: 10rem" class="btn btn-warning my-2 <?php echo ($grand_total > 1 )? '' : 'disabled'; ?> ">continue shopping</a>
            <a href="checkout.php" style="width: 10rem" class="btn btn-primary my-2 <?php echo ($grand_total > 1 )? '' : 'disabled'; ?> ">proceed to checkout</a>
        </div>
    </div>

    <?php include 'footer.php' ?>
    <script src="script.js"></script>
</body>

</html>