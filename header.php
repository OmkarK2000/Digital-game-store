<?php 
if (isset($message)) {
    foreach ($message as $message) {
        echo ' 
            <div class="alert alert-danger mt-4" role="alert">
                <span class="DocSearch-Hit-action-button" onclick="this.parentElement.remove();">' . $message . '</span>
            </div>';
    }
}

if(isset($_POST['submit'])){
    header('location:home.php');
}
?>

<head>
    <link rel="stylesheet" href="style3.css">
</head>


<header>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><img src="logo/linkdin.png" style="width: 2rem;" alt=""></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><img src="logo/twitter.png" style="width: 2rem;" alt=""></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><img src="logo/facebook.png" style="width: 2rem;" alt=""></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><img src="logo/instagram.png" style="width: 2rem;" alt=""></a>
                    </li>
                </ul>

                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="text" name="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit" name="submit">Search</button>
                </form>
                <ul class="nav justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>





    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
        <ul class="nav justify-content-start bg-light">
        <a class="navbar-brand" href="home.php">digital game store</a>
        </ul>
            <ul class="nav justify-content-center bg-light">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">about</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="shop.php">shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="orders.php">orders</a>
                </li>
            </ul>
            <ul class="nav justify-content-end bg-light">
                <?php
                    $select_cart_number = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = '$user_id'") or die('query failed');
                    $cart_rows_number = mysqli_num_rows($select_cart_number);
                ?>
                <li>
                    <a class="nav-link" href="cart.php"><img src="logo/cart.png" style="width: 2rem;" alt="">(<?php echo $cart_rows_number ; ?>)</a>
                </li>
                <li class="nav-link">username : <span><?php echo $_SESSION['user_name']; ?> </span><br>
                email : <span><?php echo $_SESSION['user_email']; ?> </span></li>
                <li>
                    <a class="btn btn-danger" href="logout.php">logout</a>
                </li>
            </ul>



            </div>
    </nav>






</header>