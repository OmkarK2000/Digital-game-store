<?php
include 'config.php';

ini_set("display_errors", "1");
error_reporting(E_ALL);


session_start();

$admin_id =  $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
};

if (isset($_POST['add_product'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

    $select_product_name = mysqli_query($conn, "SELECT name FROM products WHERE name = '$name'") or die('query failed');

    if (mysqli_num_rows($select_product_name) > 0) {
        $message[] = 'product name already added';
    } else {
        $add_product_query = mysqli_query($conn, "INSERT INTO products (name, price, image) VALUES('$name','$price','$image')") or die('query failed');

        if ($add_product_query) {
            if ($image_size > 2000000) {
                $message[] = 'image size is too large';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'product added successfully!';
            }
        } else {
            $message[] = 'product could not be added!';
        }
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_image_query = mysqli_query($conn, "SELECT image FROM products WHERE id = '$delete_id'") or die('query failed');
    $fetech_delete_image = mysqli_fetch_assoc($delete_image_query);
    unlink('uploaded_img/'.$fetech_delete_image['image']);
    mysqli_query($conn, "DELETE FROM products WHERE id = '$delete_id'") or die("query failed");
    header('location:admin_products.php');
}

if(isset($_POST['update_product'])){
    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_price = $_POST['update_price'];

    mysqli_query($conn, "UPDATE products SET name = '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die('query failed');

    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = 'uploaded_img/'.$update_image;
    $update_old_image = $_POST['update_old_image'];

    if(!empty($update_image)){
        if($update_image_size > 2000000){
            $message[] = 'image file size is too large';
        }else{
            mysqli_query($conn, "UPDATE products SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
            move_uploaded_file($update_image_tmp_name, $update_folder);
            unlink('uploaded_img/'.$update_old_image);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="admin_page.css">
    <title>products</title>
</head>

<body>
    <?php include 'admin_header.php'; ?>

    <section class="container text-center">


        <form action="" method="post" enctype="multipart/form-data">
            <h1 class="heading">products</h1>

            <h3>add game</h3>
            <input type="text" name="name" class="form-control mt-4" placeholder="enter game name" required>
            <input type="number" name="price" min="0" class=" form-control mt-2" placeholder="enter game price" required>
            <input type="file" name="image" class="form-control mt-2" accept="image/jpg, image/jpeg, image/png, image/webp" required>

            <input type="submit" class="btn btn-primary mt-2" value="add products" name="add_product">

        </form>

    </section>

    <hr>
    <div class="container mt-4">

        <?php
        $select_products = mysqli_query($conn, "SELECT * FROM products") or die("query failed");
        if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
        ?>

                <div class="card" style="width: 12rem">
                    <img src="uploaded_img/<?php echo $fetch_products['image']; ?>"  alt="">
                    <div><?php echo $fetch_products['name']; ?></div>
                    <div>$<?php echo $fetch_products['price']; ?>/-</div>
                    <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="btn btn-primary">update</a>
                    <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="btn btn-danger" onclick="return confirm('delete this product?')">delete</a>
                </div>

        <?php
            }
        } else {
            echo '<p>no game added yet!</p>';
        }
        ?>
    </div>

    <hr>

    <div class="edit-update container">

        <?php
        if (isset($_GET['update'])) {
            $update_id = $_GET['update'];
            $update_query = mysqli_query($conn, "SELECT * FROM products WHERE id= '$update_id'") or die("query failed");
            if (mysqli_num_rows($update_query) > 0) {
                while ($fetch_update = mysqli_fetch_assoc($update_query)) {
        ?>

            <div class="card container text-center form" style="width:30rem">
                <form action="" method="post" enctype="multipart/form-data">
                    <h3 class="text-center mt-2">Edit here</h3>
                    <input type="hidden" class="mt-2" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
                    <input type="hidden" class="mt-2" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
                    <img class="card mt-2" style="width: 10rem" src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
                    <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="form-control mt-2" required placeholder="enter product name">
                    <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" class="form-control mt-2" required min="0" placeholder="enter product price">
                    <input type="file" name="update_image" class="form-control mt-2" accept="image/jpg, image/jpeg, image/png">
                    <input type="submit" value="update" name="update_product" class="btn btn-primary mt-2">
                    <input type="reset" value="cancel" id="close-update" class="btn btn-warning mt-2">
                </form>
            </div>

        <?php
                }
            }
        } else {
            echo "<script>document.querySelector('.edit-update').style.display = 'none';</script>";
        }
        ?>

    </div>


    <script src="admin_script.js"></script>
</body>

</html>