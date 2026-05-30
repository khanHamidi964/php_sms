<?php

include('../../config/DB-connection.php');
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {

        if (isset($_GET['section_id'])) {

            $section_id = $_GET['section_id'];

            if (is_numeric($section_id)) {

                $student_section = "SELECT * FROM student_section WHERE section_id1 = ?";
                $student_section_stmt =mysqli_prepare($connection , $student_section);
                mysqli_stmt_bind_param($student_section_stmt , 'i' , $section_id);
                mysqli_stmt_execute($student_section_stmt);
                $student_section_result = mysqli_stmt_get_result($student_section_stmt);
                $student_section_count =$student_section_result->num_rows;

                if ($student_section_count >= 1) {
                    $message = " This section is used for some students or teachers   ";
                    header("location:../section.php?mess=$message");
                    exit;
                }
                $teacher_class = "SELECT * FROM classes WHERE class_id = ?";
                $teacher_class_stmt = mysqli_prepare($connection, $teacher_class);
                mysqli_stmt_bind_param($teacher_class_stmt, 'i', $class_id);
                mysqli_stmt_execute($teacher_class_stmt);
                $teacher_class_result = mysqli_stmt_get_result($teacher_class_stmt);
                $teacher_class_count = $teacher_class_result->num_rows;

                if ($teacher_class_count >= 1) {
                    $message = " This section is used for some students or teachers   ";
                    header("location:../section.php?mess=$message");
                    exit;
                }
                $query = "DELETE FROM section WHERE section_id =?";
                $query_stmt = mysqli_prepare($connection , $query);
                mysqli_stmt_bind_param($query_stmt , 'i' , $section_id);
                if (mysqli_stmt_execute($query_stmt)) {
                    $message = "section successfully deleted! ";
                    header("location:../section.php?mess=$message");
                    exit;
                } else {
                    $message = "some things went wrong try again ";
                    header("location:../section.php?mess=$message");
                    exit;
                }
            } else {
                $message = "section id is not a number ";
                header("location:../section.php?mess=$message");
                exit;
            }
        } else {
            $message = "some things went wrong try again ";
            header("location:../section.php?mess=$message");
            exit;
        }
    } else {
        $message = "some things went wrong try again ";
        header("location:../section.php?mess=$message");
        exit;
    }
} else {

    header('location:../../login.php');
}