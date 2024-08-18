<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>HOYNEWS | Sign Up</title>
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
                <h3><b>Sign Up</b></h3>
              </div>
              <form action="" method="post">
                <!-- <?php if (isset($errorLogin)) : ?>
                  <p style="color: red; font-style: italic;">Username atau Password salah</p>
                <?php endif; ?> -->
                <!-- Username -->
                <input class="form-control main" type="text" id="username" name="username" placeholder="Username" required>
                <!-- Password -->
                <input class="form-control main" type="password" id="password" name="password" placeholder="Password" required>
                <!-- Submit Button -->
                <button class="btn btn-main-sm box" type="submit" name="submit">SIGN UP</button>
              </form>
              <div class="new-acount">
                <p class="text-secondary">Already have an account? <a href="login.php" class="text-primary">LOGIN</a></p>
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