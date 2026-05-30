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
    <title>Admin - Teachers</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="icon" href="../assets/logo/logo.png">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="stylesheet" href="css/home.css">



</head>

<body class="bg-light">
    <?php include('common/navbar.php') ?>

    <?php include('../config/DB-connection.php') ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-between  shadow p-2 mb-4">

            <div class="">
                <form action="teacher-search.php" id="search-form" method="post">
                    <div class="input-group">
                        <input type="text" placeholder="Search..." class="form-control shadow-none" name="search"
                            value="<?= $_POST['search'] ?>">
                        <button class="btn btn-primary"> <i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
            <div>
                <a href="teacher-add.php" class="btn btn-dark"><i class="bi bi-plus"></i> Add new teacher</a>
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
                        <th scope="col">Subject</th>
                        <th scope="col">Class</th>
                        <th scope="col">Profile</th>

                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>

                    <?php

                            $search = $_POST['search'];

                            $tech_query = "SELECT * FROM teachers WHERE fname LIKE '%$search%' OR lname LIKE  '%$search%'  OR username LIKE '%$search%'";
                            $tech_result = mysqli_query($connection,  $tech_query);
                            if (mysqli_num_rows($tech_result) > 0) {

                                $count = 0;
                                while ($teachers = mysqli_fetch_assoc($tech_result)) {
                                    $count++;
                            ?>
                    <tr class="text-center">
                        <th scope="row"><?= $count ?></th>
                        <td scope="row"><?= $teachers['teacher_id'] ?></td>
                        <td><?= $teachers['fname'] ?> </td>
                        <td><?= $teachers['lname'] ?></td>
                        <td><?= $teachers['username'] ?></td>

                        <td>
                            <?php

                                            $grades = "SELECT * FROM teacher_subjects JOIN subjects ON teacher_subjects.subject_id1 = subjects.subject_id  WHERE teacher_id1 = '{$teachers['teacher_id']}'";

                                            $grade_query = mysqli_query($connection, $grades);

                                            $data = '';
                                            while ($row  = mysqli_fetch_assoc($grade_query)) {
                                                $data .= $row['subject_code'] . ',  ';
                                            }
                                            echo $data;
                                            ?>
                        </td>
                        <td>
                            <?php

                                            $class = "SELECT * FROM teacher_class JOIN classes ON teacher_class.class_id1 = classes.class_id JOIN grades ON classes.grade_id = grades.grade_id JOIN section ON classes.section_id = section.section_id    WHERE teacher_id1 = '{$teachers['teacher_id']}'";

                                            $class_query = mysqli_query($connection, $class);

                                            $data = '';
                                            while ($row  = mysqli_fetch_assoc($class_query)) {
                                                $data .=  $row['grade_code'] . '-' . $row['grade'] .  $row['section'] . ', ';
                                            }
                                            echo $data;
                                            ?>
                        </td>
                        <td>
                            <img src="../<?= $teachers['profile'] ?>" class=" img-thumbnail"
                                style=" width:50px; height:50px; " lt="">
                        </td>
                        <td>
                            <a href="teacher-edit.php?teacher_id=<?= $teachers['teacher_id'] ?>"
                                class="btn btn-warning text-black"><i class="bi bi-pen-fill"></i></a>
                            <a href="teacher-view.php?teacher_id=<?= $teachers['teacher_id'] ?>"
                                class="btn btn-info text-black"><i class="bi bi-eye"></i></a>
                            <a href="logic/teacher-delete.php?teacher_id=<?= $teachers['teacher_id'] ?>"
                                class="btn btn-danger "
                                onclick="return confirm('are you sure for deleting the teacher')"><i
                                    class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>



                    <?php
                                }
                            } else {

                                ?>
                    <tr>
                        <td colspan="8">
                            <div class="alert alert-info">Not found user!</div>
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
    $('#navLink li:nth-child(2) a').addClass('active')


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