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
    <title>Admin - Setting</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="icon" href="../assets/logo/logo.png">
    <link rel="stylesheet" href="../assets/css/bootstrapIcon.css">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/setting.css">




</head>

<body class="bg-light">
    <?php include('common/navbar.php') ?>

    <?php include('../config/DB-connection.php') ?>

    <div class="container">
        <div class="row">
            <div class="col d-flex justify-content-center">

                <div class="card shadow-sm my-5 p-2 " style="width: 500px;">
                    <h2 class="text-center">Edit Setting</h2>
                    <hr>
                    <br>

                    <div class="d-flex justify-content-end alert-div">

                        <?php
                                if (isset($_GET['mess'])) {

                                ?>
                        <div class="alert alert-warning alert-div"> <?= $_GET['mess'] ?>&nbsp;&nbsp;&nbsp; <a href=""
                                id="close-btn" class=" text-decoration-none text-danger c-pointer">X</a>
                        </div>
                        <?php

                                } ?>

                    </div>

                    <?php

                            $query = "SELECT * FROM setting";
                            $query_stmt = mysqli_prepare($connection, $query);
                            mysqli_stmt_execute($query_stmt);
                            $result = mysqli_stmt_get_result($query_stmt);
                            $row = $result->fetch_assoc();




                            ?>
                    <form action="logic/setting-edit.php" method="post">
                        <label for="" class="my-2">School Name</label>
                        <input type="text" class="form-control shadow-none" name="name"
                            value="<?= $row['school_name'] ?>">
                        <label for="" class="my-2">School Slogan</label>
                        <input type="text" class="form-control shadow-none" name="slogan"
                            value="<?= $row['school_slogan'] ?>">
                        <label for="" class="my-2">School About</label>
                        <input type="text" class="form-control shadow-none" name="about"
                            value="<?= $row['school_about'] ?>">
                        <button class="btn btn-dark my-2">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/jquery.js"></script>

</body>

<script>
$(document).ready(function() {
    $('#navLink li:nth-child(10) a').addClass('active')

    $('#close-btn').on('click', function(e) {
        e.preventDefault()
        $('.alert-div').removeClass('alert alert-warning').addClass('text-white')
        $('#close-btn').removeClass('text-danger').addClass('text-white')
    })
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