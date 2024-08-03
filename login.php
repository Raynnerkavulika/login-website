<?php
include('config.php');
session_start();

if(isset($_POST['submit'])){
   
    $email = $_POST['email'];
    $email = filter_var($email,FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $password = filter_var($password,FILTER_SANITIZE_STRING);

    $select = $conn->prepare("SELECT * FROM users WHERE email=? AND password=?" );
    $select->execute([$email,$password]);
    $row = $select->fetch(PDO::FETCH_ASSOC);

    if($select->rowCount()>0){

            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');

    }else{
        $message[] = 'user does not exist';
    }
}else{
    echo'wrong email or password';
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- custom css file link -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Login to your account</h3>
            <input type="email" placeholder="enter your email" name="email" required class="box">
            <input type="password" placeholder="enter your password" name="password" required class="box">
            <input type="submit" value="login now" name="submit" required class="btn">
            <p>don't have an account? <a href="register.php">register now</a></p>
        </form>
    </section>
</body>
</html>