<?php

include('../../config/DB-connection.php');
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if (
            isset($_POST['grade']) &&
            isset($_POST['section'])
        ) {

            $class_id = $_POST['class_id'];
            $grade = $_POST['grade'];
            $section = $_POST['section'];


            if (empty($grade)) {
                $message = "Grade is required  ";
                header("location:../class-edit.php?mess=$message");
                exit;
            } else if (empty($section)) {
                $message = "section is required  ";
                header("location:../class-edit.php?mess=$message");
                exit;
            } else {


                $get_class = "SELECT * FROM classes WHERE grade_id = ? && section_id = ? 
                ";
                $get_class_stmt = mysqli_prepare($connection  ,$get_class);
                mysqli_stmt_bind_param($get_class_stmt , 'ii' , $grade ,  $section);
                mysqli_stmt_execute($get_class_stmt);

                $get_result = mysqli_stmt_get_result($get_class_stmt);
                $get_count =$get_result->num_rows;

                if ($get_count >= 1) {
                    $message = "This class is already exits!";
                    header("location:../class-edit.php?mess=$message&class_id=$class_id");
                    exit;
                } else {

                    $query = "UPDATE classes SET grade_id = ?  , section_id = ? WHERE class_id = ?";
                    $query_stmt = mysqli_prepare($connection , $query);
                    mysqli_stmt_bind_param($query_stmt , 'iii' , $grade , $section , $class_id);
                    
                    if (mysqli_stmt_execute($query_stmt)) {
                        $message = "Class successfully updated! ";
                        header("location:../class-edit.php?mess=$message&class_id=$class_id");

                        exit;
                    } else {
                        $message = "some things went wrong try again ";
                        header("location:../class-edit.php?mess=$message&class_id=$class_id");
                        exit;
                    }
                }
            }
        } else {
            $message = "some things went wrong try again ";
            header("location:../class-edit.php?mess=$message&class_id=$class_id");
            exit;
        }
    } else {
        $message = "some things went wrong try again ";
        header("location:../class-edit.php?mess=$message&class_id=$class_id");
        exit;
    }
} else {

    header('location:../../login.php');
}