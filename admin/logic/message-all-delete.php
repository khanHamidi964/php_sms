<?php

include('../../config/DB-connection.php');
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
      


            $query = "DELETE FROM messages ";
            $query_stmt = mysqli_prepare($connection, $query);
            if (mysqli_stmt_execute($query_stmt)) {
                $message = "All Messages successfully Deleted! ";
                header("location:../message.php?mess=$message");
                exit;
            } else {
                $message = "some things went wrong try again ";
                header("location:../message.php");
                exit;
            }
        }

} else {
    header('location:../../login.php');
}