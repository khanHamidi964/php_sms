<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Student') {


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Student - home</title>
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

                                $student_id = $_SESSION['id'];
                                if (is_numeric($student_id)) {

                                    $get_Single_student_query = "SELECT * FROM students WHERE student_id = ?
                                 LIMIT 1";
                                    $get_single_student_result_stmt = mysqli_prepare($connection, $get_Single_student_query);
                                    mysqli_stmt_bind_param($get_single_student_result_stmt, 'i', $student_id);
                                    mysqli_stmt_execute($get_single_student_result_stmt);
                                    $get_row = mysqli_stmt_get_result($get_single_student_result_stmt);
                                    $get_single_student_row = $get_row->fetch_assoc();
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
                        <div class="col-md-4">
                            <img src="../<?= $get_single_student_row['profile'] ?>" alt="" class=" w-100 img-thumbnail">
                        </div>
                        <div class="col-md-4">
                            <div class=" table-responsive ">
                                <table class="table">
                                    <tr>
                                        <th>User Name</th>
                                        <td>@<?= $get_single_student_row['username'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>First Name</th>
                                        <td><?= $get_single_student_row['fname'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Last Name</th>
                                        <td><?= $get_single_student_row['lname'] ?></td>
                                    </tr>

                                    <tr>
                                        <th>Address</th>
                                        <td><?= $get_single_student_row['address'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Date of birth</th>
                                        <td><?= $get_single_student_row['date_of_birth'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Gender </th>
                                        <td><?= $get_single_student_row['gender'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><?= $get_single_student_row['email'] ?></td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class=" table-responsive">
                                <table class="table">
                                    <tr class="">
                                        <th>Sections</th>

                                        <?php

                                                $sections = "SELECT * FROM   section JOIN student_section ON section.section_id = student_section.section_id1 WHERE student_id1 = {$get_single_student_row['student_id']} ";
                                                $section_query = mysqli_query($connection, $sections);
                                                while ($row  = mysqli_fetch_assoc($section_query)) {
                                                ?>
                                        <td><?= $row['section']; ?> , </td>
                                        <?php

                                                } ?>

                                    </tr>

                                    <tr class="">
                                        <th>Grades</th>

                                        <?php

                                                $grades = "SELECT * FROM   grades JOIN student_grades ON grades.grade_id = student_grades.grade_id1 WHERE student_id1 = {$get_single_student_row['student_id']} ";
                                                $grade_query = mysqli_query($connection, $grades);
                                                while ($row  = mysqli_fetch_assoc($grade_query)) {
                                                ?>
                                        <td><?= $row['grade_code'] . '-' . $row['grade']; ?> , </td>
                                        <?php

                                                } ?>

                                    </tr>
                                    <tr>
                                        <th>Parent First Name</th>
                                        <td><?= $get_single_student_row['parent_first_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Parent Last Name</th>
                                        <td><?= $get_single_student_row['parent_last_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Parent Phone Number</th>
                                        <td><?= $get_single_student_row['parent_phone_number'] ?></td>
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