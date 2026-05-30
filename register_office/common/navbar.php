   <?php
    include('../config/DB-connection.php');
    $get_user_for_check_profile = "SELECT * FROM registerer_office WHERE r_user_id = ? LIMIT 1 ";
    $get_user_for_check_profile_stmt = mysqli_prepare($connection, $get_user_for_check_profile);
    mysqli_stmt_bind_param($get_user_for_check_profile_stmt, 'i', $_SESSION['id']);
    mysqli_stmt_execute($get_user_for_check_profile_stmt);
    $check_result_profile = mysqli_stmt_get_result($get_user_for_check_profile_stmt);
    $check_row_profile = $check_result_profile->fetch_assoc();

    ?>

    <link rel="stylesheet" href="css/header.css">
   <nav class="navbar navbar-expand-lg bg-dark navbar-dark " id="navLink">
       <div class="container-fluid">
           <a class="navbar-brand" href="index.php"><img src="../assets/logo/logo.png" width="40px" alt=""></a>
           <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
               data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
               aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
           </button>
           <div class="collapse navbar-collapse" id="navbarSupportedContent">
               <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                   <li class="nav-item">
                       <a class="nav-link " aria-current="page" href="index.php"><i
                               class="bi bi-layout-text-sidebar-reverse"></i>
                           Dashboard</a>
                   </li>
                   <li class="nav-item">
                       <a class="nav-link" href="student-add.php"> <i class="bi bi-person-plus-fill"></i>Add Student</a>
                   </li>
                   <li class="nav-item">
                       <a class="nav-link" href="student.php"> <i class="bi bi-mortarboard-fill"></i> Students</a>
                   </li>
                   <li class="nav-item">
                       <a class="nav-link" href="profile.php"> <i class="bi bi-person-fill-check"></i> Profile</a>
                   </li>

               </ul>
               <ul class="navbar-nav me-right mb-2 mb-lg-0">
                   <li class="nav-item">
                       <div class="d-flex">

                           <a href="../logout.php" class="nav-link text-danger"> <i
                                   class="bi bi-arrow-left"></i>logout</a>
                           <a href="profile.php">
                               <img src="../<?= $check_row_profile['profile'] ?>" class=" "
                                   style='width:50px; height:50px; border-radius:50%; border:2px solid pink' alt="">
                           </a>
                       </div>
                   </li>

               </ul>

           </div>
       </div>
   </nav>