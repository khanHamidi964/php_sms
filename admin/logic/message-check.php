<?php

include('../../config/DB-connection.php');
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if (
            isset($_POST['status']) &&
            isset($_POST['message_id']) 
           
        ) {

            $status = $_POST['status'];
            $message_id = $_POST['message_id'];
            

             
                    $query = "UPDATE messages  SET read_status = ? WHERE message_id= ?";
                    $query_stmt = mysqli_prepare($connection , $query);
                    mysqli_stmt_bind_param($query_stmt , 'si' , $status , $message_id);
                    if (mysqli_stmt_execute($query_stmt)) {
                        $message = "Message Status Successfully changed! ";
                        header("location:../message.php?mess=$message");
                        exit;
                    } else {
                        $message = "some things went wrong try again ";
                        header("location:../message.php");
                        exit;
                    }
                
            }
        
    } else {
        $message = "some things went wrong try again ";
        header("location:../message.php?mess=$message");
        exit;
    }
} else {
    header('location:../../login.php');
}