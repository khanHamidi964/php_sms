<?php

include('../../config/DB-connection.php');
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if (
            isset($_POST['grade']) &&
            isset($_POST['subject']) &&
            isset($_POST['subject_code'])
        ) {

            $subject_id = $_POST['subject_id'];
            $grade = $_POST['grade'];
            $subject = $_POST['subject'];
            $subject_code = $_POST['subject_code'];

          
            if (empty($subject)) {
                $message = "subject is required!";
                header("location:../course-edit.php?mess=$message&subject_id=$subject_id");
                exit;
            } else if (empty($subject_code)) {
                $message = "subject Code is required!";
                header("location:../course-edit.php?mess=$message&subject_id=$subject_id");
                exit;
            } else if (empty($grade)) {
                $message = "Grade is required  ";
                header("location:../course-edit.php?mess=$message&subject_id=$subject_id");
                exit;
            } else {
                $get_subject = "SELECT * FROM subjects WHERE subject = ? && subject_code =? && grade = ? ";
                $get_subject_stmt = mysqli_prepare($connection , $get_subject);
                mysqli_stmt_bind_param($get_subject_stmt , 'sss' , $subject , $subject_code , $grade);
                mysqli_stmt_execute($get_subject_stmt);
                $get_result = mysqli_stmt_get_result($get_subject_stmt);
                $get_count = $get_result->num_rows;
                if ($get_count >= 1) {
                    $message = "This subject is already exits!";
                    header("location:../course-edit.php?mess=$message&subject_id=$subject_id");
                    exit;
                } else {
                    $query = "UPDATE subjects  SET grade = ? , subject = ? , subject_code = ? WHERE subject_id = ? ";
                    $query_stmt = mysqli_prepare($connection , $query);
                    mysqli_stmt_bind_param($query_stmt , 'sssi' , $grade , $subject , $subject_code , $subject_id);
                    if (mysqli_stmt_execute($query_stmt)) {
                        $message = "subject successfully updated! ";
                        header("location:../course-edit.php?mess=$message&subject_id=$subject_id");
                        exit;
                       
                    } else {
                        $message = "some things went wrong try again ";
                        header("location:../course-edit.php?mess=$message&subject_id=$subject_id");
                        exit;
                    }
                }
            }
        } else {
            $message = "some things went wrong try again ";
            header("location:../course-edit.php?mess=$message");
            exit;
        }
    } else {
        $message = "some things went wrong try again ";
        header("location:../course-edit.php?mess=$message");
        exit;
    }
} else {
    header('location:../../login.php');
}