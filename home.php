<?php
include 'config.php';

ini_set("display_errors", "1");
error_reporting(E_ALL);

session_start();

$user_id =  $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM cart WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'already added to cart';
    } else {
        mysqli_query($conn, "INSERT INTO cart(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name','$product_price','$product_quantity','$product_image')") or die('query failed');
        $message[] = 'product added to cart';
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
    <link rel="stylesheet" href="style6.css">
    <title>home</title>
</head>

<body>

    <?php include 'header.php'; ?>

    <section class=" main">
        <div class="home mt-4 bg-light text-center">
            <h3>letest tripe a titles</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea, necessitatibus? </p>
            <a href="about.php" class="btn btn-primary">discover more</a>
        </div>
    </section class>
    <hr>

    <h1 class="text-center  mt-4">letest games</h1>
    <section>
    <div class="d-flex  mt-4">

        <?php
        $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
        if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
        ?>
                <form action="" method="post">
                    <div class="card mt-4 mx-3  " style="width: 12rem">
                        <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                        <div><?php echo $fetch_products['name']; ?></div>
                        <div><?php echo $fetch_products['price']; ?></div>
                        <input class="form-control" type="number" name="product_quantity" min="1" value="1">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                        <input type="submit" value="add to cart" name="add_to_cart" class="btn btn-primary">
                    </div>
                </form>
                <?php
            }
        } else {
            echo '<p class="empty">no games added yet!</p>';
        }
        ?>
    </div>
    <div class="container d-flex justify-content-center">
        <a href="shop.php" class="btn btn-danger  mt-4 ">load more</a>
    </div>

    </section>
    <hr>

    <div class="container d-flex text-center mt-4">
        <img src="images/about.jpeg" alt="">
        <div class="my-auto">
        <h3>about us</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores facere voluptas, temporibus quas molestias qui cumque repudiandae iste asperiores cum nihil molestiae ea a consequuntur?</p>
        <a href="about.php" class="btn btn-primary">read more</a>
        </div>
    </div>

<hr>
    <div class=" bg-black d-flex text-center mb-4 mt-4">
        <div class="bg-black text-white mt-4 mb-4">
        <h3>have any questions?</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores facere voluptas, temporibus quas molestias qui cumque repudiandae iste asperiores cum nihil molestiae ea a consequuntur?</p>
        <a href="contact.php" class="btn btn-primary">contact us</a>
        </div>
    </div>

    <?php include 'footer.php' ?>
    <script src="script.js"></script>
</body>

</html>