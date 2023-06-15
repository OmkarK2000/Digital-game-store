<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM message WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_contact.php');
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
    <title>contacts</title>
</head>

<body>
    <?php include 'admin_header.php'; ?>

    <h3 class="text-center mt-2">messages</h3>
    <hr>
    <section class="">

        <div class="container">
            <?php
                $select_message = mysqli_query($conn, "SELECT * FROM message") or die('query failed');
                if(mysqli_num_rows($select_message) > 0){
                    while ($fetch_message = mysqli_fetch_assoc($select_message)) {
                
            ?>

                    <div class="card" style="width:20rem">
                        <p>name : <span><?php  echo $fetch_message['name']; ?></span></p>
                        <p>email : <span><?php echo $fetch_message['email']; ?></span></p>
                        <p>number : <span><?php echo $fetch_message['number']; ?></span></p>
                        <p>message : <span><?php echo $fetch_message['message'] ?></span></p>
                        <a href="admin_contact.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="btn btn-danger">delete message</a>
                    </div>

            <?php
                };
            }else{
                echo '<p class="card">you have no message</p>';
            }
            ?>
        </div>

    </section>

</body>

</html>