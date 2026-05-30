<?php
include('../../config/DB-connection.php');
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Teacher') {

        
        if (
            isset($_POST['subject_id']) &&
            isset($_POST['semester']) &&
            isset($_POST['year'])&&
            isset($_POST['student_id'])&&
            isset($_POST['score']) 
            ) {
            
            $subject = $_POST['subject_id'];
            $semester = $_POST['semester'];
            $year = $_POST ['year'];
            $student = $_POST['student_id'];
            $score = $_POST['score'];
            $teacher = $_SESSION['id'];
            
      
      
            if (!empty($subject) || !empty($semester) || !empty($year) || !empty($student) || !empty($score) || !empty($teacher)) {

                $query = "INSERT INTO student_score (semester , year , student_id1, teacher_id1, subject_id1, results)VALUES(?,?,?,?,?,?)";
                $query_stmt = mysqli_prepare($connection , $query);
                mysqli_stmt_bind_param($query_stmt , 'ssiiis' , $semester, $year , $student , $teacher , $subject , $score);
                if(mysqli_stmt_execute($query_stmt)){
                    $mess = "Score successfully added! ";
                    header("location:../add-grade.php?message=$mess&student_id=$student");
                    exit;
                }else{
                    $mess = "Somethings went wrong try again! ";
                    header("location:../add-grade.php?message=$mess&student_id=$student");
                    exit;
                }
               
            } else {
                $mess = "the all input failed is required try again! ";
                header("location:../add-grade.php?message=$mess&student_id=$student");
                exit;
            }
        } else {

            $mess = "somethings went wrong! ";
            header("location:../add-grade.php?message=$mess&student_id=$student");
            exit;
        }
    }
} else {
    header('location:../../login.php');
}