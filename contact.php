<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>HOYNEWS | Contact</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link rel="shortcut icon" href="img/">

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
                        <a href="category.php" class="nav-item nav-link">Category</a>
                        <a href="contact.php" class="nav-item nav-link active">Contact</a>
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

    <div class="container-fluid mt-5 pt-3 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">Contact Us</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-4 mb-3">
                        <form>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control p-4" placeholder="Your Name" required="required" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control p-4" placeholder="Your Email" required="required" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control p-4" placeholder="Subject" required="required" />
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="4" placeholder="Message" required="required"></textarea>
                            </div>
                            <div>
                                <button class="btn btn-primary font-weight-semi-bold px-4" style="height: 50px;" type="submit">Send Message</button>
                            </div>
                        </form>
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

    <!-- Template Javascript -->
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