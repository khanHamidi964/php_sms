<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {


?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Admin-home</title>
            <link rel="stylesheet" href="../assets/css/bootstrap.css">
            <link rel="stylesheet" href="../assets/css/home.css">
            <link rel="icon" href="../assets/logo/logo.png">
            <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">
            <link rel="stylesheet" href="css/dashboard.css">



        </head>

        <body class="bg-light">
            <?php include('common/navbar.php') ?>

            <div class="container my-5">
                <div class="dashboard">

                    <div class="dashboard-header">
                        <h2>Dashboard Overview</h2>
                        <p>Welcome back! Here is a summary of your system activity and key performance metrics.</p>
                    </div>
                    <div class="dashboard-grid">

                        <!-- Teachers -->
                        <a href="teacher.php" class="dash-card large">
                            <div class="icon bg-blue">
                                <i class="bi bi-person-badge-fill"></i>
                            </div>
                            <div class="info">
                                <h3>
                                    <?php
                                    $result = mysqli_query($connection, "SELECT COUNT(*) as total FROM teachers");
                                    $row = mysqli_fetch_assoc($result);
                                    echo $row['total'];
                                    ?>
                                </h3>
                                <p>Total Teachers</p>
                            </div>
                        </a>

                        <!-- Students -->
                        <a href="student.php" class="dash-card large">
                            <div class="icon bg-green">
                                <i class="bi bi-mortarboard-fill"></i>
                            </div>
                            <div class="info">
                                <h3>
                                    <?php
                                    $result = mysqli_query($connection, "SELECT COUNT(*) as total FROM students");
                                    $row = mysqli_fetch_assoc($result);
                                    echo $row['total'];
                                    ?>
                                </h3>
                                <p>Total Students</p>
                            </div>
                        </a>

                        <!-- Register Office -->
                        <a href="register-office.php" class="dash-card large">
                            <div class="icon bg-purple">
                                <i class="bi bi-journal-plus"></i>
                            </div>
                            <div class="info">
                                <h3>
                                    <?php
                                    $result = mysqli_query($connection, "SELECT COUNT(*) as total FROM registerer_office");
                                    $row = mysqli_fetch_assoc($result);
                                    echo $row['total'];
                                    ?>
                                </h3>
                                <p>Register Office</p>
                            </div>
                        </a>

                        <!-- Classes -->
                        <a href="class.php" class="dash-card large">
                            <div class="icon bg-orange">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <div class="info">
                                <h3>
                                    <?php
                                    $result = mysqli_query($connection, "SELECT COUNT(*) as total FROM classes");
                                    $row = mysqli_fetch_assoc($result);
                                    echo $row['total'];
                                    ?>
                                </h3>
                                <p>Total Classes</p>
                            </div>
                        </a>

                        <!-- Section -->
                        <a href="section.php" class="dash-card large">
                            <div class="icon bg-indigo">
                                <i class="bi bi-layout-split"></i>
                            </div>
                            <div class="info">
                                <h3>
                                    <?php
                                    $result = mysqli_query($connection, "SELECT COUNT(*) as total FROM section");
                                    $row = mysqli_fetch_assoc($result);
                                    echo $row['total'];
                                    ?>
                                </h3>
                                <p>Sections</p>
                            </div>
                        </a>

                        <!-- Courses -->
                        <a href="course.php" class="dash-card large">
                            <div class="icon bg-pink">
                                <i class="bi bi-book-half"></i>
                            </div>
                            <div class="info">
                                <h3>
                                    <?php
                                    $result = mysqli_query($connection, "SELECT COUNT(*) as total FROM subjects");
                                    $row = mysqli_fetch_assoc($result);
                                    echo $row['total'];
                                    ?>
                                </h3>
                                <p>Courses</p>
                            </div>
                        </a>

                        <!-- Messages -->
                        <a href="message.php" class="dash-card large">
                            <div class="icon bg-red">
                                <i class="bi bi-chat-dots-fill"></i>
                            </div>
                            <div class="info">
                                <h3>
                                    <?php
                                    $result = mysqli_query($connection, "SELECT COUNT(*) as total FROM messages");
                                    $row = mysqli_fetch_assoc($result);
                                    echo $row['total'];
                                    ?>
                                </h3>
                                <p>Messages</p>
                            </div>
                        </a>

                        <!-- Grade -->
                        <a href="grade.php" class="dash-card large">
                            <div class="icon bg-yellow">
                                <i class="bi bi-bar-chart-line-fill"></i>
                            </div>
                            <div class="info">
                                <h3>
                                    <?php
                                    $result = mysqli_query($connection, "SELECT COUNT(*) as total FROM grades");
                                    $row = mysqli_fetch_assoc($result);
                                    echo $row['total'];
                                    ?>
                                </h3>
                                <p>Grades</p>
                            </div>
                        </a>

                    </div>

                </div>
            </div>



            <script src="../assets/js/bootstrap.js"></script>
            <script src="../assets/js/jquery.js"></script>


        </body>

        <script>
            $(document).ready(function() {
                $('#navLink li:nth-child(1) a').addClass('active')
            })
        </script>

        </html>

<?php

    } else {
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
}

?>