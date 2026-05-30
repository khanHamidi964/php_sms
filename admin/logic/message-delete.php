<?php

include('../../config/DB-connection.php');
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if (
          
            isset($_GET['message_id'])

        ) {

            
            $message_id = $_GET['message_id'];



            $query = "DELETE FROM messages  WHERE message_id= ?";
            $query_stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($query_stmt, 'i', $message_id);
            if (mysqli_stmt_execute($query_stmt)) {
                $message = "Message successfully Deleted! ";
                header("location:../message.php?mess=$message");
                exit;
            } else {
                $message = "some things went wrong try again ";
                header("location:../message.php");
                exit;
            }
        }
    } else {
        $message = "some things went wrong try again ";
        header("location:../message.php?mess=$message");
        exit;
    }
} else {
    header('location:../../login.php');
}