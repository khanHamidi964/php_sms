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
            <title>Admin- Edit teacher</title>
            <link rel="stylesheet" href="../assets/css/bootstrap.css">
            <link rel="stylesheet" href="../assets/css/home.css">
            <link rel="icon" href="../assets/logo/logo.png">
            <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">
            <link rel="stylesheet" href="css/view.css">

        </head>

        <body class="bg-light">
            <?php include('common/navbar.php') ?>
            <?php include('../config/DB-connection.php') ?>

            <div class="container mt-4">
                <div class="container ">
                    <div class="card p-3 my-3 shadow">
                        <div class="d-flex justify-content-between">

                            <h4> <i class="bi bi-person-fill "></i> Teacher Details </h4>
                            <a href="teacher.php" class="btn btn-dark"> <i class="bi bi-arrow-left"></i> Go back</a>
                        </div>
                        <hr>


                        <?php

                        if (isset($_GET['teacher_id'])) {

                            $teacher_id = $_GET['teacher_id'];
                            if (is_numeric($teacher_id)) {

                                $get_Single_teacher_query = "SELECT * FROM teachers WHERE teacher_id = {$teacher_id} LIMIT 1";
                                $get_single_teacher_result = mysqli_query($connection, $get_Single_teacher_query);
                                $get_single_teacher_row = mysqli_fetch_assoc($get_single_teacher_result);
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
                                            <th>Employee Number </th>
                                            <td><?= $get_single_teacher_row['employee_number'] ?></td>
                                        </tr>

                                    </table>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class=" table-responsive">
                                    <table class="table">

                                        <tr>
                                            <th>Phone Number</th>
                                            <td><?= $get_single_teacher_row['phone_number'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Qualification</th>
                                            <td><?= $get_single_teacher_row['qualification'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Gender </th>
                                            <td><?= $get_single_teacher_row['gender'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td><?= $get_single_teacher_row['email'] ?></td>
                                        </tr>
                                        <tr class="">
                                            <th>Subjects</th>

                                            <?php

                                            $subjects = "SELECT * FROM   subjects JOIN teacher_subjects ON subjects.subject_id = teacher_subjects.subject_id1 WHERE teacher_id1 = {$get_single_teacher_row['teacher_id']} ";
                                            $subject_query = mysqli_query($connection, $subjects);
                                            while ($row  = mysqli_fetch_assoc($subject_query)) {
                                            ?>
                                                <td><?= $row['subject']; ?> , </td>
                                            <?php

                                            } ?>

                                        </tr>
                                        <tr class="">
                                            <th>Class </th>

                                            <?php

                                            $grades = "SELECT * FROM teacher_class JOIN classes ON teacher_class.class_id1 = classes.class_id JOIN grades ON classes.grade_id = grades.grade_id JOIN section ON classes.section_id = section.section_id    WHERE teacher_id1 = {$get_single_teacher_row['teacher_id']} ";
                                            $grade_query = mysqli_query($connection, $grades);
                                            while ($row  = mysqli_fetch_assoc($grade_query)) {
                                            ?>
                                                <td><?= $row['grade_code'] . '-' . $row['grade'] . $row['section']; ?> , </td>
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



            <script src="../assets/js/bootstrap.js"></script>
            <script src="../assets/js/jquery.js"></script>

            <script>
                $(document).ready(function() {
                    $('#navLink li:nth-child(2) a').addClass('active')
                })
            </script>
        </body>


        </html>

<?php

    } else {
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
}

?>