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
    <title>Admin- Edit Grade</title>
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
                <h4> <i class="bi bi-book-fill"></i> Add New Grade</h4>
                <a href="grade.php" class="btn btn-dark"> <i class="bi bi-arrow-left"></i>Go back</a>
            </div>
            <hr>
            <form method="post" action="logic/grade-edit.php">
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

                        $grade_id = $_GET['grade_id'];
                        $get_grade = "SELECT * FROM grades WHERE grade_id = ? ";
                        $get_grade_stmt =mysqli_prepare($connection , $get_grade);
                        mysqli_stmt_bind_param($get_grade_stmt , 'i' , $grade_id);
                        mysqli_stmt_execute($get_grade_stmt);
                        $get_grade_result = mysqli_stmt_get_result($get_grade_stmt);
                        $get_grade_row = $get_grade_result->fetch_assoc();


                        ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="grade" class="form-label">Grade </label>
                            <input type="hidden" name="grade_id" value="<?php echo $_GET['grade_id']  ?>">
                            <input type="text" class="form-control shadow-none border-1" id="grade" name="grade"
                                value="<?php echo $get_grade_row['grade'] ?>">
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="grade_code" class="form-label">Grade Code</label>
                                <input type="text" class="form-control shadow-none border-1" id="grade_code"
                                    name="grade_code" value="<?php echo  $get_grade_row['grade_code'] ?>">
                            </div>
                        </div>

                    </div>
                </div>

                <button type="submit" class="btn btn-dark" name="submitBtn">update</button>
            </form>
        </div>

    </div>



    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/jquery.js"></script>


</body>

<script>
$(document).ready(function() {
    $('#navLink li:nth-child(4) a').addClass('active');
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