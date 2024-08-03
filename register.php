<?php
include('config.php');

if(isset($_POST['submit'])){
    
    $name = $_POST['name'];
    $name = filter_var($name,FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email,FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $password = filter_var($password,FILTER_SANITIZE_STRING);
    $cpassword = $_POST['cpassword'];
    $cpassword = filter_var($cpassword,FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/'.$image;

    $select = $conn->prepare("SELECT * FROM users WHERE email=?" );
    $select->execute([$email]);

    if($select->rowCount()>0){
        $message[] = 'user already exist';
    }else{
        if($password != $cpassword){
            $message[] = 'confirm password does not match';
        }else{
            $insert = $conn->prepare("INSERT INTO users(name,email,password,image) VALUES(?,?,?,?)");
            $insert->execute([$name,$email,$password,$image]);

            if($insert){
                if($image_size>2000000){
                    $message[] = 'image size too large';
                }else{
                    move_uploaded_file($image_tmp_name,$image_folder);
                    header('location:login.php');
                    $message[] = 'registered successfully';
                }
            }
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- custom css file link -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Signup</h3>
            <input type="text" placeholder="enter your name" name="name" required class="box">
            <input type="email" placeholder="enter your email" name="email" required class="box">
            <input type="password" placeholder="enter your password" name="password" required class="box">
            <input type="password" placeholder="confirm your password" name="cpassword" required class="box">
            <input type="file" accept="image/png,image/jpg,image/jpeg" name="image" required class="box">
            <input type="submit" value="register now" name="submit" required class="btn">
            <p>already have an account? <a href="login.php">login now</a></p>
        </form>
    </section>
</body>
</html>