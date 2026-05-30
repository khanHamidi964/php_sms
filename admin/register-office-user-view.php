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
    <title>Admin- Register Office View</title>
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

                    <h4> <i class="bi bi-person-fill "></i> User Details </h4>
                    <a href="register-office.php" class="btn btn-dark"> <i class="bi bi-arrow-left"></i> Go back</a>
                </div>
                <hr>


                <?php

                        if (isset($_GET['r_user_id'])) {

                            $r_user_id = $_GET['r_user_id'];
                            if (is_numeric($r_user_id)) {

                                $get_Single_user_query = "SELECT * FROM registerer_office WHERE r_user_id = ? LIMIT 1";
                                $get_Single_user_query_stmt = mysqli_prepare($connection ,$get_Single_user_query);
                                mysqli_stmt_bind_param($get_Single_user_query_stmt , 'i' , $r_user_id);
                                mysqli_stmt_execute($get_Single_user_query_stmt);
                                $get_single_user_result = mysqli_stmt_get_result($get_Single_user_query_stmt);
                                $get_single_user_row = $get_single_user_result->fetch_assoc();
                            } else {
                                $mess = 'user id is not a number ';
                                header("location: register-office.php?error=$mess");
                            }
                        } else {
                            $mess = 'Somethings went wrong ';
                            header("location: register-office.php?error=$mess");
                        }



                        ?>


                <div class="row">
                    <div class="col-md-4">
                        <img src="../<?= $get_single_user_row['profile'] ?>" class=" img-thumbnail" alt="">
                    </div>
                    <div class="col-md-4">
                        <div class=" table-responsive ">
                            <table class="table">
                                <tr>
                                    <th>User Name</th>
                                    <td>@<?= $get_single_user_row['username'] ?></td>
                                </tr>
                                <tr>
                                    <th>First Name</th>
                                    <td><?= $get_single_user_row['fname'] ?></td>
                                </tr>
                                <tr>
                                    <th>Last Name</th>
                                    <td><?= $get_single_user_row['lname'] ?></td>
                                </tr>

                                <tr>
                                    <th>Address</th>
                                    <td><?= $get_single_user_row['address'] ?></td>
                                </tr>
                                <tr>
                                    <th>Date of birth</th>
                                    <td><?= $get_single_user_row['date_of_birth'] ?></td>
                                </tr>
                                <tr>
                                    <th>Employee Number </th>
                                    <td><?= $get_single_user_row['employee_number'] ?></td>
                                </tr>
                                <tr>
                                    <th>Phone Number</th>
                                    <td><?= $get_single_user_row['phone_number'] ?></td>
                                </tr>

                            </table>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class=" table-responsive">
                            <table class="table">

                                <tr>
                                    <th>Qualification</th>
                                    <td><?= $get_single_user_row['qualification'] ?></td>
                                </tr>
                                <tr>
                                    <th>Gender </th>
                                    <td><?= $get_single_user_row['gender'] ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?= $get_single_user_row['email'] ?></td>
                                </tr>
                                <tr>
                                    <th>Join date</th>
                                    <td><?= $get_single_user_row['join_date'] ?></td>
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
        $('#navLink li:nth-child(7) a').addClass('active')
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