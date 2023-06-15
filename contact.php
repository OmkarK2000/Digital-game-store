<?php
include 'config.php';
ini_set("display_errors", "1");
error_reporting(E_ALL);

session_start();

$user_id =  $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if(isset($_POST['send'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = $_POST['number'];
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    $select_message = mysqli_query($conn, "SELECT * FROM message WHERE name = '$name' AND email = '$email' AND number = '$number'  AND message = '$msg'") or die('query failed');

    if(mysqli_num_rows($select_message) > 0){
        $message[] = 'message send already ';
    }else{
        mysqli_query($conn, "INSERT INTO message(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query faield');
        $message[] = 'message send successfully';
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
    <title>contact</title>
</head>

<body>

    <?php include 'header.php'; ?>

    <h1 class="text-center mt-4 mb-4">contact us</h1>
    <div class="form-control container">
    <h3 class="text-center mt-2">say something!</h3>
    
        <form action="#" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="number" class="form-label">number</label>
                <input type="text" name="number" class="form-control" id="number">
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">message</label>
                <textarea name="message" id="" class="form-control" cols="30" rows="10"></textarea>
            </div>
            <div class="mb-3 text-center">
                <button type="submit" name="send" class="btn btn-primary">send message</button>
            </div>

        </form>

    </div>

    <?php include 'footer.php' ?>
    <script src="script.js"></script>
</body>

</html>