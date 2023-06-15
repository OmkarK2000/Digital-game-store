<?php
include 'config.php';

session_start();

$admin_id =  $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM users WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_users.php');
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
    <title>users</title>
</head>

<body>
    <?php include 'admin_header.php'; ?>

    <h3 class="text-center mt-2">user accounts</h3>
    <hr>
    <section class="container">
        
        <div class="container">
            
            <?php
            $select_users = mysqli_query($conn, "SELECT * FROM users") or die('query failed');
            while ($fetch_users = mysqli_fetch_assoc($select_users)) {
            ?>
                <div class="card" style="width:20rem">
                    <p>username : <span><?php echo $fetch_users['name']; ?></span></p>
                    <p>email : <span><?php echo $fetch_users['email']; ?></span></p>
                    <p>user type : <span><?php echo $fetch_users['user_type']; ?></span></p>
                    <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="btn btn-danger">delete user</a>
                </div>
            <?php
            };
            ?>
        </div>

    </section>
    <script src="admin_script.js"></script>
</body>

</html>