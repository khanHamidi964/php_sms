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
    <title>Admin - Message</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="icon" href="../assets/logo/logo.png">
    <link rel="stylesheet" href="../assets/css/bootstrapIcon.css">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="stylesheet" href="css/message.css">



</head>

<body class="bg-light">
    <?php include('common/navbar.php') ?>
    <?php include('../config/DB-connection.php') ?>

    <div class="container mt-4">
        <div class="d-flex justify-content-center  shadow p-2 mb-3">


            <div>
                <h1>Inbox</h1>
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
                <div class="d-flex justify-content-end my-2">
                    <a href="logic/message-all-delete.php"
                        onclick="return confirm('are you sure for deleting the all message ') "
                        class="btn btn-danger btn-sm mx-2">Delete
                        all</a>

                    <a href="logic/message-all-check.php?status=read" class="btn btn-success btn-sm "
                        onclick="return confirm('You read the all message ')">Read all</a>
                </div>
                <thead>

                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Message </th>
                        <th scope="col" style="width: 100px;">Date</th>
                        <th scope="col">Status</th>


                    </tr>

                </thead>
                <tbody>
                    <?php
                            $query = "SELECT * FROM messages ORDER BY message_id DESC";
                            $query_stmt = mysqli_prepare($connection, $query);
                            mysqli_stmt_execute($query_stmt);
                            $result = mysqli_stmt_get_result($query_stmt);

                            $count = $result->num_rows;
                            if ($count >= 1) {

                                $count11 = 0;

                                while ($row = $result->fetch_assoc()) {
                                    $count11++;
                            ?>
                    <tr class="text-center">
                        <td><?= $count11 ?></td>
                        <td><?= $row['send_full_name'] ?></td>
                        <td><?= $row['send_email'] ?></td>
                        <td><?= $row['send_message'] ?></td>
                        <td><?= $row['created_at'] ?></td>
                        <td><?php

                                            if ($row['read_status'] == "read") {
                                            ?>

                            <form action="logic/message-check.php" method="post">
                                <input type="hidden" name="status" value="unread">
                                <input type="hidden" name="message_id" value="<?= $row['message_id'] ?>">
                                <button class="btn btn-success btn-sm">Read</button>
                            </form>

                            <a href="logic/message-delete.php?message_id=<?= $row['message_id'] ?>"
                                class="btn btn-danger btn-sm m-2"
                                onclick=" return confirm('Are you Sure for deleting the message')">Delete</a>
                            <?php
                                            } else {
                                            ?>

                            <form action="logic/message-check.php" method="post">
                                <input type="hidden" name="status" value="read">
                                <input type="hidden" name="message_id" value="<?= $row['message_id'] ?>">
                                <button class="btn btn-info btn-sm">Unread</button>
                            </form>
                            <a href="logic/message-delete.php?message_id=<?= $row['message_id'] ?>"
                                class="btn btn-danger btn-sm m-2"
                                onclick=" return confirm('Are you Sure for deleting the message')">Delete</a>

                            <?php
                                            }



                                            $row['read_status'] ?>
                        </td>
                    </tr>


                    <?php
                                }
                            } else {
                                ?>

                    <tr>
                        <td colspan="6">
                            <div class="alert alert-info text-center">No Inbox</div>
                        </td>
                    </tr>
                    <?php
                            }




                            ?>
                    <tr></tr>
                </tbody>

            </table>
        </div>

    </div>

    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/jquery.js"></script>

</body>

<script>
$(document).ready(function() {
    $('#navLink li:nth-child(9) a').addClass('active')

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