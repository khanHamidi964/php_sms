<?php

include('../../config/DB-connection.php');
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if (
            isset($_POST['grade']) &&
            isset($_POST['grade_code'])
        ) {

            $grade_id = $_POST['grade_id'];
            $grade = $_POST['grade'];
            $grade_code = $_POST['grade_code'];

            if (empty($grade)) {
                $message = "Grade is required  ";
                header("location:../grade-edit.php?mess=$message&grade_id=$grade_id");
                exit;
            } else if (empty($grade_code)) {
                $message = "Grade code is required  ";
                header("location:../grade-edit.php?mess=$message&grade_id=$grade_id");
                exit;
            } else {

                $query = "UPDATE  grades  SET grade ='{$grade}' , grade_code=  '{$grade_code}' WHERE grade_id = {$grade_id}";
                if (mysqli_query($connection, $query)) {
                    $message = "Grade successfully Updated! ";
                    header("location:../grade-edit.php?mess=$message&grade_id=$grade_id");
                    unset($_SESSION['old_grade']);
                    exit;
                } else {
                    $message = "some things went wrong try again ";
                    header("location:../grade-edit.php?mess=$message&grade_id=$grade_id");
                    exit;
                }
            }
        } else {
            $message = "some things went wrong try again ";
            header("location:../grade-edit.php?mess=$message&grade_id=$grade_id");
            exit;
        }
    } else {
        $message = "some things went wrong try again ";
        header("location:../grade-edit.php?mess=$message&grade_id=$grade_id");
        exit;
    }
} else {

    header('location:../../login.php');
}