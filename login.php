<?php
include 'config.php';
session_start();
if (isset($_POST['submit'])) {
    
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);
    
    $sql = "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'";

    $select_user = mysqli_query($conn, $sql) or die('query failed');


    if (mysqli_num_rows($select_user) > 0) {
        $row = mysqli_fetch_assoc($select_user);

        if($row['user_type'] == 'admin'){
            
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];
            header('location:admin_page.php');
            
        }elseif($row['user_type'] = 'user'){
            
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');

        }
    } else {
       $message[] = 'incorrect email or password!';
    }
    // echo $name, $email, $pass, $cpass;
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <title>Login</title>
</head>

<body>
    <div class="container">



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

        <h2 class="form-label mt-4 text-center">Login here</h2>
        <form action="#" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password">
            </div>

            <div class="mb-3 text-center">
                <button type="submit" name="submit" class="btn btn-primary">Login now</button>
                <p class="form-label">don't have an account? <a href="register.php">Register now</a></p>
            </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>