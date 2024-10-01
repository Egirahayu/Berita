<?php
require 'admin/functions.php';

$id = $_GET['id'];
if (isset($_POST['add_comment'])) {
    if (add_comment($_POST) > 0) {
        header("Location: single.php?id=$id");
    } else {
        echo "<script>
            alert('Data Failed to add!');
            document.location.href = 'index.php';
          </script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Memeriksa apakah kolom komentar tidak kosong
    if (empty($_POST["add_comment"])) {
        $error_message = "Kolom komentar tidak boleh kosong.";
    }
}

$posts = query("SELECT posts.id, category_id, category.name_category, urls.id, urls.url_posts, urls.website, title, img, view, body, date, author
FROM posts 
JOIN category ON posts.category_id = category.id
JOIN urls ON posts.url_id = urls.id
WHERE posts.id = $id")[0];

tambahViews($id);

$catID = $posts['category_id'];
$relatedposts = query("SELECT posts.id, title, img, body, posts.date, author, view, category_id, category.name_category
FROM posts
JOIN category ON posts.category_id = category.id
WHERE category_id = $catID
ORDER BY date DESC
LIMIT 5");

$comments = query("SELECT id, parent_id, comment.name, comment, comment.date, post_id
FROM comment
WHERE post_id = $id AND parent_id = 0");

$coment = query("SELECT COUNT(*) FROM comment WHERE post_id = $id");
$comentCount = $coment[0]['COUNT(*)'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>HOYNEWS | Details</title>
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
        a.breadcrumb-item {
            color: #0000ff;
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
                        <a href="index.php" class="nav-item nav-link">Home</a>
                        <a href="category.php" class="nav-item nav-link">Category</a>
                        <a href="contact.php" class="nav-item nav-link">Contact</a>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <div class="container-fluid mt-5 mb-3 pt-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <nav class="breadcrumb bg-transparent m-0 p-0">
                        <a class="breadcrumb-item" href="index.php">Home</a>
                        <a class="breadcrumb-item" href="category.php">Category</a>
                        <a class="breadcrumb-item" href="<?= $posts['name_category']; ?>.php"><?= $posts['name_category']; ?></a>
                        <span class="breadcrumb-item active"><?= $posts['title']; ?></span>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="position-relative mb-3">
                        <img class="img-fluid w-100" src="img/<?= $posts['img']; ?>" style="object-fit: cover;">
                        <div class="bg-white border border-top-0 p-4">
                            <div class="mb-3">
                                <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2" href=""><?= $posts['name_category']; ?></a>
                                <a class="text-body" href=""><?= date("F d, Y", strtotime($posts['date'])); ?></a>
                            </div>
                            <p>Source: <a class="text-body" href="<?= $posts['url_posts']; ?>"><?= ucwords($posts['website']); ?></a></p>
                            <h1 class="mb-3 text-secondary text-uppercase font-weight-bold"><?= $posts['title']; ?></h1>
                            <p><?= nl2br($posts['body']); ?></p>
                        </div>
                        <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                            <div class="d-flex align-items-center">
                                <img class="rounded-circle mr-2" src="img/user.png" width=" 25" height="25" alt="">
                                <span><?= $posts['author']; ?></span>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="ml-3"><i class="far fa-eye mr-2"></i><?= $posts['view']; ?></span>
                                <span class="ml-3"><i class="far fa-comment mr-2"></i><?= $comentCount; ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Leave a comment</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-4">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="parent_id" value="0" hidden>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="date" value="<?= date('Y-m-d H:i:s'); ?>" hidden>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="post_id" value="<?= $id; ?>" hidden>
                                </div>

                                <div class="form-group">
                                    <label for="comment">Message</label>
                                    <textarea name="comment" cols="30" rows="5" class="form-control" id="comment"></textarea>
                                </div>
                                <div class="form-group mb-0">
                                    <input type="submit" value="Leave a comment" id="replyButton" name="add_comment" class="btn btn-primary font-weight-semi-bold py-2 px-3">
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class=" mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold"><?= $comentCount; ?> Comments</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-4">
                            <?php foreach ($comments as $comment) : ?>
                                <div class="media">
                                    <img src="img/user.png" alt="Image" class="img-fluid mr-3 mt-1" style="height: 75; width: 100px;">
                                    <div class="media-body">
                                        <h6><a class="text-secondary font-weight-bold" href=""><?= ucwords($comment['name']); ?></a> <small><i><?= date("d F Y H:i:s", strtotime($comment['date'])); ?></i></small></h6>
                                        <p><?= $comment['comment']; ?></p>

                                        <form action="" method="post">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="name" placeholder="Name">
                                            </div>
                                            <div class="form-group">
                                                <input type="number" class="form-control" name="parent_id" value="<?= $comment['id']; ?>" hidden>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="date" value="<?= date('Y-m-d H:i:s'); ?>" hidden>
                                            </div>
                                            <div class="form-group">
                                                <input type="number" class="form-control" name="post_id" value="<?= $id; ?>" hidden>
                                            </div>
                                            <div class="form-group">
                                                <textarea name="comment" cols="30" rows="1" class="form-control" placeholder="Comment"></textarea>
                                            </div>
                                            <button class="btn btn-sm btn-outline-secondary" type="submit" name="add_comment">Reply</button>
                                        </form>

                                        <?php
                                        $replys = query("SELECT id, parent_id, name, comment, date, post_id FROM `comment` WHERE parent_id = $comment[id];");
                                        foreach ($replys as $reply) : ?>
                                            <div class="media mt-4">
                                                <img src="img/user.png" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                                <div class="media-body">
                                                    <h6><a class="text-secondary font-weight-bold" href=""><?= ucwords($reply['name']); ?></a> <small><i><?= date("d F Y H:i:s", strtotime($reply['date'])); ?></i></i></small></h6>
                                                    <p><?= $reply['comment']; ?></p>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Related News</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-3">
                            <?php foreach ($relatedposts as $related) : ?>
                                <div class="d-flex align-items-center bg-white mb-3">
                                    <img class="img-fluid" src="img/<?= $related['img']; ?>" alt="" style="height: 75px; width: 100px;">
                                    <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                        <div class="mb-2">
                                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" style="color: #ffffff;" href=""><?= $related['name_category']; ?></a>
                                            <a class="text-body" href=""><small><?= date("F d, Y", strtotime($related['date'])); ?></small></a>
                                        </div>
                                        <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="single.php?id=<?= $related['id']; ?>"><?= $related['title']; ?></a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
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

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

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