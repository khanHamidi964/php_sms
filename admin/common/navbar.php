<?php

include('../config/DB-connection.php');

/* =========================
   USER DATA
========================= */
$stmt = mysqli_prepare($connection, "SELECT * FROM admin WHERE admin_id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, 'i', $_SESSION['id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

/* =========================
   SAFE ACTIVE PAGE HANDLING
   (IMPORTANT FIX)
========================= */
$current = $page ?? basename($_SERVER['PHP_SELF'], ".php");

if ($current == "index") {
    $current = "dashboard";
}
?>

<link rel="stylesheet" href="css/header-sidebar.css">

<!-- ========================= TOP HEADER ========================= -->
<header class="topbar">

    <div class="topbar-left"></div>

    <div class="user-box" onclick="toggleUserMenu()">

        <div class="user-info">
            <span><?= $user['username'] ?? 'Admin' ?></span>
            <small>Admin</small>
        </div>

        <i class="bi bi-chevron-down"></i>

        <div class="user-dropdown" id="userDropdown">
            <a href="setting.php"><i class="bi bi-gear"></i> Settings</a>
            <a href="../logout.php" class="logout">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>

    </div>

</header>

<!-- ========================= MOBILE BUTTON ========================= -->
<div class="sidebar-toggle" onclick="toggleSidebar()">
    <i class="bi bi-list"></i>
</div>

<!-- ========================= OVERLAY ========================= -->
<div class="sidebar-overlay" onclick="toggleSidebar()"></div>

<!-- ========================= SIDEBAR ========================= -->
<aside class="sidebar" id="sidebar">

    <!-- LOGO -->
    <div class="sidebar-header">
        <img src="../assets/logo/logo.png" alt="logo">
        <h2>Admin Panel</h2>
    </div>

    <!-- MENU -->
    <ul class="sidebar-menu">

        <li>
            <a href="index.php" class="<?= ($current == 'dashboard') ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
        </li>

        <li>
            <a href="teacher.php" class="<?= ($current == 'teacher') ? 'active' : '' ?>">
                <i class="bi bi-person-badge-fill"></i> Teachers
            </a>
        </li>

        <li>
            <a href="student.php" class="<?= ($current == 'student') ? 'active' : '' ?>">
                <i class="bi bi-mortarboard-fill"></i> Students
            </a>
        </li>

        <li>
            <a href="grade.php" class="<?= ($current == 'grade') ? 'active' : '' ?>">
                <i class="bi bi-bar-chart-line-fill"></i> Grade
            </a>
        </li>

        <li>
            <a href="section.php" class="<?= ($current == 'section') ? 'active' : '' ?>">
                <i class="bi bi-layout-split"></i> Section
            </a>
        </li>

        <li>
            <a href="class.php" class="<?= ($current == 'class') ? 'active' : '' ?>">
                <i class="bi bi-box-seam"></i> Class
            </a>
        </li>

        <li>
            <a href="register-office.php" class="<?= ($current == 'register') ? 'active' : '' ?>">
                <i class="bi bi-journal-plus"></i> Register Office
            </a>
        </li>

        <li>
            <a href="course.php" class="<?= ($current == 'course') ? 'active' : '' ?>">
                <i class="bi bi-book-half"></i> Courses
            </a>
        </li>

        <li>
            <a href="message.php" class="<?= ($current == 'message') ? 'active' : '' ?>">
                <i class="bi bi-chat-dots-fill"></i> Messages
            </a>
        </li>
        <li>
            <a href="profile.php" class="<?= ($current == 'profile') ? 'active' : '' ?>">
                <i class="bi bi-person"></i> Profile
            </a>
        </li>
        <li>
            <a href="setting.php" class="<?= ($current == 'setting') ? 'active' : '' ?>">
                <i class="bi bi-gear-fill"></i> Settings
            </a>
        </li>

    </ul>

</aside>

<!-- ========================= MAIN WRAPPER ========================= -->
<div class="main-content">

<script>
/* toggle sidebar */
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("active");
    document.querySelector(".sidebar-overlay").classList.toggle("active");
}

/* user dropdown */
function toggleUserMenu() {
    document.getElementById("userDropdown").classList.toggle("show");
}

/* close dropdown on outside click */
document.addEventListener("click", function(e) {
    let box = document.querySelector(".user-box");
    let dropdown = document.getElementById("userDropdown");

    if (!box.contains(e.target)) {
        dropdown.classList.remove("show");
    }
});
</script>