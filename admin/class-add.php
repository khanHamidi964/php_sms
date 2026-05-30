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
    <title>Admin- Add Class</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="icon" href="../assets/logo/logo.png">

    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="stylesheet" href="css/add.css">

</head>

<body class="bg-light">
    <?php include('common/navbar.php') ?>
    <?php include('../config/DB-connection.php') ?>

    <div class="container mt-4 w-50">

        <div class="card p-3 my-3 shadow">
            <div class="d-flex justify-content-between">
                <h4> <i class="bi bi-box-fill"></i> Add New Class</h4>
                <a href="class.php" class="btn btn-dark"><i class="bi bi-arrow-left"></i> Go back</a>
            </div>
            <hr>
            <form method="post" action="logic/class-add.php">
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


                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="grade" class="form-label">Grade </label>
                            <select name="grade" id="" class="form-control shadow-none">
                                <option value="" selected disabled>Select the grade </option>

                                <?php
                                        $grade_query = "SELECT * FROM grades ";
                                        $grade_query_stmt =mysqli_prepare($connection , $grade_query);
                                        mysqli_stmt_execute($grade_query_stmt);
                                        $grade_result = mysqli_stmt_get_result($grade_query_stmt);

                                        while ($grade_row = $grade_result->fetch_assoc()) {

                                        ?>
                                <option value="<?= $grade_row['grade_id'] ?>">
                                    <?= $grade_row['grade_code'] . '-' . $grade_row['grade'] ?>
                                </option>
                                <?php
                                        }
                                        ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="section" class="form-label">Section</label>
                                <select name="section" id="section" class="form-control shadow-none">
                                    <option value="" selected disabled>Select the section </option>

                                    <?php
                                            $section_query = "SELECT * FROM section ";
                                            $section_query_stmt =mysqli_prepare($connection , $section_query);
                                            mysqli_stmt_execute($section_query_stmt);
                                            
                                            $section_result = mysqli_stmt_get_result($section_query_stmt);

                                            while ($section_row = $section_result->fetch_assoc()) {

                                            ?>
                                    <option value="<?= $section_row['section_id'] ?>">
                                        <?= $section_row['section'] ?>
                                    </option>
                                    <?php
                                            }
                                            ?>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

                <button type="submit" class="btn btn-dark" name="submitBtn">Add</button>
            </form>
        </div>

    </div>



    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/jquery.js"></script>


</body>

<script>
$(document).ready(function() {
    $('#navLink li:nth-child(6) a').addClass('active');
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