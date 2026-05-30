<?php


include('../../config/DB-connection.php');
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {

        if (
            isset($_POST['admin_password']) &&
            isset($_POST['new_password']) &&
            isset($_POST['confirmNew_password'])
        ) {


            
            $_SESSION['old_password'] = $_POST;
            $admin_password = $_POST['admin_password'];
            $new_password = $_POST['new_password'];
            $confirmNew_password = $_POST['confirmNew_password'];
            
            if (!empty($admin_password) || !empty($new_password) || !empty($confirmNew_password)) {
                
                $password_query = "SELECT * FROM admin WHERE admin_id = ? LIMIT 1";
                $password_query_stmt =mysqli_prepare($connection , $password_query);
                mysqli_stmt_bind_param($password_query_stmt , 'i'  , $_SESSION['id']);
                mysqli_stmt_execute($password_query_stmt);
                $password_query_result = mysqli_stmt_get_result($password_query_stmt);
                $password_query_row =$password_query_result->fetch_assoc();
                if (password_verify($_POST['admin_password'], $password_query_row['password'])) {

                    if(empty($new_password)){
                        $mess = "New password is required! ";
                        header("location:../register-office-edit.php?message=$mess&r_user_id={$_POST['r_user_id']}");
                        exit;
                    }
                    else if(empty($confirmNew_password)){
                        $mess = "Confirm password is required ! ";
                        header("location:../register-office-edit.php?message=$mess&r_user_id={$_POST['r_user_id']}");
                        exit;
                    }
                        
                    
                    if ($new_password == $confirmNew_password) {
                        $new_hash_password = password_hash($new_password, PASSWORD_BCRYPT);

                        $password_change_query = "UPDATE registerer_office SET password = ? WHERE r_user_id = ?";
                        $password_change_query_stmt = mysqli_prepare($connection , $password_change_query);
                        mysqli_stmt_bind_param($password_change_query_stmt , 'si' , $new_hash_password , $_POST['r_user_id']);
                        if (mysqli_stmt_execute($password_change_query_stmt)) {
                            $mess = "Register Office user  password successfully changed! ";
                            header("location:../register-office-edit.php?message=$mess&r_user_id={$_POST['r_user_id']}");
                            unset($_SESSION['old_password']);
                            exit;
                        } else {
                            $mess = "somethings went wrong! ";
                            header("location:../register-office-edit.php?message=$mess&r_user_id={$_POST['r_user_id']}");
                            exit;
                        }
                    } else {
                        $mess = "Confirm password is incorrect try again ! ";
                        header("location:../register-office-edit.php?message=$mess&r_user_id={$_POST['r_user_id']}");
                        exit;
                    }
                } else {
                    $mess = "Admin password is incorrect try again";
                    header("location:../register-office-edit.php?message=$mess&r_user_id={$_POST['r_user_id']}");
                    exit;
                }
            } else {
                $mess = "the all input failed is required try again! ";
                header("location:../register-office-edit.php?message=$mess&r_user_id={$_POST['r_user_id']}");
                exit;
            }
        } else {

            $mess = "somethings went wrong! ";
            header("location:../register-office-edit.php?message=$mess&r_user_id={$_POST['r_user_id']}");
            exit;
        }
    }
} else {

    header('location:../../login.php');
}