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
    <title>Admin - Course</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="icon" href="../assets/logo/logo.png">
    <link rel="stylesheet" href="../assets/css/bootstrapIcon.css">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="css/home.css">


</head>

<body class="bg-light">
    <?php include('common/navbar.php') ?>

    <?php include('../config/DB-connection.php') ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-end  shadow p-2 mb-3">


            <div>
                <a href="course-add.php" class="btn btn-dark"><i class="bi bi-plus"></i> Add New Course</a>
            </div>
        </div>


        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-end alert-div">
                    <?php
                            if (isset($_GET['mess'])) {
                            ?>
                    <div class="alert alert-warning alert-div"> <?= $_GET['mess'] ?>&nbsp;&nbsp;&nbsp; <a href=""
                            id="close-btn" class=" text-decoration-none text-danger c-pointer">X</a>
                    </div>
                    <?php
                            } ?>
                </div>
            </div>
        </div>
        <div class=" table-responsive n-table  mt-3">
            <table class="table table-bordered table-hover shadow ">
                <thead>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">Course</th>
                        <th scope="col">Course Code</th>
                        <th scope="col">Grade </th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                            $subject_query = "SELECT * FROM subjects";
                            $subject_query_stmt = mysqli_prepare($connection , $subject_query);
                            mysqli_stmt_execute($subject_query_stmt);
                            $subject_result = mysqli_stmt_get_result($subject_query_stmt);
                            if ($subject_result->num_rows > 0) {

                                $count = 0;
                                while ($subject = $subject_result->fetch_assoc()) {
                                    $count++;
                            ?>
                    <tr class="text-center">
                        <th scope="row"><?= $count ?></th>
                        <td scope="row"><?= $subject['subject_id'] ?></td>
                        <td><?= $subject['subject']  ?> </td>
                        <td><?= $subject['subject_code']  ?> </td>
                        <td><?php
                            $get_grade= "SELECT * FROM grades WHERE grade_id = ?";
                            $get_grade_stmt =mysqli_prepare($connection , $get_grade);
                            mysqli_stmt_bind_param($get_grade_stmt , 'i'  , $subject['grade']);
                            mysqli_stmt_execute($get_grade_stmt);
                            $get_grade_query = mysqli_stmt_get_result($get_grade_stmt);
                            while($get_grade_row = mysqli_fetch_assoc($get_grade_query)){
                                
                                echo $get_grade_row['grade_code'] . '-' . $get_grade_row['grade'];
                            }
                        
                        ?></td>
                        <td>
                            <a href="course-edit.php?subject_id=<?= $subject['subject_id'] ?>"
                                class="btn btn-warning text-dark"><i class="bi bi-pen-fill"></i></a>
                           <a href="logic/course-delete.php?subject_id=<?= $subject['subject_id'] ?>"
   class="btn btn-danger delete-subject">
    <i class="bi bi-trash"></i>
</a>
                        </td>
                    </tr>
                    <?php
                                }
                            } else {

                                ?>
                    <tr>
                        <td colspan="8">
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
    $('#navLink li:nth-child(8) a').addClass('active')

    $('#close-btn').on('click', function(e) {
        e.preventDefault()
        $('.alert-div').removeClass('alert alert-warning').addClass('text-white')
        $('#close-btn').removeClass('text-danger').addClass('text-white')
    })
})
</script>
<script>
document.querySelectorAll('.delete-subject').forEach(button => {

    button.addEventListener('click', function(e) {

        e.preventDefault();

        const deleteUrl = this.href;

        Swal.fire({
            title: 'Delete Subject?',
            html: `
                <strong>This action cannot be undone.</strong><br>
                The subject will be permanently deleted.
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-trash"></i> Delete',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {

            if (result.isConfirmed) {
                window.location.href = deleteUrl;
            }

        });

    });

});
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