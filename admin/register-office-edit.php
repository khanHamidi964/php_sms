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
    <title>Admin- Edit Register Office </title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="icon" href="../assets/logo/logo.png">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/edit.css">

</head>

<body class="bg-light">
    <?php include('common/navbar.php') ?>
    <?php include('../config/DB-connection.php') ?>

    <div class="container mt-4">
        <div class="card p-3 my-3 shadow">
            <div class="d-flex justify-content-between">

                <h4><i class="bi  bi-person-check-fill"></i> Edit Register Office User </h4>
                <a href="register-office.php" class="btn btn-dark"><i class="bi bi-arrow-left"></i> Go back</a>
            </div>
            <hr>
            <form method="post" action="logic/register-office-edit.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        <div class="d-flex justify-content-end alert-div">

                            <?php
                                    if (isset($_GET['error'])) {

                                    ?>
                            <div class="alert alert-warning alert-div"> <?= $_GET['error'] ?>&nbsp;&nbsp;&nbsp; <a
                                    href="" id="close-btn" class=" text-decoration-none text-danger c-pointer">X</a>
                            </div>
                            <?php

                                    } ?>

                        </div>
                    </div>
                </div>

                <?php

                        if (isset($_GET['r_user_id'])) {

                            $r_user_id = $_GET['r_user_id'];
                            if (is_numeric($r_user_id)) {

                                $get_Single_r_user_query = "SELECT * FROM registerer_office WHERE r_user_id = ? LIMIT 1";
                                $get_Single_r_user_query_stmt = mysqli_prepare($connection , $get_Single_r_user_query);
                                mysqli_stmt_bind_param($get_Single_r_user_query_stmt, 'i', $r_user_id );
                                mysqli_stmt_execute($get_Single_r_user_query_stmt);
                                $get_single_r_user_result =mysqli_stmt_get_result($get_Single_r_user_query_stmt);
                                $get_single_r_user_row = $get_single_r_user_result->fetch_assoc();
                            } else {
                                $mess = 'register user id is not a number ';
                                header("location: register-office.php?error=$mess");
                            }
                        } else {
                            $mess = 'Somethings went wrong ';
                            header("location: register-office.php?error=$mess");
                        }



                        ?>

                <div class="row">
                    <div class=" col-md-4 col-lg-3  ">
                        <div class="mb-3">
                            <input type="hidden" name="r_user_id" value="<?= $_GET['r_user_id'] ?>">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control shadow-none border-1" id="first_name"
                                name="first_name" value="<?= $get_single_r_user_row['fname'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4  col-lg-3">
                        <div class="mb-3">

                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control shadow-none border-1" id="last_name" name="last_name"
                                value="<?= $get_single_r_user_row['lname'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="mb-3">
                            <label for="username" class="form-label">username</label>
                            <input type="text" class="form-control shadow-none border-1" id="username" name="username"
                                value="<?= $get_single_r_user_row['username'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4  col-lg-3">
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control shadow-none border-1" id="address" name="address"
                                value="<?= $get_single_r_user_row['address'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4  col-lg-3">
                        <div class="mb-3">
                            <label for="emp_number" class="form-label">Employee Number </label>
                            <input type="text" class="form-control shadow-none border-1" id="emp_number"
                                name="emp_number" value="<?= $get_single_r_user_row['employee_number']  ?>">
                        </div>
                    </div>
                    <div class="col-md-4  col-lg-3">
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number </label>
                            <input type="text" class="form-control shadow-none border-1" id="phone_number"
                                name="phone_number" value="<?= $get_single_r_user_row['phone_number'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4  col-lg-3">
                        <div class="mb-2">
                            <label for="qualification" class="form-label">Qualification</label>
                            <input type="text" class="form-control shadow-none border-1" id="qualification"
                                name="qualification" value="<?= $get_single_r_user_row['qualification'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4  col-lg-3">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="text" class="form-control shadow-none border-1" id="email" name="email"
                                value="<?= $get_single_r_user_row['email'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="dob" class="form-label">Birth day</label>
                            <input type="date" class="form-control shadow-none border-1" id="dob" name="dob"
                                value="<?= $get_single_r_user_row['date_of_birth'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4  col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Gender</label><br>
                            <input type="radio" name="gender" value="Male"
                                <?php if ($get_single_r_user_row['gender'] == 'Male') echo 'checked' ?>>
                            Male &nbsp;&nbsp;

                            <input type="radio" name="gender" value="Female"
                                <?php if ($get_single_r_user_row['gender'] == 'Female') echo 'checked' ?>>
                            Female
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile</label>
                            <input type="file" class="form-control shadow-none border-1" id="image" name="image">
                            <div class="my-2 d-flex justify-content-end">
                                <img src="../<?= $get_single_r_user_row['profile'] ?>" alt="" class="img-thumbnail"
                                    width="200px" height="200px">
                            </div>
                        </div>
                    </div>
                    <hr>





                </div>

                <button type="submit" class="btn btn-dark" name="submitBtn">Update</button>
            </form>
        </div>

        <div class="card p-3 my-3 shadow-sm">

            <h4><i class="bi bi-person-check-fill"></i> Edit Register Office User Password</h4>
            <hr>
            <form method="post" action="logic/register-office-edit-password.php" id="password-form">
                <div class="row">
                    <div class="col">
                        <div class="d-flex justify-content-end alert-div">

                            <?php
                                    if (isset($_GET['message'])) {

                                    ?>
                            <div class="alert alert-warning alert-div"> <?= $_GET['message'] ?>&nbsp;&nbsp;&nbsp; <a
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

                            <label for="admin_password" class="form-label">Admin Password</label>
                            <input type="hidden" name="r_user_id" value="<?= $_GET['r_user_id'] ?>">
                            <input type="text" class="form-control shadow-none border-1" id="admin_password"
                                name="admin_password"
                                value="<?php if (isset($_SESSION['old_password'])) echo   $_SESSION['old_password']['admin_password'] ?>">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <div class="input-group">

                                <input type="text" class="form-control shadow-none border-1" id="new_password"
                                    name="new_password"
                                    value="<?php if (isset($_SESSION['old_password'])) echo   $_SESSION['old_password']['new_password'] ?>">
                                <button class="btn btn-secondary" id="randomBtn">Random</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="confirmNew_password" class="form-label">Confirm New Password</label>
                            <input type="text" class="form-control shadow-none border-1" id="confirmNew_password"
                                name="confirmNew_password"
                                value="<?php if (isset($_SESSION['old_password'])) echo   $_SESSION['old_password']['confirmNew_password'] ?>">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-dark" name="submitBtn">Save change </button>
            </form>

        </div>

    </div>



    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/jquery.js"></script>


</body>

<script>
$(document).ready(function() {
    $('#navLink li:nth-child(7) a').addClass('active');
    $('#close-btn').on('click', function(e) {
        e.preventDefault()
        $('.alert-div').removeClass('alert alert-warning').addClass('text-white')
        $('#close-btn').removeClass('text-danger').addClass('text-white')
    })






})

var randomButtonFunction = document.getElementById('randomBtn');
randomButtonFunction.addEventListener('click',
    function(e) {
        e.preventDefault();
        strPassword(4);
    })

function strPassword(length) {
    let result = '';
    const characters = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ!#$%^&*';

    // Loop to generate characters for the specified length
    for (let i = 0; i < length; i++) {
        const randomInd = Math.floor(Math.random() * characters.length);
        result += characters.charAt(randomInd);
    }
    var new_password = document.getElementById('new_password');
    new_password.value = result;
    var confirm_password = document.getElementById('confirmNew_password');
    confirm_password.value = result;

}
</script>

</html>


<?php

        unset($_SESSION['old_password']);
    } else {
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
}

?>