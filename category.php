<?php
require 'admin/functions.php';

$sports = query("SELECT posts.id, title, img, body, posts.date, author, view, category.name_category, COUNT(comment.id) AS comment_count
FROM posts
JOIN category ON posts.category_id = category.id
LEFT JOIN comment ON posts.id = comment.post_id
WHERE name_category = 'Sports'
GROUP BY posts.id
ORDER BY posts.date DESC
LIMIT 2");

$esports = query("SELECT posts.id, title, img, body, posts.date, author, view, category.name_category, COUNT(comment.id) AS comment_count
FROM posts
JOIN category ON posts.category_id = category.id
LEFT JOIN comment ON posts.id = comment.post_id
WHERE name_category = 'E-Sports'
GROUP BY posts.id
ORDER BY posts.date DESC
LIMIT 2");

$politics = query("SELECT posts.id, title, img, body, posts.date, author, view, category.name_category, COUNT(comment.id) AS comment_count
FROM posts
JOIN category ON posts.category_id = category.id
LEFT JOIN comment ON posts.id = comment.post_id
WHERE name_category = 'Politics'
GROUP BY posts.id
ORDER BY posts.date DESC
LIMIT 2");

$technology = query("SELECT posts.id, title, img, body, posts.date, author, view, category.name_category, COUNT(comment.id) AS comment_count
FROM posts
JOIN category ON posts.category_id = category.id
LEFT JOIN comment ON posts.id = comment.post_id
WHERE name_category = 'Technology'
GROUP BY posts.id
ORDER BY posts.date DESC
LIMIT 2");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>HOYNEWS | Category</title>
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
                        <a href="category.php" class="nav-item nav-link active">Category</a>
                        <a href="contact.php" class="nav-item nav-link">Contact</a>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <div class="container-fluid mt-5 pt-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title">
                                <h4 class="m-0 text-uppercase font-weight-bold">Category: Sports</h4>
                                <a class="text-secondary font-weight-medium text-decoration-none" href="sports.php">View All</a>
                            </div>
                        </div>

                        <?php foreach ($sports as $sport) :
                            $text = explode(' ', $sport['body']);
                            $textcut = implode(' ', array_slice($text, 0, 20));
                        ?>
                            <div class="col-lg-6">
                                <div class="position-relative mb-3">
                                    <img class="img-fluid w-100" src="img/<?= $sport['img']; ?>" style="object-fit: cover;">
                                    <div class="bg-white border border-top-0 p-4">
                                        <div class="mb-2">
                                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2" href="<?= $sport['name_category']; ?>.php"><?= $sport['name_category']; ?></a>
                                            <a class="text-body" href=""><small><?= date("F d, Y", strtotime($sport['date'])); ?></small></a>
                                        </div>
                                        <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" href="single.php?id=<?= $sport['id']; ?>"><?= $sport['title']; ?></a>
                                        <p class="m-0"><?= $textcut; ?></p>
                                    </div>
                                    <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle mr-2" src="img/user.png" width="25" height="25" alt="">
                                            <small><?= $sport['author']; ?></small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <small class="ml-3"><i class="far fa-eye mr-2"></i><?= $sport['view']; ?></small>
                                            <small class="ml-3"><i class="far fa-comment mr-2"></i><?= $sport['comment_count']; ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title">
                                <h4 class="m-0 text-uppercase font-weight-bold">Category: E-Sports</h4>
                                <a class="text-secondary font-weight-medium text-decoration-none" href="e-sports.php">View All</a>
                            </div>
                        </div>

                        <?php foreach ($esports as $esport) :
                            $text = explode(' ', $esport['body']);
                            $textcut = implode(' ', array_slice($text, 0, 20));
                        ?>
                            <div class="col-lg-6">
                                <div class="position-relative mb-3">
                                    <img class="img-fluid w-100" src="img/<?= $esport['img']; ?>" style="object-fit: cover;">
                                    <div class="bg-white border border-top-0 p-4">
                                        <div class="mb-2">
                                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2" href="<?= $esport['name_category']; ?>.php"><?= $esport['name_category']; ?></a>
                                            <a class="text-body" href=""><small><?= date("F d, Y", strtotime($esport['date'])); ?></small></a>
                                        </div>
                                        <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" href="single.php?id=<?= $esport['id']; ?>"><?= $esport['title']; ?></a>
                                        <p class="m-0"><?= $textcut; ?></p>
                                    </div>
                                    <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle mr-2" src="img/user.png" width="25" height="25" alt="">
                                            <small><?= $esport['author']; ?></small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <small class="ml-3"><i class="far fa-eye mr-2"></i><?= $esport['view']; ?></small>
                                            <small class="ml-3"><i class="far fa-comment mr-2"></i><?= $esport['comment_count']; ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title">
                                <h4 class="m-0 text-uppercase font-weight-bold">Category: Politics</h4>
                                <a class="text-secondary font-weight-medium text-decoration-none" href="politics.php">View All</a>
                            </div>
                        </div>

                        <?php foreach ($politics as $politic) :
                            $text = explode(' ', $politic['body']);
                            $textcut = implode(' ', array_slice($text, 0, 20));
                        ?>
                            <div class="col-lg-6">
                                <div class="position-relative mb-3">
                                    <img class="img-fluid w-100" src="img/<?= $politic['img']; ?>" style="object-fit: cover;">
                                    <div class="bg-white border border-top-0 p-4">
                                        <div class="mb-2">
                                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2" href="<?= $politic['name_category']; ?>.php"><?= $politic['name_category']; ?></a>
                                            <a class="text-body" href=""><small><?= date("F d, Y", strtotime($politic['date'])); ?></small></a>
                                        </div>
                                        <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" href="single.php?id=<?= $politic['id']; ?>"><?= $politic['title']; ?></a>
                                        <p class="m-0"><?= $textcut; ?></p>
                                    </div>
                                    <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle mr-2" src="img/user.png" width="25" height="25" alt="">
                                            <small><?= $politic['author']; ?></small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <small class="ml-3"><i class="far fa-eye mr-2"></i><?= $politic['view']; ?></small>
                                            <small class="ml-3"><i class="far fa-comment mr-2"></i><?= $politic['comment_count']; ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title">
                                <h4 class="m-0 text-uppercase font-weight-bold">Category: Technology</h4>
                                <a class="text-secondary font-weight-medium text-decoration-none" href="technology.php">View All</a>
                            </div>
                        </div>

                        <?php foreach ($technology as $techno) :
                            $text = explode(' ', $techno['body']);
                            $textcut = implode(' ', array_slice($text, 0, 20));
                        ?>
                            <div class="col-lg-6">
                                <div class="position-relative mb-3">
                                    <img class="img-fluid w-100" src="img/<?= $techno['img']; ?>" style="object-fit: cover;">
                                    <div class="bg-white border border-top-0 p-4">
                                        <div class="mb-2">
                                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2" href="<?= $techno['name_category']; ?>.php"><?= $techno['name_category']; ?></a>
                                            <a class="text-body" href=""><small><?= date("F d, Y", strtotime($techno['date'])); ?></small></a>
                                        </div>
                                        <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" href="single.php?id=<?= $techno['id']; ?>"><?= $techno['title']; ?></a>
                                        <p class="m-0"><?= $textcut; ?></p>
                                    </div>
                                    <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle mr-2" src="img/user.png" width="25" height="25" alt="">
                                            <small><?= $techno['author']; ?></small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <small class="ml-3"><i class="far fa-eye mr-2"></i><?= $techno['view']; ?></small>
                                            <small class="ml-3"><i class="far fa-comment mr-2"></i><?= $techno['comment_count']; ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
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