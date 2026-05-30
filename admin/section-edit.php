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
    <title>Admin- Edit Section</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="icon" href="../assets/logo/logo.png">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/edit.css">

</head>

<body class="bg-light">
    <?php include('common/navbar.php') ?>
    <?php include('../config/DB-connection.php') ?>

    <div class="container mt-4 w-50">

        <div class="card p-3 my-3 shadow">
            <div class="d-flex justify-content-between">
                <h4> <i class="bi bi-box-fill"></i> Edit Section </h4>
                <a href="section.php" class="btn btn-dark"><i class="bi bi-arrow-left"></i> Go back</a>
            </div>
            <hr>
            <form method="post" action="logic/section-edit.php">
                <div class="row">
                    <div class="col">
                        <div class="d-flex justify-content-end alert-div">

                            <?php
                                    if (isset($_GET['mess'])) {

                                    ?>
                            <div class="alert alert-warning alert-div"> <?= $_GET['mess'] ?>&nbsp;&nbsp;&nbsp; <a
                                    href="" id="close-btn" class=" text-decoration-none text-danger c-pointer">X</a>
                            </div>
                            <?php

                                    } ?>

                        </div>
                    </div>
                </div>

                <?php

                        $section_id = $_GET['section_id'];


                        $section_get = "SELECT * FROM section WHERE section_id = ?";
                        $section_get_stmt = mysqli_prepare($connection , $section_get);
                        mysqli_stmt_bind_param($section_get_stmt, 'i' , $section_id );
                        mysqli_stmt_execute($section_get_stmt);
                        $section_result = mysqli_stmt_get_result($section_get_stmt);
                        $section_row =$section_result->fetch_assoc();



                        ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="grade" class="form-label">Section </label>
                            <input type="hidden" name="section_id" value="<?= $section_row['section_id'] ?>">
                            <input type="text" class="form-control shadow-none border-1" id="grade" name="section"
                                value="<?= $section_row['section'] ?>">
                        </div>



                    </div>
                </div>

                <button type="submit" class="btn btn-dark" name="submitBtn">Update</button>
            </form>
        </div>

    </div>



    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/jquery.js"></script>


</body>

<script>
$(document).ready(function() {
    $('#navLink li:nth-child(5) a').addClass('active');
    $('#close-btn').on('click', function(e) {
        e.preventDefault()
        $('.alert-div').removeClass('alert alert-warning').addClass('text-white')
        $('#close-btn').removeClass('text-danger').addClass('text-white')
    })




})
</script>

</html>

<?php
        unset($_SESSION['old_grade']);
    } else {
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
}



?>