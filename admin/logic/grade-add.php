<?php

include('../../config/DB-connection.php');
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if (
            isset($_POST['grade']) &&
            isset($_POST['grade_code'])
        ) {

            $grade = $_POST['grade'];
            $grade_code = $_POST['grade_code'];


            $_SESSION['old_grade'] = $_POST;

            if (empty($grade)) {
                $message = "Grade is required  ";
                header("location:../grade-add.php?mess=$message");
                exit;
            } else if (empty($grade_code)) {
                $message = "Grade code is required  ";
                header("location:../grade-add.php?mess=$message");
                exit;
            } else {

                $get_Single_grade = "SELECT * FROM grades WHERE grade = ? AND grade_code =? ";
                $get_Single_grade_stmt = mysqli_prepare($connection, $get_Single_grade);
                mysqli_stmt_bind_param($get_Single_grade_stmt, 'ss', $grade , $grade_code);
                mysqli_stmt_execute($get_Single_grade_stmt);
                $get_Single_grade_result = mysqli_stmt_get_result($get_Single_grade_stmt);
                $get_Single_grade_count = $get_Single_grade_result->num_rows;
                if ($get_Single_grade_count >= 1) {
                    $message = " This grade is already exits  ";
                    header("location:../grade-add.php?mess=$message");
                    exit;
                }                
                $query = "INSERT INTO grades (grade, grade_code) VALUES (? , ?)";
                $query_stmt = mysqli_prepare($connection , $query);
                mysqli_stmt_bind_param($query_stmt , 'ss' , $grade , $grade_code);
                if (mysqli_stmt_execute($query_stmt)) {
                    $message = "Grade successfully add ";
                    header("location:../grade-add.php?mess=$message");
                    unset($_SESSION['old_grade']);
                    exit;
                } else {
                    $message = "some things went wrong try again ";
                    header("location:../grade-add.php?mess=$message");
                    exit;
                }
            }
        } else {
            $message = "some things went wrong try again ";
            header("location:../grade-add.php?mess=$message");
            exit;
        }
    } else {
        $message = "some things went wrong try again ";
        header("location:../grade-add.php?mess=$message");
        exit;
    }
}
else{

    header('location:../../login.php');
}