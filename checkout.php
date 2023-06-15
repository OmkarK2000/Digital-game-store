<?php
include 'config.php';

session_start();

$user_id =  $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if(isset($_POST['order_btn'])){
    
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = $_POST['number'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn,'flat no./plot no.'. $_POST['flat'] .', '. $_POST['street'].', '.$_POST['city'].', '.$_POST['state'] .', '. $_POST['pin_code']);
    $placed_on = date('d-m-y');

    $cart_total = 0;
    $cart_products[] = '';

    $cart_query = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($cart_query) > 0){
        while($cart_item = mysqli_fetch_assoc($cart_query)){
            $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].')';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(', ',$cart_products);

    $order_query = mysqli_query($conn, "SELECT * FROM orders WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

    if($cart_total == 0){
        $message[] = 'your cart is empty';
    }else{
        if(mysqli_num_rows($order_query) > 0){
            $message[] = 'order already placed';
        }else{
            mysqli_query($conn, "INSERT INTO orders(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES ('$user_id','$name', '$number', '$email','$method','$address','$total_products','$cart_total','$placed_on')") or die('query failed');
            $message[] = 'order placed successfully!';
            mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'") or die('query failed');
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>checkout</title>
</head>

<body>

    <?php include 'header.php'; ?>

    <h1 class="text-center mt-4">checkout</h1>

    <div class="container">

        <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'") or die('query failed');
        if (mysqli_num_rows($select_cart) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
                $grand_total += $total_price;
        ?>

                <p>
                <div class="card " style="width:15rem">
                    <?php echo $fetch_cart['name']; ?> <span>(<?php echo '$' . $fetch_cart['price'] . '/-' . ' x ' .  $fetch_cart['quantity']; ?>)</span>
                </div>
                </p>

        <?php
            }
        } else {
            echo '<p>your cart is empty</p>';
        }
        ?>
        <div>
            $<?php echo 'grand total : ' . $grand_total; ?>/-
        </div>

    </div>
    <hr>

    <div class="container mt-4">
        
        <form action="#" method="post" class="form-control">
            <h3 class="text-center my-4">place your order</h3>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" required class="form-control">
            </div>
            <div class="mb-3">
                <label for="number" class="form-label">number</label>
                <input type="number" name="number" required class="form-control">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" required class="form-control" id="email" aria-describedby="emailHelp">
            </div>

            <div class="mb-3 text-center">
            <label for="method" class="form-label">payment method</label>
                <select name="method" class="form-label">
                    <option value="cash on delivery" class="form-control">cash on delivery</option>
                    <option value="debit card/credit card" class="form-control">debit card/credit card</option>
                    <option value="UPI" class="form-control">UPI</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="flat" class="form-label">flat no./plot no</label>
                <input type="number" name="flat" min="0" required class="form-control">
            </div>

            <div class="mb-3">
                <label for="street" class="form-label">street/landmark</label>
                <input type="text" name="street" required class="form-control">
            </div>

            <div class="mb-3">
                <label for="city" class="form-label">city</label>
                <input type="text" name="city" required class="form-control">
            </div>

            <div class="mb-3">
                <label for="state" class="form-label">state</label>
                <input type="text" name="state"  required class="form-control">
            </div>

            <div class="mb-3">
                <label for="pin_code" class="form-label">pin code</label>
                <input type="number" name="pin_code"  required class="form-control">
            </div>

            <div class="mb-3 text-center">
                <button type="submit" name="order_btn" class="btn btn-primary">confirm order</button>
            </div>

        </form>

    </div>


    <?php include 'footer.php' ?>
    <script src="script.js"></script>
</body>

</html>