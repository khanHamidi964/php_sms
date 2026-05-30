<?php


include('../../config/DB-connection.php');
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Student') {

        if (
            isset($_POST['c_password']) &&
            isset($_POST['new_password']) &&
            isset($_POST['confirmNew_password'])
        ) {


            $_SESSION['old_password'] = $_POST;

            $c_password = $_POST['c_password'];
            $new_password = $_POST['new_password'];
            $confirmNew_password = $_POST['confirmNew_password'];
            if (!empty($c_password) || !empty($new_password) || !empty($confirmNew_password)) {

                $password_query = "SELECT * FROM students WHERE student_id = ?  LIMIT 1";
                $password_query_result = mysqli_prepare($connection, $password_query);
                mysqli_stmt_bind_param($password_query_result, 'i',  $_SESSION['id']);
                mysqli_stmt_execute($password_query_result);
                $get_result = mysqli_stmt_get_result($password_query_result);
                $get_row = $get_result->fetch_assoc();
                if (password_verify($_POST['c_password'], $get_row['password'])) {
                    if ($new_password == $confirmNew_password) {

                        if (empty($new_password)) {
                            $mess = "New password is required! ";
                            header("location:../password.php?message=$mess&student_id={$_POST['student_id']}");
                            exit;
                        } else if (empty($confirmNew_password)) {
                            $mess = "Confirm password is required ! ";
                            header("location:../password.php?message=$mess&student_id={$_POST['student_id']}");
                            exit;
                        }

                        $new_hash_password = password_hash($new_password, PASSWORD_BCRYPT);

                        $password_change_query = "UPDATE students SET password = '{$new_hash_password}' WHERE student_id = ?";
                        $password_change_query_stmt = mysqli_prepare($connection , $password_change_query);
                        mysqli_stmt_bind_param($password_change_query_stmt , 'i' ,  $_SESSION['id']);
                        if (mysqli_stmt_execute($password_change_query_stmt)) {
                            $mess = "Your password successfully changed! ";
                            header("location:../password.php?message=$mess&student_id={$_POST['student_id']}");
                            unset($_SESSION['old_password']);
                            exit;
                        } else {
                            $mess = "somethings went wrong! ";
                            header("location:../password.php?message=$mess&student_id={$_POST['student_id']}");
                            exit;
                        }
                    } else {
                        $mess = "Confirm password is incorrect try again ! ";
                        header("location:../password.php?message=$mess&student_id={$_POST['student_id']}");
                        exit;
                    }
                } else {
                    $mess = "Your password is incorrect try again";
                    header("location:../password.php?message=$mess&student_id={$_POST['student_id']}");
                    exit;
                }
            } else {
                $mess = "the all input failed is required try again! ";
                header("location:../password.php?message=$mess&student_id={$_POST['student_id']}");
                exit;
            }
        } else {

            $mess = "somethings went wrong! ";
            header("location:../password.php?message=$mess&student_id={$_POST['student_id']}");
            exit;
        }
    }
} else {

    header('location:../../login.php');
}