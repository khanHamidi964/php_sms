<?php

include('../../config/DB-connection.php');
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if (
            isset($_POST['name'])&&
            isset($_POST['slogan']) &&
            isset($_POST['about']) 
        ) {

            $name  = $_POST['name'];
            $about = $_POST['about'];
            $slogan = $_POST['slogan'];

            if (empty($name)) {
                $message = "name is required  ";
                header("location:../setting.php?mess=$message");
                exit;
            }
            if (empty($slogan)) {
                $message = "slogan is required  ";
                header("location:../setting.php?mess=$message");
                exit;
            }
            if (empty($about)) {
                $message = "about is required  ";
                header("location:../setting.php?mess=$message");
                exit;
            } else {

              
                    $query = "UPDATE setting SET   school_name  = ? ,school_slogan =?, school_about =? ";
                    $query_stmt = mysqli_prepare($connection , $query);
                    mysqli_stmt_bind_param($query_stmt , 'sss' , $name , $slogan, $about);
                    
                    if (mysqli_stmt_execute($query_stmt)) {
                        $message = "Setting successfully Updated!";
                        header("location:../setting.php?mess=$message");
                        exit;
                    } else {
                        $message = "some things went wrong try again ";
                        header("location:../setting.php?mess=$message");
                        exit;
                    }
                
            }
        } else {
            $message = "some things went wrong try again ";
            header("location:../setting.php?mess=$message");
            exit;
        }
    } else {
        $message = "some things went wrong try again ";
        header("location:../setting.php?mess=$message");
        exit;
    }
} else {

    header('location:../../login.php');
}