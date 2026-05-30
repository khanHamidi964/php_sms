<?php

include('../../config/DB-connection.php');
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if (
            isset($_POST['section'])
        ) {

            $section = $_POST['section'];
      

            if (empty($section)) {
                $message = "Section is required  ";
                header("location:../section-add.php?mess=$message");
                exit;
            } 
            else {

                $get_section = "SELECT * FROM section WHERE section = ?";
                $get_section_stmt =mysqli_prepare($connection , $get_section);
                mysqli_stmt_bind_param($get_section_stmt , 's' , $section);
                mysqli_stmt_execute($get_section_stmt);
                $get_section_result = mysqli_stmt_get_result($get_section_stmt);
                $get_section_count = $get_section_result->fetch_assoc();

                if ($get_section_count >= 1) {
                    $message = " This section is already exits  ";
                    header("location:../section-add.php?mess=$message");
                    exit;
                }
                else{ 
                    $query = "INSERT INTO section (section) VALUES (?)";
                    $query_stmt = mysqli_prepare($connection , $query);
                    mysqli_stmt_bind_param($query_stmt , 's' , $section);
                    if (mysqli_stmt_execute($query_stmt)) {
                        $message = "Section successfully add ";
                        header("location:../section-add.php?mess=$message");  
                        exit;
                    } else {
                        $message = "some things went wrong try again ";
                        header("location:../section-add.php?mess=$message");
                        exit;
                    }
                }


            }
        } else {
            $message = "some things went wrong try again ";
            header("location:../section-add.php?mess=$message");
            exit;
        }
    } else {
        $message = "some things went wrong try again ";
        header("location:../section-add.php?mess=$message");
        exit;
    }
} else {

    header('location:../../login.php');
}