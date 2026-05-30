<?php

include('../../config/DB-connection.php');
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
    
        if(isset($_GET['grade_id'])){
            
            $grade_id = $_GET['grade_id'];

            if(is_numeric($grade_id)){

                $student_grade = "SELECT * FROM student_grades WHERE grade_id1 = ? ";
                $student_grade_stmt = mysqli_prepare($connection , $student_grade);
                mysqli_stmt_bind_param($student_grade_stmt , 'i' , $grade_id);
                mysqli_stmt_execute($student_grade_stmt);
                $student_grade_result = mysqli_stmt_get_result($student_grade_stmt);
                $student_grade_count = $student_grade_result->num_rows;
                
                if($student_grade_count >= 1){
                    $message = " This grade is used for some students or teachers   ";
                    header("location:../grade.php?mess=$message");
                    exit;
                }

                $class_grade = "SELECT * FROM classes WHERE grade_id = ? ";
                $class_grade_stmt = mysqli_prepare($connection , $class_grade);
                mysqli_stmt_bind_param($class_grade_stmt , 'i' , $grade_id);
                mysqli_stmt_execute($class_grade_stmt);
                $class_grade_result = mysqli_stmt_get_result($class_grade_stmt);
                $class_grade_count = $class_grade_result->num_rows;
                if ($class_grade_count >= 1) {
                    $message = " This grade is used for some students or classs   ";
                    header("location:../grade.php?mess=$message");
                    exit;
                }

                $subject_grade = "SELECT * FROM subjects WHERE grade = ? ";
                $subject_grade_stmt = mysqli_prepare($connection, $subject_grade);
                mysqli_stmt_bind_param($subject_grade_stmt, 'i', $grade_id);
                mysqli_stmt_execute($subject_grade_stmt);
                $subject_grade_result = mysqli_stmt_get_result($subject_grade_stmt);
                $subject_grade_count = $subject_grade_result->num_rows;
                if ($subject_grade_count >= 1) {
                    $message = " This grade is used for some students or subjects   ";
                    header("location:../grade.php?mess=$message");
                    exit;
                }

                
                $query = "DELETE FROM grades WHERE grade_id = ? ";
                $query_stmt = mysqli_prepare($connection , $query);
                mysqli_stmt_bind_param($query_stmt , 'i' , $grade_id);
                if (mysqli_stmt_execute($query_stmt)) {
                    $message = "Grade successfully deleted! ";
                    header("location:../grade.php?mess=$message");
                    exit;
                } else {
                    
                    $message = "some things went wrong try again ";
                    header("location:../grade.php?mess=$message");
                    exit;
                }
            }
            else{
                $message = "Grade id is not a number ";
                header("location:../grade.php?mess=$message");
                exit;
            }  
        }else{
            $message = "some things went wrong try again ";
            header("location:../grade.php?mess=$message");
            exit;
        }
        
    } else {
        $message = "some things went wrong try again ";
        header("location:../grade.php?mess=$message");
        exit;
    }
} else {

    header('location:../../login.php');
}