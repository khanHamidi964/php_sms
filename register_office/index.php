<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Register Office') {


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Register Office - home</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="icon" href="../assets/logo/logo.png">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        /* ===== Dashboard Layout ===== */

.dashboard-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    transition: 0.2s ease;
    border: 1px solid rgba(0,0,0,0.04);
}

.dashboard-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

/* Icon */
.card-icon {
    width: 55px;
    height: 55px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
}

/* Info */
.card-info h2 {
    font-size: 24px;
    margin: 0;
    font-weight: 700;
    color: #111827;
}

.card-info p {
    margin: 0;
    font-size: 13px;
    color: #6b7280;
}

/* Colors */
.bg-primary {
    background: #3b82f6;
}

.bg-danger {
    background: #ef4444;
}

/* Logout special style */
.dashboard-card.danger:hover {
    background: #fff5f5;
}

/* Make cards look clickable */
.dashboard-card a {
    display: flex;
    width: 100%;
}
    </style>
</head>

<body class="bg-light">

<?php include('common/navbar.php'); ?>

<div class="container my-5">

    <div class="row g-4">

        <!-- Total Students Card -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <a href="student.php" class="text-decoration-none">
                <div class="dashboard-card">
                    <div class="card-icon bg-primary">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>

                    <div class="card-info">
                        <h2>
                            <?php
                            $result = mysqli_query($connection, "SELECT COUNT(*) as total FROM students");
                            $row = mysqli_fetch_assoc($result);
                            echo $row['total'];
                            ?>
                        </h2>
                        <p>Total Students</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Logout Card -->
        <div class="col-xl-3 col-lg-4 col-md-6">
            <a href="../logout.php" class="text-decoration-none">
                <div class="dashboard-card danger">
                    <div class="card-icon bg-danger">
                        <i class="bi bi-box-arrow-right"></i>
                    </div>

                    <div class="card-info">
                        <h2>Exit</h2>
                        <p>Logout from system</p>
                    </div>
                </div>
            </a>
        </div>

    </div>

</div>

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