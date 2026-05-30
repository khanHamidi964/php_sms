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
    <title>Teacher - Students</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="icon" href="../assets/logo/logo.png">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">





</head>

<body class="bg-light">
    <?php include('common/navbar.php') ?>



    <?php

            $student_id = $_GET['student_id'];
            $query = "SELECT * FROM students  WHERE student_id = ?";
            $query_stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($query_stmt, "i", $student_id);
            mysqli_stmt_execute($query_stmt);
            $result = mysqli_stmt_get_result($query_stmt);
            $row = $result->fetch_assoc();



            $query1 = "SELECT * FROM grades JOIN student_grades  ON grades.grade_id  = student_grades.grade_id1    WHERE student_id1 = ?";
            $query1_stmt = mysqli_prepare($connection, $query1);
            mysqli_stmt_bind_param($query1_stmt, "i", $student_id);
            mysqli_stmt_execute($query1_stmt);
            $result1 = mysqli_stmt_get_result($query1_stmt);
            $row1 = $result1->fetch_assoc();



            $query2 = "SELECT * FROM section JOIN student_section  ON section.section_id  = student_section.section_id1    WHERE student_id1 = ?";
            $query2_stmt = mysqli_prepare($connection, $query2);
            mysqli_stmt_bind_param($query2_stmt, "i", $student_id);
            mysqli_stmt_execute($query2_stmt);
            $result2 = mysqli_stmt_get_result($query2_stmt);
            $row2 = $result2->fetch_assoc();

            $current_time = "SELECT * FROM setting";
            $current_time_stmt = mysqli_prepare($connection, $current_time);

            mysqli_stmt_execute($current_time_stmt);
            $result3 = mysqli_stmt_get_result($current_time_stmt);
            $setting = $result3->fetch_assoc();
            ?>
    <div class="container ">

        <div class="row">

            <div class="col my-5">
                <div class=" my-2 ">

                    <div class="d-flex justify-content-center">
                        <?php
                                if (isset($_GET['message'])) {

                                ?>
                        <div class="alert alert-warning alert-div"> <?= $_GET['message'] ?>&nbsp;&nbsp;&nbsp; <a href=""
                                id="close-btn" class=" text-decoration-none text-danger c-pointer">X</a>
                        </div>
                        <?php

                                } ?>
                    </div>
                </div>
                <div class="data justify-content-center d-flex ">
                    <div class="border border-1 m-2 p-4 bg-white">
                        <a href="student-in-class.php?section_id=<?= $row2['section_id'] ?>&grade_id=<?= $row1['grade_id'] ?>"
                            class="btn btn-dark"><i class="bi bi-arrow-left"></i>
                            Go
                            back</a><br><br>
                        <strong>Id: </strong>
                        <span><?= $row['student_id'] ?></span>
                        <hr>
                        <strong>First Name : </strong>
                        <span><?= $row['fname'] ?></span>
                        <hr>
                        <strong>Last Name : </strong>
                        <span><?= $row['lname'] ?></span>
                        <hr>
                        <strong>Grade : </strong>
                        <span><?= $row1['grade_code'] . '-'  . $row1['grade'] ?></span>
                        <hr> <strong>Section: </strong>
                        <span><?= $row2['section'] ?></span>
                        <hr>
                        <form action="logic/add-grade.php" method="post">
                            <strong class="mb-2">Year </strong><span>
                                <select name="year" id="" class="form-select shadow-none my-2">
                                    <?php

                                            $queryYear = "SELECT * FROM years ";
                                            $query_stmt_year = mysqli_prepare($connection, $queryYear);
                                            mysqli_stmt_execute($query_stmt_year);
                                            $result_year = mysqli_stmt_get_result($query_stmt_year);
                                            $count_year = $result_year->num_rows;
                                            if ($count_year >= 1) {

                                                while ($year_row = $result_year->fetch_assoc()) {
                                                    echo "<option> {$year_row['year']}</option>";
                                                }
                                            } else {
                                                echo "<option>Not fount year</option>";
                                            }



                                            ?>
                                </select>
                            </span><strong>Semester
                            </strong><span>
                                <select name="semester" id="" class="form-select shadow-none my-2">
                                    <?php

                                            $query_semester = "SELECT * FROM semesters ";
                                            $query_stmt_semester = mysqli_prepare($connection, $query_semester);
                                            mysqli_stmt_execute($query_stmt_semester);
                                            $result_semester = mysqli_stmt_get_result($query_stmt_semester);
                                            $count_semester = $result_semester->num_rows;
                                            if ($count_semester >= 1) {

                                                while ($semester_row = $result_semester->fetch_assoc()) {
                                                    echo "<option value='{$semester_row['semester_id']}'> Semester - {$semester_row['semester']}</option>";
                                                }
                                            } else {
                                                echo "<option>Not fount semester</option>";
                                            }



                                            ?>
                                </select></span>
                            <hr>


                            <p for="" class="mb-2 text-center"><strong>Add Grade</strong> </p>
                            <div class="form-group">
                                <label for="form-label ">Course/Subject</label>
                                <select name="subject_id" id="" class="form-select shadow-none mt-2  mb-2">
                                    <?php

                                            $subject = "SELECT * FROM subjects JOIN teacher_subjects  ON subjects.subject_id  = teacher_subjects.subject_id1    WHERE teacher_id1 = ?";
                                            $subject_stmt = mysqli_prepare($connection, $subject);
                                            mysqli_stmt_bind_param($subject_stmt, "i", $_SESSION['id']);
                                            mysqli_stmt_execute($subject_stmt);
                                            $result3 = mysqli_stmt_get_result($subject_stmt);
                                            $count1  = $result3->num_rows;

                                            if ($count1 >= 1) {
                                                while ($subject_row = $result3->fetch_assoc()) {
                                            ?>
                                    <option value="<?= $subject_row['subject_id'] ?>">
                                        <?= $subject_row['subject_code'] ?>
                                    </option>
                                    <?php
                                                }
                                            } else {
                                                echo "<option> No subject or course </option>";
                                            }

                                            ?>


                                </select>
                                <div class="input-group">

                                    <input type="hidden" name="student_id" value="<?= $_GET['student_id'] ?>">
                                    <input type="number" name="score" class="form-control  shadow-none "
                                        style="width: 200px;" value="0" max=' 100' min='0'>
                                    <button class="btn btn-light">/</button>
                                    <input type="number" class="form-control shadow-none" value="100" max='100'
                                        min='100' style="width: 200px;">
                                </div>
                                <div class="input-group mt-2">
                                    <button class="btn btn-dark">Add</button>
                                </div>
                            </div>
                        </form>
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
    $('#navLink li:nth-child(3) a').addClass('active')


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