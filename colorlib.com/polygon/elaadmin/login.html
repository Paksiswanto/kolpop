<?php
require 'config.php';
if(!empty($_SESSION["id"])){
  header("Location: index.php");
}
if(isset($_POST["submit"])){
  $username = $_POST["username"];
  $password = $_POST["password"];
  $result = mysqli_query($conn, "SELECT * FROM tbuser WHERE username = '$username'");
  $row = mysqli_fetch_assoc($result);
  if(mysqli_num_rows($result) > 0){
    if($password == $row['password']){
      $_SESSION["login"] = true;
      $_SESSION["id"] = $row["id"];
      header("Location: index.php");
    }
    else{
      echo
      "<script> alert('Wrong Password'); </script>";
    }
  }
  else{
    echo
    "<script> alert('User Not Registered'); </script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
  </head>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    body{
    height: 100vh;
    background-image: url(assets/images/blue_lockbackground.gif);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
  </style>

  <body>
    <div class="wrapper">
    <h2>Login</h2>
    <form action="" method="post" autocomplete="off">
      <div class="input-box">
        <input type="text" name="username" id = "username" placeholder="Enter your Username" required value="">
      </div>
     
      <div class="input-box">
        <input type="password" name="password" id = "password" placeholder="Create password" required value="">
      </div>
     
      <div class="input-box button">
        <input type="Submit" name="submit" value="Login now">
      </div>
      <div class="text">
        <h3>Belum punya akun? <a href="registrasi.php">register now</a></h3>
      </div>
    </form>
  </div>
</body>
</html>