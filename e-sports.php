<?php
require 'admin/functions.php';

$posts = query("SELECT posts.id, title, img, body, posts.date, author, view, category.name_category, COUNT(comment.id) AS comment_count
FROM posts
JOIN category ON posts.category_id = category.id
LEFT JOIN comment ON posts.id = comment.post_id
WHERE name_category = 'E-Sports'
GROUP BY posts.id
ORDER BY posts.date DESC");

if (isset($_POST["cari"])) {
  $keyword = $_POST["keyword"];
  $posts = cari($keyword);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>HOYNEWS | E-Sports News</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <!-- Favicon -->
  <link rel="shortcut icon" href="img/Logo2.PNG">

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">

  <!-- Libraries Stylesheet -->
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Customized Bootstrap Stylesheet -->
  <link href="css/style.css" rel="stylesheet">

  <style>
    a:hover {
      color: #fff;
    }
  </style>
</head>

<body>
  <header>
    <div class="container-fluid nav-observer">
      <div class="row align-items-center bg-primary px-lg-5">
        <div class="col-12 col-md-8">
          <div class="d-flex justify-content-between">
            <?php date_default_timezone_set("Asia/jakarta"); ?>
            <div class="d-inline-flex py-2"><span class="text-light text-uppercase" style="font-size: 18px; font-weight: bolder;"><?php echo date("l, d M Y"); ?></span></div>
          </div>
        </div>
        <div class="col-md-4 text-right d-none d-md-block text-white">
          <span id="jam"></span>
        </div>
      </div>
    </div>

    <div class="container-fluid p-0">
      <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-2 py-lg-0 px-lg-5">
        <a href="" class="navbar-brand d-none d-lg-block">
          <h1 class="m-0 display-5 text-uppercase text-light"><span class="text-primary">Hoy</span>News</h1>
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between px-0 px-lg-3" id="navbarCollapse">
          <div class="navbar-nav mr-auto py-0">
            <a href="index.php" class="nav-item nav-link" style="color: #ffffff;">Home</a>
            <a href="category.php" class="nav-item nav-link">Category</a>
            <a href="contact.php" class="nav-item nav-link">Contact</a>
          </div>
          <div class="input-group" style="width: 100%; max-width: 300px;">
            <form action="" method="POST">
              <div class="input-group-append">
                <input style="width: 260px;" type="text" name="keyword" class="form-control" placeholder="search" value="<?= isset($keyword) ? $keyword : '' ?>">
                <button type="submit" name="cari" class="input-group-text text-secondary"><i class="fa fa-search"></i></button>
              </div>
            </form>
          </div>
        </div>
      </nav>
    </div>
  </header>

  <div class="container-fluid">
    <div class="container">
      <div class="row mt-3">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-12">
              <div class="section-title">
                <h4 class="m-0 text-uppercase font-weight-bold">E-Sports News</h4>
              </div>
            </div>

            <?php if (empty($posts)) : ?>
              <h1 style="margin: auto;">Data tidak ditemukan</h1>
            <?php else : ?>
              <?php foreach ($posts as $post) :
                $text = explode(' ', $post['body']);
                $textcut = implode(' ', array_slice($text, 0, 20));
              ?>
                <div class="col-lg-4">
                  <div class="position-relative mb-3">
                    <img class="img-fluid w-100" src="img/<?= $post['img']; ?>" style="object-fit: cover; height: 250px;">
                    <div class="bg-white border border-top-0 p-4">
                      <div class="mb-2">
                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2" style="color: #ffffff;" href="category.php?id=<?= $post['name_category']; ?>"><?= $post['name_category']; ?></a>
                        <a class="text-body" href=""><small><?= date("F d, Y", strtotime($post['date'])); ?></small></a>
                      </div>
                      <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" href="single.php?id=<?= $post['id']; ?>"><?= $post['title']; ?></a>
                      <p class="m-0"><?php echo $textcut . "..." ?></p>
                    </div>
                    <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                      <div class="d-flex align-items-center">
                        <img class="rounded-circle mr-2" src="img/user.png" width="25" height="25" alt="">
                        <small><?= $post['author']; ?></small>
                      </div>
                      <div class="d-flex align-items-center">
                        <small class="ml-3"><i class="far fa-eye mr-2"></i><?= $post['view']; ?></small>
                        <small class="ml-3"><i class="far fa-comment mr-2"></i><?= $post['comment_count']; ?></small>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid py-4 px-sm-3 px-md-5" style="background: #111111;">
    <p class="m-0 text-center">&copy; <a href="#">HOYNEWS</a>. 2024.</a></p>
  </div>

  <a href="#" class="btn btn-primary btn-square back-to-top"><i class="fa fa-arrow-up"></i></a>

  <!-- JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>

  <!-- Javascript -->
  <script src="js/main.js"></script>
  <script type="text/javascript">
    window.onload = function() {
      jam();
      observer()
    }

    function jam() {
      var e = document.getElementById('jam'),
        d = new Date(),
        h, m, s;
      h = d.getHours();
      m = set(d.getMinutes());
      s = set(d.getSeconds());

      e.innerHTML = h + ':' + m + ':' + s;

      setTimeout('jam()', 1000);
    }

    function set(e) {
      e = e < 10 ? '0' + e : e;
      return e;
    }

    function observer() {
      const nav = document.querySelector(".nav-observer")
      const intersection = new IntersectionObserver((entries) => {
        const [entry] = entries

        if (entry.isIntersecting) {
          document.querySelector(".navbar").classList.remove("fixed-top")
        } else {
          document.querySelector(".navbar").classList.add("fixed-top")
        }
      }, {
        threshold: 1,
      })

      intersection.observe(nav)
    }
  </script>
</body>

</html>