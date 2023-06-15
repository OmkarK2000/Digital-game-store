<?php
include 'config.php';

ini_set("display_errors", "1");
error_reporting(E_ALL);

session_start();

$admin_id =  $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if(isset($_POST['update_order'])){
    $order_update_id = $_POST['order_id'];
    $update_payments = $_POST['update_payments'];
    mysqli_query($conn, "UPDATE orders SET payment_status = '$update_payments' WHERE id = '$order_update_id'") or die('query failed');
    $message[] =   'payment status has been updated';
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM orders WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="admin_page.css">
    <title>orders</title>
</head>

<body>
    <?php include 'admin_header.php'; ?>

    <div class="container">
        <h1>placed orders</h1>
    </div>
    <section class="container">

        <div class="card" style="width: 10rem">
            <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM orders") or die('query failed');
            if (mysqli_num_rows($select_orders) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
            ?>
                    <div class="card" style="width:70rem">
                        <p> user id : <span><?php echo $fetch_orders['user_id']; ?></span></p>
                        <p> placed on : <span><?php echo $fetch_orders['placed_on']; ?></span></p>
                        <p> name : <span><?php echo $fetch_orders['name']; ?></span></p>
                        <p> number : <span><?php echo $fetch_orders['number']; ?></span></p>
                        <p> email : <span><?php echo $fetch_orders['email']; ?></span></p>
                        <p> address : <span><?php echo $fetch_orders['address']; ?></span></p>
                        <p> total products : <span><?php echo $fetch_orders['total_products']; ?></span></p>
                        <p> total price : <span><?php echo $fetch_orders['total_price']; ?>/-</span></p>
                        <p> payment method : <span><?php echo $fetch_orders['method']; ?></span></p>
                        
                        <form action="" method="post">
                            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                            <select name="update_payments">
                                <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
                                <option value="pending">pending</option>
                                <option value="completed">completed</option>
                            </select>
                            <input type="submit" value="update" name="update_order" class="btn btn-primary">
                            <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('delete this order?');" class="btn btn-danger">delete order</a>
                        </form>
                    </div>
            <?php
            }
            } else {
                echo "<p>no order placed yet</p>";
            }
            ?>
        </div>
    </section>


    <script src="admin_script.js"></script>
</body>

</html>