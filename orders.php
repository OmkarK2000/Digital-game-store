<?php
include 'config.php';

session_start();

$user_id =  $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>orders</title>
</head>

<body>

    <?php include 'header.php'; ?>

    <h1 class="text-center mt-4">placed orders</h1>

    <div class="container">

        <?php
        $order_query = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = '$user_id'") or die('query failed');
        if (mysqli_num_rows($order_query) > 0) {
            while ($fetch_order = mysqli_fetch_assoc($order_query)) {
        ?>
        <div class="card py-2 px-2 mt-4" style="width: 25rem">

        <p>placed on : <span><?php echo $fetch_order['placed_on'] ?> </span></p>
        <p>name : <span><?php echo $fetch_order['name'] ?> </span></p>
        <p>number : <span><?php echo $fetch_order['number'] ?> </span></p>
        <p>email : <span><?php echo $fetch_order['email'] ?> </span></p>
        <p>address : <span><?php echo $fetch_order['address'] ?> </span></p>
        <p>payment method : <span><?php echo $fetch_order['method'] ?> </span></p>
        <p>your orders : <span><?php echo $fetch_order['total_products'] ?></span></p>
        <p>total price : <span>$<?php echo $fetch_order['total_price'] ?>/-</span></p>
        <p>payment status : <span style="color: <?php if($fetch_order['payment_status'] == 'pending'){echo 'red';}else{echo 'green';} ?>;"><?php echo $fetch_order['payment_status'] ?> </span></p>

        </div>
        <?php
            }
        }
        ?>

    </div>


    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
</body>

</html>