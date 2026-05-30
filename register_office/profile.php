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
    <title> Register Office - Profile</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="icon" href="../assets/logo/logo.png">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../admin/css/teacher-view.css">

</head>

<body class="bg-light">
    <?php include('common/navbar.php') ?>


    <div class="container mt-4">
        <div class="container ">
            <div class="card p-3 my-3 shadow">
                <div class="d-flex justify-content-between">

                    <h4> <i class="bi bi-person-fill "></i> Profile Details </h4>
                    <a href="index.php" class="btn btn-dark"> <i class="bi bi-arrow-left"></i> Go back</a>
                </div>
                <hr>


                <?php

                        if (isset($_SESSION['id'])) {

                            $r_user_id = $_SESSION['id'];
                            if (is_numeric($r_user_id)) {

                                $get_Single_user_query = "SELECT * FROM registerer_office WHERE r_user_id = {$r_user_id} LIMIT 1";
                                $get_single_user_result = mysqli_query($connection, $get_Single_user_query);
                                $get_single_user_row = mysqli_fetch_assoc($get_single_user_result);
                            } else {
                                $mess = 'user id is not a number ';
                                header("location: index.php?error=$mess");
                            }
                        } else {
                            $mess = 'Somethings went wrong ';
                            header("location: index.php?error=$mess");
                        }



                        ?>


                <div class="row">
                    <div class="col-md-4">
                        <img src="../<?= $get_single_user_row['profile'] ?>" alt="" class=" img-thumbnail">
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
        $('#navLink li:nth-child(4) a').addClass('active')
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