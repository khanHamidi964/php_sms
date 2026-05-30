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


    <div class="container mt-4">

        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-end alert-div">
                    <?php
                            if (isset($_GET['error'])) {
                            ?>
                    <div class="alert alert-warning alert-div"> <?= $_GET['error'] ?>&nbsp;&nbsp;&nbsp; <a href=""
                            id="close-btn" class=" text-decoration-none text-danger c-pointer">X</a>
                    </div>
                    <?php

                            } ?>

                </div>
            </div>
        </div>
        <div class=" table-responsive n-table  mt-2">
            <table class="table table-bordered table-hover shadow">
                <thead>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">First name</th>
                        <th scope="col">Last name</th>
                        <th scope="col">User name</th>
                        <th scope="col">Grade</th>

                    </tr>
                </thead>
                <tbody>

                    <?php

                            $student_query = "SELECT * FROM students JOIN student_section ON students.student_id = student_section.student_id1 JOIN student_grades ON students.student_id = student_grades.student_id1 WHERE section_id1 = {$_GET['section_id']} AND grade_id1 = {$_GET['grade_id']}";
                            $student_result = mysqli_query($connection,  $student_query);
                            if (mysqli_num_rows($student_result) > 0) {
                                $count = 0;
                                while ($students = mysqli_fetch_assoc($student_result)) {
                                    $count++;
                            ?>
                    <tr class="text-center">
                        <th scope="row"><?= $count ?></th>
                        <td scope="row"><?= $students['student_id'] ?></td>
                        <td><a
                                href="add-grade.php?student_id=<?php echo $students['student_id'] ?>"><?= $students['fname'] ?></a>
                        </td>
                        <td><?= $students['lname'] ?></td>
                        <td><?= $students['username'] ?></td>
                        <td>
                            <?php

                                            $grades = "SELECT * FROM student_grades JOIN grades ON student_grades.grade_id1 = grades.grade_id  WHERE student_id1 = ?";
                                            $grade_stmt = mysqli_prepare($connection, $grades);
                                            mysqli_stmt_bind_param($grade_stmt, 'i', $students['student_id']);
                                            mysqli_stmt_execute($grade_stmt);
                                            $result  = mysqli_stmt_get_result($grade_stmt);
                                            $data = '';
                                            while ($row  = $result->fetch_assoc()) {
                                                $data .= $row['grade_code'] . '-' . $row['grade'] . ', ';
                                            }
                                            echo $data;
                                            ?>
                        </td>

                    </tr>

                    <?php
                                }
                            } else {

                                ?>
                    <tr>
                        <td colspan="7">
                            <div class="alert alert-info">Empty!</div>

                        </td>
                    </tr>
                    <?php
                            }
                            ?>

                </tbody>
            </table>
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