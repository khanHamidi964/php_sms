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
    <title>Admin - Register Office</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="icon" href="../assets/logo/logo.png">
    <link rel="stylesheet" href="../assets/css/bootstrapIcon.css">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/home.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body class="bg-light">
    <?php include('common/navbar.php') ?>

    <?php include('../config/DB-connection.php') ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-end  shadow p-2 mb-3">


            <div>
                <a href="register-office-add.php" class="btn btn-dark"> <i class="bi bi-plus"> </i> Add New User</a>
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
        <div class=" table-responsive n-table  mt-3 ">
            <table class="table table-bordered table-hover shadow  ">
                <thead>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">First name</th>
                        <th scope="col">Last name</th>
                        <th scope="col">User name</th>
                        <th scope="col">Qualification</th>
                        <th scope="col">Date Of Birth</th>
                        <th scope="col">Profile</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>

                    <?php

                            $r_user_query = "SELECT * FROM registerer_office";
                            $r_user_query_stmt = mysqli_prepare($connection, $r_user_query);
                            mysqli_stmt_execute($r_user_query_stmt);
                            $r_user_result = mysqli_stmt_get_result($r_user_query_stmt);
                            if ($r_user_result->num_rows >= 0) {

                                $count = 0;
                                while ($r_users = $r_user_result->fetch_assoc()) {
                                    $count++;
                            ?>
                    <tr class="text-center">
                        <th scope="row"><?= $count ?></th>
                        <td scope="row"><?= $r_users['r_user_id'] ?></td>
                        <td><?= $r_users['fname'] ?> </td>
                        <td><?= $r_users['lname'] ?></td>
                        <td><?= $r_users['username'] ?></td>
                        <td><?= $r_users['qualification'] ?></td>
                        <td><?= $r_users['date_of_birth'] ?></td>
                        <td>
                            <img src="../<?= $r_users['profile'] ?>" class="img-thumbnail" alt="" width="50px"
                                height="50px">
                        </td>



                        <td>
                            <a href="register-office-edit.php?r_user_id=<?= $r_users['r_user_id'] ?>"
                                class="btn btn-warning text-black"><i class="bi bi-pen-fill"></i></a>
                            <a href="register-office-user-view.php?r_user_id=<?= $r_users['r_user_id'] ?>"
                                class="btn btn-info text-black"><i class="bi bi-eye"></i></a>
                           <a href="logic/register-office-delete.php?r_user_id=<?= $r_users['r_user_id'] ?>"
   class="btn btn-danger delete-register-user">
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
    $('#navLink li:nth-child(7) a').addClass('active')


    $('#close-btn').on('click', function(e) {
        e.preventDefault()
        $('.alert-div').removeClass('alert alert-warning').addClass('text-white')
        $('#close-btn').removeClass('text-danger').addClass('text-white')
    })
})
</script>
<script>
document.querySelectorAll('.delete-register-user').forEach(button => {

    button.addEventListener('click', function(e) {

        e.preventDefault();

        const deleteUrl = this.href;

        Swal.fire({
            title: 'Delete User?',
            html: `
                <p>The Register Office user will be permanently deleted.</p>
                <small>This action cannot be undone.</small>
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