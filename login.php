<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    header('location:users/home.php');
}


include('config/DB-connection.php');
$query = "SELECT * FROM setting";
$query_stmt = mysqli_prepare($connection, $query);
mysqli_stmt_execute($query_stmt);
$result = mysqli_stmt_get_result($query_stmt);
$row = $result->fetch_assoc();



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMS - Login</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="icon" href="assets/logo/logo.png">
    <style>
        body.body-login {
    margin: 0;
    padding: 0;
    font-family: "Segoe UI", sans-serif;
}

/* Keep your existing background overlay */
.black-fill {
    min-height: 100vh;
    background: rgba(0, 0, 0, 0.65); /* keep your dark overlay */
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Login Card */
.login-section {
    width: 380px;
    background: rgba(255, 255, 255, 0.96);
    padding: 32px;
    border-radius: 18px;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35);
    backdrop-filter: blur(8px);
    transition: all 0.3s ease;
}

/* Hover animation */
.login-section:hover {
    transform: translateY(-4px);
}

/* Logo */
.login-section img {
    margin-bottom: 10px;
}

/* Title */
.login-section h1 {
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 18px;
    color: #222;
}

/* Inputs */
.login-section .form-control {
    border-radius: 10px;
    padding: 11px 12px;
    border: 1px solid #ddd;
    font-size: 14px;
    transition: 0.3s;
}

.login-section .form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 10px rgba(13, 110, 253, 0.25);
}

/* Labels */
.login-section .form-label {
    font-size: 13px;
    font-weight: 600;
    color: #444;
}

/* Button */
.login-section .btn-primary {
    width: 100%;
    border-radius: 10px;
    padding: 10px;
    font-weight: 600;
    background: linear-gradient(135deg, #0d6efd, #0b5ed7);
    border: none;
    transition: 0.3s ease;
}

.login-section .btn-primary:hover {
    transform: scale(1.02);
    background: linear-gradient(135deg, #0b5ed7, #084298);
}

/* Links */
.login-section a {
    font-size: 13px;
    color: #0d6efd;
    transition: 0.3s;
}

.login-section a:hover {
    text-decoration: underline;
}

/* Alert box */
.alert {
    border-radius: 10px;
    font-size: 13px;
    padding: 10px;
}

/* Footer */
section.text-white {
    font-size: 13px;
    opacity: 0.9;
    margin-top: 20px;
}
    </style>
</head>

<body class="body-login">
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

            <div class=" d-flex justify-content-center align-items-center flex-column mt-4">
                <section class="login-section ">

                    <div class="d-flex justify-content-center ">

                        <img src="assets/logo/logo.png" width="130px" alt="">
                    </div>
                    <h1 class="text-center">Login</h1>
                    <?php
                    if (isset($_GET['error'])) {



                    ?>
                    <div class="alert alert-danger"><?php echo $_GET['error'] ?></div>

                    <?php
                    }
                    ?>
                    <div>
                        <form action="request/login.php" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">User name</label>
                                <input type="text" class="form-control" id="username" name="username">

                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Login As</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="1">Admin</option>
                                    <option value="2">Teacher</option>
                                    <option value="3">Student</option>
                                    <option value="4">Register Office</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button> <a href="index.php"
                                class=" text-decoration-none mx-2">home</a>
                        </form>
                    </div>
                </section>
                <br>
                <br>
                <br>

                <section class="text-center text-white">
                    Copyright @ 2025 <?= $row['school_name'] ?>. All rights reserved
                </section>
            </div>

        </div>
    </div>
    <script src="assets/js/bootstrap.js"></script>
</body>

</html>