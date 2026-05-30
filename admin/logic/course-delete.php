<?php

include('../../config/DB-connection.php');
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {

        if (isset($_GET['subject_id'])) {

            $subject_id = $_GET['subject_id'];

            if (is_numeric($subject_id)) {

                $query = "DELETE FROM subjects WHERE subject_id = ?";
                $query_stmt = mysqli_prepare($connection , $query);
                mysqli_stmt_bind_param($query_stmt , 'i' , $subject_id);
                
                if (mysqli_stmt_execute($query_stmt)) {
                    $message = "course successfully deleted! ";
                    header("location:../course.php?mess=$message");
                    exit;
                } else {
                    $message = "some things went wrong try again ";
                    header("location:../course.php?mess=$message");
                    exit;
                }
            } else {
                $message = "course id is not a number ";
                header("location:../course.php?mess=$message");
                exit;
            }
        } else {
            $message = "some things went wrong try again ";
            header("location:../course.php?mess=$message");
            exit;
        }
    } else {
        $message = "some things went wrong try again ";
        header("location:../course.php?mess=$message");
        exit;
    }
} else {
    header('location:../../login.php');
}