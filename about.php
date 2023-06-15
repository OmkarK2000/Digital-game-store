<?php
    include 'config.php';

    session_start();

    $user_id =  $_SESSION['user_id'];

    if(!isset($user_id)){
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
    <title>about</title>
</head>
<body>
    
    <?php include 'header.php'; ?>

    <div class="container text-center mt-4">
    <h1 class="text-center mt-4">about us</h1>
        <img src="images/about-img.jpg" alt="">
        <div class="my-auto">
        <h3>why choose us?</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores facere voluptas, temporibus quas molestias qui cumque repudiandae iste asperiores cum nihil molestiae ea a consequuntur?</p>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptas totam delectus, sed possimus aliquam, error dignissimos, eius fuga vel modi ipsam repellat? Tenetur ratione dignissimos iusto vitae quas maxime aspernatur!</p>
        <a href="contact.php" class="btn btn-primary">contact us</a>
        </div>
    </div>

    <?php include 'footer.php' ?>
    <script src="script.js"></script>
</body>
</html>