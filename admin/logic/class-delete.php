<?php

include('../../config/DB-connection.php');
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {

        if (isset($_GET['class_id'])) {

            $class_id = $_GET['class_id'];

            if (is_numeric($class_id)) {

                $query = "DELETE FROM classes WHERE class_id = ?";
                $query_stmt =mysqli_prepare($connection , $query);
                mysqli_stmt_bind_param($query_stmt , 'i' , $class_id);
                if (mysqli_stmt_execute($query_stmt)) {
                    $message = "class successfully deleted! ";
                    header("location:../class.php?mess=$message");
                    exit;
                } else {
                    $message = "some things went wrong try again ";
                    header("location:../class.php?mess=$message");
                    exit;
                }
            } else {
                $message = "class id is not a number ";
                header("location:../class.php?mess=$message");
                exit;
            }
        } else {
            $message = "some things went wrong try again ";
            header("location:../class.php?mess=$message");
            exit;
        }
    } else {
        $message = "some things went wrong try again ";
        header("location:../class.php?mess=$message");
        exit;
    }
} else {
    header('location:../../login.php');
}