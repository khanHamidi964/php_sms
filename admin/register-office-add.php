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
    <title>Admin- Add Register Office</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="icon" href="../assets/logo/logo.png">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">


</head>

<body class="bg-light">
    <?php include('common/navbar.php') ?>
    <?php include('../config/DB-connection.php') ?>

    <div class="container mt-4">

        <div class="card p-3 my-3 shadow">
            <div class="d-flex justify-content-between">
                <h4><i class="bi bi-person-fill-add"></i> Add New Register Office User</h4>
                <a href="register-office.php" class="btn btn-dark"><i class="bi bi-arrow-left"></i> Go back</a>
            </div>
            <hr>
            <form method="post" action="logic/register-office-add.php" id="add-teacher-form" enctype="multipart/form-data">
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
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control shadow-none border-1" id="first_name"
                                name="first_name"
                                value="<?php if (isset($_SESSION['r_old'])) echo $_SESSION['r_old']['first_name'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control shadow-none border-1" id="last_name" name="last_name"
                                value="<?php if (isset($_SESSION['r_old'])) echo $_SESSION['r_old']['last_name'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="username" class="form-label">username</label>
                            <input type="text" class="form-control shadow-none border-1" id="username" name="username"
                                value="<?php if (isset($_SESSION['r_old'])) echo $_SESSION['r_old']['username'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="text" class="form-control shadow-none border-1" id="password"
                                    name="password"
                                    value="<?php if (isset($_SESSION['r_old'])) echo $_SESSION['r_old']['password'] ?>">
                                <button class="btn btn-secondary" id="randomBtn">Random</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control shadow-none border-1" id="address" name="address"
                                value="<?php if (isset($_SESSION['r_old'])) echo $_SESSION['r_old']['address'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="emp_number" class="form-label">Employee Number </label>
                            <input type="text" class="form-control shadow-none border-1" id="emp_number"
                                name="emp_number"
                                value="<?php if (isset($_SESSION['r_old'])) echo $_SESSION['r_old']['emp_number'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number </label>
                            <input type="text" class="form-control shadow-none border-1" id="phone_number"
                                name="phone_number"
                                value="<?php if (isset($_SESSION['r_old'])) echo $_SESSION['r_old']['phone_number'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="qualification" class="form-label">Qualification</label>
                            <input type="text" class="form-control shadow-none border-1" id="qualification"
                                name="qualification"
                                value="<?php if (isset($_SESSION['r_old'])) echo $_SESSION['r_old']['qualification'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="text" class="form-control shadow-none border-1" id="email" name="email"
                                value="<?php if (isset($_SESSION['r_old'])) echo $_SESSION['r_old']['email'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="dob" class="form-label">Birth day</label>
                            <input type="date" class="form-control shadow-none border-1" id="dob" name="dob"
                                value="<?php if (isset($_SESSION['r_old'])) echo $_SESSION['r_old']['dob'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Gender</label><br>
                            <input type="radio" name="gender" value="Male"
                                <?= (isset($_SESSION['r_old']['gender']) && $_SESSION['r_old']['gender'] == 'Male') ? 'checked' : '' ?>>
                            Male &nbsp;&nbsp;

                            <input type="radio" name="gender" value="Female"
                                <?= (isset($_SESSION['r_old']['gender']) && $_SESSION['r_old']['gender'] == 'Female') ? 'checked' : '' ?>>
                            Female

                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile</label>
                            <input type="file" class="form-control shadow-none border-1" id="image" name="image">
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
    $('#navLink li:nth-child(7) a').addClass('active');
    $('#close-btn').on('click', function(e) {
        e.preventDefault()
        $('.alert-div').removeClass('alert alert-warning').addClass('text-white')
        $('#close-btn').removeClass('text-danger').addClass('text-white')
    })



})

var randomButtonFunction = document.getElementById('randomBtn');
randomButtonFunction.addEventListener(
    'click',
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
    var password = document.getElementById('password');
    password.value = result;

}
</script>

</html>

<?php
        unset($_SESSION['r_old']);
    } else {
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
}



?>