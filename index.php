<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS - Home</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="icon" href="assets/logo/logo.png">
    <style>
        body.body-home {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", sans-serif;
        }

        /* Dark overlay (keeps your design) */
        .black-fill {
            min-height: 100vh;
            background: rgba(0, 0, 0, 0.65);
        }

        /* Container spacing */
        .container {
            padding-top: 20px;
        }

        /* ================= NAVBAR ================= */
        #homeNav {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            padding: 10px 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
        }

        #homeNav .nav-link {
            font-weight: 500;
            color: #333;
            transition: 0.3s;
        }

        #homeNav .nav-link:hover {
            color: #0d6efd;
        }

        /* ================= HOME SECTION ================= */
        .home-section {
            margin-top: 60px;
            text-align: center;
            color: #fff;
        }

        .home-section img {
            margin-bottom: 15px;
            filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.4));
        }

        .home-section h1 {
            font-size: 42px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .home-section p {
            font-size: 18px;
            opacity: 0.9;
        }

        /* ================= CARDS ================= */
        .card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            transition: 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        /* About card */
        .card-1 {
            width: 80%;
            margin-top: 50px;
            background: #fff;
        }

        .card-1 .card-title {
            font-size: 22px;
            font-weight: 700;
        }

        /* Contact card */
        .card-2 {
            width: 80%;
            margin-top: 60px;
            padding: 25px;
            background: #fff;
        }

        .card-2 h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #333;
        }

        /* ================= FORM ================= */
        .form-label {
            font-weight: 600;
            font-size: 14px;
            color: #444;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 10px rgba(13, 110, 253, 0.2);
        }

        /* Button */
        .btn-primary {
            width: 120px;
            border-radius: 10px;
            font-weight: 600;
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            border: none;
            transition: 0.3s;
        }

        .btn-primary:hover {
            transform: scale(1.05);
        }

        /* ================= ALERT ================= */
        .alert {
            border-radius: 10px;
            font-size: 13px;
            padding: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* ================= FOOTER ================= */
        section.text-white {
            margin-top: 40px;
            font-size: 13px;
            opacity: 0.9;
            padding-bottom: 20px;
        }

        /* ================= RESPONSIVE ================= */
        @media (max-width: 768px) {

            .home-section h1 {
                font-size: 28px;
            }

            .card-1,
            .card-2 {
                width: 95%;
            }

            #homeNav {
                margin: 10px;
            }
        }


        body {
            padding-top: 80px;
            /* prevents navbar overlap */
        }

        /* Modern fixed navbar */
        .custom-navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 9999;
        }

        /* Nav links */
        .custom-navbar .nav-link {
            font-weight: 500;
            color: #333;
            transition: 0.3s;
        }

        .custom-navbar .nav-link:hover {
            color: #0d6efd;
        }

        /* Container spacing fix */
        .custom-navbar .container-fluid {
            max-width: 1200px;
        }
    </style>
</head>
<?php
include('config/DB-connection.php');
$query = "SELECT * FROM setting";
$query_stmt = mysqli_prepare($connection, $query);
mysqli_stmt_execute($query_stmt);
$result = mysqli_stmt_get_result($query_stmt);
$row = $result->fetch_assoc();

?>

<body class="body-home">
    <div class="black-fill">
        <div class="container ">
            <br>
            <br>
            <nav class="navbar navbar-expand-lg fixed-top custom-navbar" id="homeNav">

                <div class="container-fluid px-4">

                    <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                        <img src="assets/logo/logo.png" width="40" alt="">
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#about">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#contact">Contact</a>
                            </li>
                        </ul>

                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a href="login.php" class="nav-link">Login</a>
                            </li>
                        </ul>

                    </div>

                </div>
            </nav>

            <section class="  ">
                <div class="home-screen d-flex justify-content-center align-items-center flex-column home-section">
                    <img src=" assets/logo/logo.png" alt="" width="200px">
                    <h1><?= $row['school_name'] ?></h1>
                    <p><?= $row['school_slogan']  ?>.</p>

                </div>
            </section>
            <section class="d-flex justify-content-center align-items-center flex-column   " id="about">
                <div class="card mb-3 card-1">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="assets/logo/logo.png" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">School</h5>
                                <p class="card-text"><?= $row['school_about'] ?></p>
                                <p class="card-text"><small
                                        class="text-body-secondary"><?= $row['school_name'] ?></small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>



            <section class="d-flex justify-content-center align-items-center flex-column   " id="contact">
                <div class="card mb-3 card-2">
                    <h1>Contact As</h1>
                    <div class="d-flex justify-content-end my-4">
                        <div>
                            <?php

                            if (isset($_GET['message'])) {
                            ?>

                                <alert class="alert alert-warning"><?= $_GET['message'] ?></alert>

                            <?php
                            }


                            ?>
                        </div>
                    </div>
                    <form method="post" action="contact/message.php">

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" name="email"
                                value="<?php if (isset($_SESSION['old_message'])) echo $_SESSION['old_message']['email'] ?>">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nameLabel" class="form-label">Name</label>
                            <input type="text" class="form-control" id="nameLabel" name="name"
                                value="<?php if (isset($_SESSION['old_message'])) echo $_SESSION['old_message']['name'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="nameLabel" class="form-label">Message</label>
                            <textarea name="message" id="" rows="4" class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
            </section>

            <section class="text-center text-white">


                Copyright @ 2025 <?= $row['school_name'] ?> All rights reserved
            </section>

        </div>
    </div>


    <script src="assets/js/bootstrap.js"></script>

    <?php

    unset($_SESSION['old_message']);

    ?>
</body>

</html>