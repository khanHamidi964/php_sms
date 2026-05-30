<?php
include('../config/DB-connection.php');
session_start();


if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (empty($username)) {
        $error = 'User name is required';
        header("location:../login.php?error=$error");
        exit;
    } else if (empty($password)) {
        $error = 'Password is required';
        header("location:../login.php?error=$error");
        exit;
    } else  if (empty($role)) {
        $error = 'Select the role  for login ';
        header("location:../login.php?error=$error");
        exit;
    } else {

        if ($role == '1') {
            $role = "Admin";
            $query = "SELECT * FROM Admin WHERE  username = ?";
            $stmt = mysqli_prepare($connection , $query);
            mysqli_stmt_bind_param($stmt , 's' ,  $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
          
            $count = $result->num_rows;            
            if ($count == 1) {
                $row = $result->fetch_assoc();
                $pass = $row['password'];
                if (password_verify($password  , $pass)) {
                   
                    $_SESSION['id'] = $row['admin_id'];
                    $_SESSION['role'] = $role;
                    $_SESSION['fname'] = $row['fname'];
                    
                    header("location:../admin/index.php");
                } else {
                    $error = 'Incorrect the password';
                    header("location:../login.php?error=$error");
                    exit;
                }
            } else {
                $error = 'Incorrect the username';
                header("location:../login.php?error=$error");
                exit;
            }
        
        } else if ($role == '2') {
            $role = "Teacher";
            $query = "SELECT * FROM teachers WHERE  username = ?";
            $query_stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($query_stmt , 's' , $username);
            mysqli_stmt_execute($query_stmt);
            $result = mysqli_stmt_get_result($query_stmt);
            $count = $result->num_rows;
       
            if ($count == 1) {
                $row = $result->fetch_assoc();
                $pass = $row['password'];
                if (password_verify($password, $pass)) {

                    $_SESSION['id'] = $row['teacher_id'];
                    $_SESSION['role'] = $role;
                    $_SESSION['fname'] = $row['fname'];

                    header("location:../teacher/index.php");
                } else {
                    $error = 'Incorrect the password';
                    header("location:../login.php?error=$error");
                    exit;
                }
            } else {
                $error = 'Incorrect the username';
                header("location:../login.php?error=$error");
                exit;
            }
        } 
        else if ($role == '3') {
            $role = "Student";
            $student_query = "SELECT * FROM students WHERE username = ?";
            $student_query_stmt = mysqli_prepare($connection, $student_query);
            mysqli_stmt_bind_param($student_query_stmt,  's', $username);
            mysqli_stmt_execute($student_query_stmt);
            $student_get_data = mysqli_stmt_get_result($student_query_stmt);
            $student_count = $student_get_data->num_rows;
            if ($student_count == 1) {

                $row = $student_get_data->fetch_assoc();
                $hash_password = $row['password'];
                if (password_verify($password, $hash_password)) {
                    $_SESSION['id'] = $row['student_id'];
                    $_SESSION['role'] = $role;
                    $_SESSION['fname'] = $row['fname'];
                    header("location:../student/index.php");
                } else {
                    $error = 'Incorrect the password';
                    header("location:../login.php?error=$error");
                    exit;
                }
            } else {
                $error = 'Incorrect the username';
                header("location:../login.php?error=$error");
                exit;
            }
        }
        
        else if ($role =='4'){

            $role= "Register Office";

            $query = "SELECT * FROM registerer_office WHERE username = ?";
            $stmt = mysqli_prepare($connection , $query);
            mysqli_stmt_bind_param($stmt , 's' , $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $count= $result->num_rows;
            
            if($count == 1){

                $row = $result->fetch_assoc();
                $pass = $row['password'];
                
                if (password_verify($password , $pass)) {
                    $_SESSION['id'] = $row['r_user_id'];
                    $_SESSION['role'] = $role;
                    $_SESSION['fname'] = $row['fname'];

                    header("location:../register_office/index.php");
                }else{
                    $error = 'Incorrect password';
                    header("location:../login.php?error=$error");
                    exit;
                }
                
            }
            else{
                $error = 'Incorrect username';
                header("location:../login.php?error=$error");
                exit;
            }
            


            
        } 
        
      
        
     
    }
} else {
    header("location: ../login.php");
    exit;
}