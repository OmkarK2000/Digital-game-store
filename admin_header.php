<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo ' 
            <div class="alert alert-danger mt-4" role="alert">
                <span class="DocSearch-Hit-action-button" onclick="this.parentElement.remove();">' . $message . '</span>
            </div>';
    }
}
?>

<head>
    <link rel="stylesheet" href="style3.css">
</head>
<header>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_page.php">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="admin_page.php">home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_products.php">products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_orders.php">orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_users.php">users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_contact.php">messages</a>
                    </li>
                </ul>
            </div>
            <div>
                <p>username : <span><?php echo $_SESSION['admin_name']; ?> </span></p>
                <p>email : <span><?php echo $_SESSION['admin_email']; ?> </span></p>
            </div>
            <div><a href="logout.php" class="btn btn-danger">logout</a></div>
        </div>
    </nav>

    <div>
        <div></div>
        <div></div>
    </div>



</header>