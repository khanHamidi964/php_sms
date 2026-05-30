<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Teacher') {


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Teacher - home</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="icon" href="../assets/logo/logo.png">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body class="bg-light">

    <?php include('common/navbar.php')   ?>

    <div class="container my-5">
        <div class="container">


            <div class="card p-3 my-3 shadow-sm">

                <h4><i class="bi  bi-person-check-fill"></i> Edit Your Password</h4>
                <hr>
                <form method="post" action="logic/teacher-edit-password.php" id="password-form">
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

                                <label for="c_password" class="form-label">Current Password</label>
                                <input type="hidden" name="student_id">
                                <input type="text" class="form-control shadow-none border-1" id="c_password"
                                    name="c_password"
                                    value="<?php if (isset($_SESSION['old_password'])) echo   $_SESSION['old_password']['c_password'] ?>">
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
    </div>




    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/jquery.js"></script>


</body>

<script>
$(document).ready(function() {
    $('#navLink li:nth-child(5) a').addClass('active')
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