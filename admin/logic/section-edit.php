<?php

include('../../config/DB-connection.php');
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if (
            isset($_POST['section'])
        ) {

            $section_id  = $_POST['section_id'];
            $section = $_POST['section'];

            if (empty($section)) {
                $message = "Section is required  ";
                header("location:../section-edit.php?mess=$message&section_id=$section_id");
                exit;
            } else {

                $get_section = "SELECT * FROM section WHERE section = ?";
                $section_stmt = mysqli_prepare($connection, $get_section);
                mysqli_stmt_bind_param($section_stmt, 's', $section);
                mysqli_stmt_execute($section_stmt);
                $section_result = mysqli_stmt_get_result($section_stmt);
                $section_count = $section_result->num_rows;


                if ($section_count >= 1) {
                    $message = " This section is already exits  ";
                    header("location:../section-edit.php?mess=$message&section_id=$section_id");
                    exit;
                } else {
                    $query = "UPDATE section SET   section = ?  WHERE section_id = ?";
                    $query_stmt =mysqli_prepare($connection , $query);
                    mysqli_stmt_bind_param($query_stmt , 'si' , $section, $section_id);
                    if (mysqli_stmt_execute($query_stmt)) {
                        $message = "Section successfully Updated!";
                        header("location:../section-edit.php?mess=$message&section_id=$section_id");
                        exit;
                    } else {
                        $message = "some things went wrong try again ";
                        header("location:../section-edit.php?mess=$message&section_id=$section_id");
                        exit;
                    }
                }
            }
        } else {
            $message = "some things went wrong try again ";
            header("location:../section-edit.php?mess=$message&section_id=$section_id");
            exit;
        }
    } else {
        $message = "some things went wrong try again ";
        header("location:../section-edit.php?mess=$message&section_id=$section_id");
        exit;
    }
} else {

    header('location:../../login.php');
}