<?php

include('../config/DB-connection.php');

if(isset($_POST['email']) && isset($_POST['name']) && isset($_POST['message'])){
    
    
    $email = $_POST['email'];
    $name = $_POST['name'];
    $message = $_POST['message'];
    
    $_SESSION['old_message'] = $_POST;
    
    if(empty($email)){
        $message = "Email is required";
        header("location:../index.php?message=$message&#contact");
        exit;
    }
    else if(empty($name)){
        $message = "Name is required";
        header("location:../index.php?message=$message&#contact");
        exit;
    }
    else if(empty($message)){
        $message = "Contact message is required ";
        header("location:../index.php?message=$message&#contact");
        exit;
    }

    $query = "INSERT INTO messages (send_full_name, send_email,send_message,read_status)VALUES(?,?,?,?)";
    $query_stmt = mysqli_prepare($connection, $query);
    $status = 'unread';
    mysqli_stmt_bind_param($query_stmt , 'ssss' , $name , $email , $message , $status );
    
    if(mysqli_stmt_execute($query_stmt)){
        $message = "Message successfully sent ";
        header("location:../index.php?message=$message&#contact");
        exit;
    }
    else{
        $message = "Somethings went wrong! ";
        header("location:../index.php?message=$message&#contact");
        exit;
    }
    
}else{
    $message = "Somethings went wrong tray again";
    header("location:../index.php?message=$message&#contact");
    exit;
}




















?>