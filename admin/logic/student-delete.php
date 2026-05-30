<?php
include('../../config/DB-connection.php');
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {

        if (isset($_GET['student_id'])) {

            $student_id = $_GET['student_id'];

            if (is_numeric($student_id)) {

                $get_user_for_check_profile = "SELECT * FROM students WHERE student_id = ? LIMIT 1 ";
                $get_user_for_check_profile_stmt = mysqli_prepare($connection, $get_user_for_check_profile);
                mysqli_stmt_bind_param($get_user_for_check_profile_stmt, 'i',  $student_id);
                mysqli_stmt_execute($get_user_for_check_profile_stmt);
                $check_result_profile = mysqli_stmt_get_result($get_user_for_check_profile_stmt);
                $check_row_profile = $check_result_profile->fetch_assoc();

                if(file_exists( '../../'.$check_row_profile['profile'])){
                    unlink('../../' . $check_row_profile['profile']);
                }

                $query = "DELETE FROM students WHERE student_id = ? LIMIT 1";
                $query_stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($query_stmt, 'i', $student_id);
                if (mysqli_stmt_execute($query_stmt)) {

                    $mess = "student successfully deleted!";
                    header("location: ../student.php?error=$mess");
                    exit;
                } else {
                    $mess = "somethings went wrong!";
                    header("location: ../student.php?error=$mess");
                    exit;
                }
            } else {
                $mess = "student Id is not a number ";
                header("location: ../student.php?error=$mess");
                exit;
            }
        } else {
            $mess = "some things went wrong";
            header("location: ../student.php?error=$mess");
            exit;
        }
    }
} else {

    header('location:../../login.php');
}