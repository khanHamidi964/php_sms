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
    <title>Admin- Edit Student</title>
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
                <h4><i class="bi  bi-person-check-fill"></i> Edit Student</h4>
                <a href="student.php" class="btn btn-dark"> <i class="bi bi-arrow-left"></i> Go back</a>
            </div>
            <hr>
            <form method="post" action="logic/student-edit.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col">
                        <div class="d-flex justify-content-end alert-div">

                            <?php
                                    if (isset($_GET['message1'])) {

                                    ?>
                            <div class="alert alert-warning alert-div"> <?= $_GET['message1'] ?>&nbsp;&nbsp;&nbsp; <a
                                    href="" id="close-btn" class=" text-decoration-none text-danger c-pointer">X</a>
                            </div>
                            <?php

                                    } ?>

                        </div>
                    </div>
                </div>

                <?php

                        if (isset($_GET['student_id'])) {

                            $student_id = $_GET['student_id'];
                            if (is_numeric($student_id)) {

                                $get_Single_student_query = "SELECT * FROM students WHERE student_id = ? LIMIT 1";
                                $get_single_student_result_stmt = mysqli_prepare($connection, $get_Single_student_query);
                                mysqli_stmt_bind_param($get_single_student_result_stmt, 'i', $student_id);
                                mysqli_stmt_execute($get_single_student_result_stmt);
                                $result = mysqli_stmt_get_result($get_single_student_result_stmt);
                                $get_single_student_row = $result->fetch_assoc();
                            } else {
                                $mess = 'student id is not a number ';
                                header("location: student.php?error=$mess");
                            }
                        } else {
                            $mess = 'Somethings went wrong ';
                            header("location: student.php?error=$mess");
                        }



                        ?>

                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <div class="mb-3">
                            <input type="hidden" name="student_id" value="<?= $_GET['student_id'] ?>">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control shadow-none border-1" id="first_name"
                                name="first_name" value="<?= $get_single_student_row['fname'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control shadow-none border-1" id="last_name" name="last_name"
                                value="<?= $get_single_student_row['lname'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="mb-3">
                            <label for="username" class="form-label">username</label>
                            <input type="text" class="form-control shadow-none border-1" id="username" name="username"
                                value="<?= $get_single_student_row['username'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control shadow-none border-1" id="address" name="address"
                                value="<?= $get_single_student_row['address'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control shadow-none border-1" id="email" name="email"
                                value="<?= $get_single_student_row['email'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="mb-3">
                            <label for="dob" class="form-label">Date of birth</label>
                            <input type="date" class="form-control shadow-none border-1" id="dob" name="dob"
                                value="<?= $get_single_student_row['date_of_birth'] ?>">
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-2">
                        <div class="mb-3">
                            <label class="form-label">Gender</label><br>
                            <input type="radio" name="gender" value="Male"
                                <?= ($get_single_student_row['gender'] == "Male") ? 'checked' : '' ?>>


                            Male &nbsp;&nbsp;

                            <input type="radio" name="gender" value="Female"
                                <?= ($get_single_student_row['gender'] == "Female") ? 'checked' : '' ?>>
                            Female

                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="mb-3">
                            <label for="pfname" class="form-label">Parent First Name</label>
                            <input type="text" class="form-control shadow-none border-1" id="pfname" name="pfname"
                                value="<?= $get_single_student_row['parent_first_name'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="mb-3">
                            <label for="plname" class="form-label">Parent Last Name</label>
                            <input type="text" class="form-control shadow-none border-1" id="plname" name="plname"
                                value="<?= $get_single_student_row['parent_last_name'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="mb-3">
                            <label for="ppnumber" class="form-label">Parent Phone Number</label>
                            <input type="text" class="form-control shadow-none border-1" id="ppnumber" name="ppnumber"
                                value="<?= $get_single_student_row['parent_phone_number'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile</label>
                            <input type="file" class="form-control shadow-none border-1" id="image" name="image">
                        </div>
                        <div class=" profile-show mb-2 d-flex justify-content-end">
                            <img src="../<?= $get_single_student_row['profile'] ?>" class="img-thumbnail"
                                style="height:200px ; width:auto" alt="" id="old_image">

                        </div>
                    </div>



                    <hr>


                    <div class="col-md-6 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">All Sections</label> <br>
                            <?php
                                    $sections = "SELECT * FROM   section ";
                                    $section_query = mysqli_query($connection, $sections);
                                    while ($row  = mysqli_fetch_assoc($section_query)) {
                                    ?>
                            <input type="radio" value=" <?= $row['section_id'] ?>" name="all_section"
                                <?= (isset($_SESSION['old1']['sections']) && in_array($row['section_id'], $_SESSION['old1']['sections'])) ? 'checked' : '' ?>>
                            <?= $row['section'] ?> &nbsp;&nbsp;&nbsp;
                            <?php
                                    }
                                    ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Student Sections</label> <br>
                            <?php
                                    $sections = "SELECT * FROM   section JOIN student_section ON section.section_id = student_section.section_id1 WHERE student_id1 = ?";
                                    $section_query_stmt = mysqli_prepare($connection, $sections);
                                    mysqli_stmt_bind_param($section_query_stmt, 'i', $get_single_student_row['student_id']);
                                    mysqli_stmt_execute($section_query_stmt);
                                    $result = mysqli_stmt_get_result($section_query_stmt);
                                    while ($row = $result->fetch_assoc()) {
                                    ?>

                            <input type="radio" value=" <?= $row['section_id'] ?>" name="student_section" checked>
                            <?= $row['section'] ?> &nbsp;&nbsp;&nbsp;
                            <?php
                                    }
                                    ?>
                        </div>
                    </div>



                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">All Grades </label> <br>
                            <?php

                                    $grades = "SELECT * FROM   grades ";
                                    $grade_query = mysqli_query($connection, $grades);
                                    while ($row  = mysqli_fetch_assoc($grade_query)) {
                                    ?>
                            <input type="radio" id="grade" value="<?= $row['grade_id'] ?>" name="all_grades">
                            <?= $row['grade_code'] . '-' .  $row['grade'] ?> &nbsp;&nbsp;&nbsp;

                            <?php  } ?>
                        </div>

                        <div class="mb-3">
                            <label class="mb-2">Student Grades</label> <br>
                            <?php
                                    $get_single_grade = "SELECT * FROM grades JOIN student_grades ON grades.grade_id =
                                    student_grades.grade_id1 WHERE student_id1 = ? ";
                                    $get_single_res_grade_stmt = mysqli_prepare($connection, $get_single_grade);
                                    mysqli_stmt_bind_param($get_single_res_grade_stmt, 'i', $get_single_student_row['student_id']);
                                    mysqli_stmt_execute($get_single_res_grade_stmt);
                                    $result = mysqli_stmt_get_result($get_single_res_grade_stmt);
                                    while ($get_wor = $result->fetch_assoc()) {
                                    ?>
                            <input type="radio" checked id="grades" value="<?= $get_wor['grade_id'] ?>"
                                name="student_grades">
                            <?= $get_wor['grade_code'] . '-' . $get_wor['grade'] ?> &nbsp;&nbsp;&nbsp;
                            <?php
                                    }
                                    ?>
                        </div>
                    </div>
                </div>


                <button type="submit" class="btn btn-dark" name="submitBtn">Update</button>
            </form>
        </div>

        <div class="card p-3 my-3 shadow-sm">

            <h4><i class="bi  bi-person-check-fill"></i> Edit Student Password</h4>
            <hr>
            <form method="post" action="logic/student-edit-password.php" id="password-form">
                <div class="row">
                    <div class="col">
                        <div class="d-flex justify-content-end alert-div">

                            <?php
                                    if (isset($_GET['message'])) {

                                    ?>
                            <div class=" alert alert-warning alert-div"> <?= $_GET['message'] ?>&nbsp;&nbsp;&nbsp; <a
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
                            <input type="hidden" name="student_id" value="<?= $_GET['student_id'] ?>">
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
    $('#navLink li:nth-child(3) a').addClass('active');
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