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
            <div class="row">
                <div class="card p-3 my-3 shadow">
                    <div class="d-flex justify-content-between">
                        <h4> <i class="bi bi-person-fill"></i> Your Details </h4>

                    </div>
                    <hr>
                    <?php

                            if (isset($_SESSION['id'])) {

                                $teacher_id = $_SESSION['id'];
                                if (is_numeric($teacher_id)) {

                                    $get_Single_teacher_query = "SELECT * FROM teachers WHERE teacher_id = ?
                                 LIMIT 1";
                                    $get_single_teacher_result_stmt = mysqli_prepare($connection, $get_Single_teacher_query);
                                    mysqli_stmt_bind_param($get_single_teacher_result_stmt, 'i', $teacher_id);
                                    mysqli_stmt_execute($get_single_teacher_result_stmt);
                                    $get_row = mysqli_stmt_get_result($get_single_teacher_result_stmt);
                                    $get_single_teacher_row = $get_row->fetch_assoc();
                                } else {
                                    $mess = 'teacher id is not a number ';
                                    header("location: teacher.php?error=$mess");
                                }
                            } else {
                                $mess = 'Somethings went wrong ';
                                header("location: teacher.php?error=$mess");
                            }



                            ?>


                    <div class="row">
                        <div class="col-md-4">
                            <img src="../<?= $get_single_teacher_row['profile'] ?>" class=" img-thumbnail" alt="">
                        </div>
                        <div class="col-md-4">
                            <div class=" table-responsive ">
                                <table class="table">
                                    <tr>
                                        <th>User Name</th>
                                        <td>@<?= $get_single_teacher_row['username'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>First Name</th>
                                        <td><?= $get_single_teacher_row['fname'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Last Name</th>
                                        <td><?= $get_single_teacher_row['lname'] ?></td>
                                    </tr>

                                    <tr>
                                        <th>Address</th>
                                        <td><?= $get_single_teacher_row['address'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Date of birth</th>
                                        <td><?= $get_single_teacher_row['date_of_birth'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Gender </th>
                                        <td><?= $get_single_teacher_row['gender'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><?= $get_single_teacher_row['email'] ?></td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class=" table-responsive">
                                <table class="table">
                                    <tr class="">
                                        <th>Classes</th>
                                        <?php
                                                $grades = "SELECT * FROM teacher_class JOIN classes ON teacher_class.class_id1 = classes.class_id JOIN grades ON classes.grade_id = grades.grade_id JOIN section ON classes.section_id = section.section_id    WHERE teacher_id1 = {$get_single_teacher_row['teacher_id']} ";
                                                $grade_query = mysqli_query($connection, $grades);
                                                while ($row  = mysqli_fetch_assoc($grade_query)) {
                                                ?>
                                        <td><?= $row['grade_code'] . '-' . $row['grade'] . $row['section']; ?> , </td>
                                        <?php

                                                } ?>
                                    </tr>
                                    <tr class="">
                                        <th>Subjects</th>

                                        <?php

                                                $subject = "SELECT * FROM   subjects JOIN teacher_subjects ON subjects.subject_id = teacher_subjects.subject_id1 WHERE teacher_id1 = {$get_single_teacher_row['teacher_id']} ";
                                                $subject_query = mysqli_query($connection, $subject);
                                                while ($row  = mysqli_fetch_assoc($subject_query)) {
                                                ?>
                                        <td><?= $row['subject']; ?> , </td>
                                        <?php

                                                } ?>

                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/jquery.js"></script>


</body>

<script>
$(document).ready(function() {
    $('#navLink li:nth-child(1) a').addClass('active')
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