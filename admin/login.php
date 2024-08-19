<?php
session_start();
require 'functions.php';

if (isset($_SESSION['username'])) {
  header("Location: index.php");
  exit;
}

if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $cek_user = mysqli_query(koneksi(), "SELECT * FROM user WHERE username = '$username' AND roles = 'admin'");

  if (mysqli_num_rows($cek_user) > 0) {
    $row = mysqli_fetch_assoc($cek_user);
    if (password_verify($password, $row['password'])) {
      $_SESSION['username'] = $_POST['username'];
      $_SESSION['hash'] = hash('sha256', $row['id_user'], false);

      if (isset($_POST['remember'])) {
        setcookie('username', $row['username'], time() + 60 * 60 * 24);
        $hash = hash('sha256', $row['id_user']);
        setcookie('hash', $hash, time() + 60 * 60 * 24);
      }

      if (hash('sha256', $row['id_user']) == $_SESSION['hash']) {
        header("Location: index.php");
        die;
      }
      header("Location: ../index.php");
      die;
    }
  }
}

if (isset($_COOKIE['username']) && isset($_COOKIE['hash'])) {
  $username = $_COOKIE['username'];
  $hash = $_COOKIE['hash'];

  $result = mysqli_query(koneksi(), "SELECT * FROM user WHERE username = '$username'");
  $row = mysqli_fetch_assoc($result);

  if ($hash === hash('sha256', $row['id_user'], false)) {
    $_SESSION['username'] = $row['username'];
    header("Location: index.php");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>HOYNEWS | Login</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <!-- Favicon -->
  <link rel="shortcut icon" href="../img/Logo2.png">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Css -->
  <link href="../css/login.css" rel="stylesheet">
</head>

<body class="body-wrapper blur" data-spy="scroll" data-target=".privacy-nav">

  <section class="user-login">
    <div class="container p-5">
      <div class="row" style="justify-content: center;">
        <div class="col-5">
          <div class="block box bg-white" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);">
            <!-- Content -->
            <div class="content text-center">
              <img src="../img/Logo.png" width="230px" alt="">
              <div class="title-text">
                <h3><b>Login</b></h3>
              </div>
              <form action="" method="post">
                <!-- <?php if (isset($errorLogin)) : ?>
                  <p style="color: red; font-style: italic;">Username atau Password salah</p>
                <?php endif; ?> -->
                <!-- Username -->
                <input class="form-control main box" type="text" id="username" name="username" placeholder="Username" required>
                <!-- Password -->
                <input class="form-control main box" type="password" id="password" name="password" placeholder="Password" required>
                <!-- Submit Button -->
                <button class="btn btn-main-sm box" type="submit" name="submit">LOGIN</button>
              </form>
              <div class="new-acount">
                <p class="text-secondary">Don't Have an account? <a href="signup.php" class="text-primary"> SIGN UP</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>