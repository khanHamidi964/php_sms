<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Register Office') {


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Office - Students</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="icon" href="../assets/logo/logo.png">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="stylesheet" href="../admin/css/home.css">



</head>

<body class="bg-light">
    <?php include('common/navbar.php') ?>


    <div class="container mt-4">
        <div class="d-flex justify-content-between  shadow p-2 mb-3">

            <div class="">
                <form action="student-search.php" id="search-form" method="post">
                    <div class="input-group">
                        <input type="text" placeholder="Search..." class="form-control shadow-none" name="search"
                            value="<?= $_POST['search'] ?>">
                        <button class="btn btn-primary"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
            <div>
                <a href="student-add.php" class="btn btn-dark"> <i class="bi bi-plus"></i> Add new student</a>
            </div>
        </div>
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
                        <th scope="col">Profile</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>

                    <?php
                            $search = $_POST['search'];
                            $student_query = "SELECT * FROM students WHERE fname LIKE '%$search%' OR lname LIKE  '%$search%'  OR username LIKE '%$search%' ";
                            $student_result = mysqli_query($connection,  $student_query);
                            if (mysqli_num_rows($student_result) > 0) {
                                $count = 0;
                                while ($students = mysqli_fetch_assoc($student_result)) {
                                    $count++;
                            ?>
                    <tr class="text-center">
                        <th scope="row"><?= $count ?></th>
                        <td scope="row"><?= $students['student_id'] ?></td>
                        <td><?= $students['fname'] ?> </td>
                        <td><?= $students['lname'] ?></td>
                        <td><?= $students['username'] ?></td>
                        <td>
                            <?php

                                            $grades = "SELECT * FROM student_grades JOIN grades ON student_grades.grade_id1 = grades.grade_id  WHERE student_id1 = '{$students['student_id']}'";

                                            $grade_query = mysqli_query($connection, $grades);

                                            $data = '';
                                            while ($row  = mysqli_fetch_assoc($grade_query)) {
                                                $data .= $row['grade_code'] . '-' . $row['grade'] . ', ';
                                            }
                                            echo $data;
                                            ?>
                        </td>
                        <td>
                            <img src="../<?= $students['profile'] ?>" class="img-thumbnail" alt="" width="50px"
                                height="50px">
                        </td>
                        <td>
                            <a href="student-edit.php?student_id=<?= $students['student_id'] ?>"
                                class="btn btn-warning text-dark"><i class="bi bi-pen-fill"></i></a>
                            <a href="student-view.php?student_id=<?= $students['student_id'] ?>"
                                class="btn btn-info text-dark"><i class="bi bi-eye"></i></a>
                            <a href="logic/student-delete.php?student_id=<?= $students['student_id'] ?>"
                                class="btn btn-danger"
                                onclick="return confirm('are you sure for deleting the student')"><i
                                    class="bi bi-trash"></i>
                            </a>
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