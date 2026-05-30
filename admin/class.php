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
    <title>Admin - Classes</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="icon" href="../assets/logo/logo.png">
    <link rel="stylesheet" href="../assets/css/bootstrapIcon.css">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<link rel="stylesheet" href="css/home.css">
</head>

<body class="">
    <?php include('common/navbar.php') ?>

    <?php include('../config/DB-connection.php') ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-end  shadow p-2 mb-3">


            <div>
                <a href="class-add.php" class="btn btn-dark"><i class="bi bi-plus"></i> Add New Class</a>
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
                        <th scope="col">Class</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>

                    <?php

                            $class_query = "SELECT * FROM classes";
                            $class_query_stmt = mysqli_prepare($connection , $class_query);
                             mysqli_stmt_execute($class_query_stmt);

                             $result = mysqli_stmt_get_result($class_query_stmt);
                            $count_class = $result->num_rows;
                            if ($count_class> 0) {

                                $count = 0;
                                while ($class = $result->fetch_assoc()) {
                                    $count++;
                            ?>
                    <tr class="text-center">
                        <th scope="row"><?= $count ?></th>
                        <td scope="row"><?= $class['class_id'] ?></td>
                        <?php

                                        $grades = "SELECT * FROM grades WHERE grade_id = ?";
                                        $grades_stmt = mysqli_prepare($connection ,$grades);
                                        mysqli_stmt_bind_param($grades_stmt , 'i' , $class['grade_id']);
                                        mysqli_stmt_execute($grades_stmt);
                                        $grades_result = mysqli_stmt_get_result($grades_stmt);
                                        $grades_row = $grades_result->fetch_assoc();
                                        
                                        $sections = "SELECT * FROM section WHERE section_id =?";
                                        $section_stmt =mysqli_prepare($connection , $sections);
                                        mysqli_stmt_bind_param($section_stmt , 'i' , $class['section_id']);
                                        mysqli_stmt_execute($section_stmt);
                                        $section_result = mysqli_stmt_get_result($section_stmt);
                                        $section_row = $section_result->fetch_assoc();
                                        ?>
                        <td><?= $grades_row['grade_code'] .  '-' . $grades_row['grade'] . $section_row['section'] ?>
                        </td>






                        <td>
                            <a href="class-edit.php?class_id=<?= $class['class_id'] ?>"
                                class="btn btn-warning text-dark"><i class="bi bi-pen-fill"></i></a>
                            <a href="logic/class-delete.php?class_id=<?= $class['class_id'] ?>"
   class="btn btn-danger delete-class">
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
    $('#navLink li:nth-child(6) a').addClass('active')




    $('#close-btn').on('click', function(e) {
        e.preventDefault()
        $('.alert-div').removeClass('alert alert-warning').addClass('text-white')
        $('#close-btn').removeClass('text-danger').addClass('text-white')
    })
})
</script>
<script>
document.querySelectorAll('.delete-class').forEach(button => {

    button.addEventListener('click', function(e) {

        e.preventDefault();

        const deleteUrl = this.href;

        Swal.fire({
            title: 'Delete Class?',
            html: `
                <strong>This action cannot be undone.</strong><br>
                The class will be permanently deleted.
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