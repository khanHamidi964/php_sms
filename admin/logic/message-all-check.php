<?php

include('../../config/DB-connection.php');
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
       
            $status = $_GET['status'];
           



            $query = "UPDATE messages  SET read_status = ? ";
            $query_stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($query_stmt, 's', $status);
            if (mysqli_stmt_execute($query_stmt)) {
                $message = "All Messages Status Successfully changed! ";
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