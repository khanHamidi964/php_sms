<?php

include('../../config/DB-connection.php');
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Register Office') {
        if (
            isset($_POST['first_name']) &&
            isset($_POST['last_name']) &&
            isset($_POST['username']) &&
            isset($_POST['password']) &&
            isset($_POST['address']) &&
            isset($_POST['email']) &&
            isset($_POST['dob']) &&
            isset($_POST['pfname']) &&
            isset($_POST['plname']) &&
            isset($_POST['ppnumber']) &&
            isset($_FILES['image'])




        ) {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $grades = $_POST['grades'];
            $address = $_POST['address'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            $sections = $_POST['sections'];
            $dob = $_POST['dob'];
            $pfname = $_POST['pfname'];
            $plname = $_POST['plname'];
            $ppnumber = $_POST['ppnumber'];
            $profile = $_FILES['image']['name'];




            $_SESSION['old1'] = $_POST;


            if (empty($first_name)) {
                $mess = "First name is required ! ";
                header("location:../student-add.php?error=$mess");
                exit;
            } else if (empty($last_name)) {
                $mess = "Last name is required ";
                header("location:../student-add.php?error=$mess");
                exit;
            } else if (empty($username)) {
                $mess = "User name is required ";
                header("location:../student-add.php?error=$mess");
                exit;
            } else if (empty($password)) {
                $mess = "Password  is required ";
                header("location:../student-add.php?error=$mess");
                exit;
            } else if (empty($address)) {
                $mess = "Address is required ";
                header("location:../student-add.php?error=$mess");
                exit;
            } else if (empty($gender)) {
                $mess = "Select the gender  ";
                header("location:../student-add.php?error=$mess");
                exit;
            } else if (empty($dob)) {
                $mess = "select the birth day ";
                header("location:../student-add.php?error=$mess");
                exit;
            } else if (empty($pfname)) {
                $mess = "select the parent first name ";
                header("location:../student-add.php?error=$mess");
                exit;
            } else if (empty($plname)) {
                $mess = "Parent last name is required ";
                header("location:../student-add.php?error=$mess");
                exit;
            } else if (empty($grades)) {
                $mess = "Grades is required ";
                header("location:../student-add.php?error=$mess");
                exit;
            } else if (empty($sections)) {
                $mess = "Sections is required ";
                header("location:../student-add.php?error=$mess");
                exit;
            } else {



                $get_user_for_check = "SELECT * FROM students WHERE username = ? ";
                $get_user_for_check_stmt = mysqli_prepare($connection, $get_user_for_check);
                mysqli_stmt_bind_param($get_user_for_check_stmt, 's',  $username);
                mysqli_stmt_execute($get_user_for_check_stmt);
                $check_result = mysqli_stmt_get_result($get_user_for_check_stmt);
                $check_count = $check_result->num_rows;
                if ($check_count >= 1) {
                    $mess = "This username is already used by other user! ";
                    header("location:../student-add.php?error=$mess");
                    exit;
                }
                $get_user_for_check_email = "SELECT * FROM students WHERE email = ? ";
                $get_user_for_check_email_stmt = mysqli_prepare($connection, $get_user_for_check_email);
                mysqli_stmt_bind_param($get_user_for_check_email_stmt, 's',  $email);
                mysqli_stmt_execute($get_user_for_check_email_stmt);
                $check_result_email = mysqli_stmt_get_result($get_user_for_check_email_stmt);
                $check_count_email = $check_result_email->num_rows;
                if ($check_count_email >= 1) {
                    $mess = "This Email is already used by other user! ";
                    header("location:../student-add.php?error=$mess");
                    exit;
                } else {
                    if (empty($profile)) {
                        $final_name = 'assets/images/default.jpg';
                    } else {
                        if ($_FILES['image']['size'] / 1024 >= 5112) {
                            $mess = "File size is not be greater then 5MB ";
                            header("location:../student-add.php?error=$mess");
                            exit;
                        }
                        $path = "../../assets/images/";
                        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                        $file_name  = "Student_Img_" . time()  . '.' . $extension;
                        move_uploaded_file($_FILES['image']['tmp_name'],  $path . $file_name);
                        $final_name = 'assets/images/' . $file_name;
                    }
                    $inset_query =  "INSERT INTO students (username ,fname , lname, password ,profile,  address, gender, email , date_of_birth, parent_first_name, parent_last_name, parent_phone_number)VALUES (? ,? ,? , ? ,? ,? ,? ,? ,? ,? ,? ,? )";
                    $stmt = mysqli_prepare($connection, $inset_query);
                    mysqli_stmt_bind_param($stmt, 'ssssssssssss', $username, $first_name, $last_name, $password,  $final_name, $address, $gender, $email, $dob, $pfname, $plname, $ppnumber);

                    if (mysqli_stmt_execute($stmt)) {
                        $student_id_query = "SELECT * FROM students ORDER BY student_id DESC LIMIT 1";
                        $student_id_query_stmt = mysqli_prepare($connection, $student_id_query);
                        mysqli_stmt_execute($student_id_query_stmt);
                        $student_row = mysqli_stmt_get_result($student_id_query_stmt);
                        $student_id = $student_row->fetch_assoc();

                        foreach ($grades as $grade) {
                            $grades_query = "INSERT INTO student_grades (student_id1 , grade_id1) VALUES ( ? ,? )";
                            $stmt_grade = mysqli_prepare($connection, $grades_query);
                            mysqli_stmt_bind_param($stmt_grade, 'ii', $student_id['student_id'],  $grade);
                            mysqli_stmt_execute($stmt_grade);
                        }
                        foreach ($sections as $section) {
                            $sections_query = "INSERT INTO student_section (student_id1 , section_id1) VALUES (? , ?) ";
                            $stmt_section = mysqli_prepare($connection, $sections_query);
                            mysqli_stmt_bind_param($stmt_section, 'ii', $student_id['student_id'],  $section);
                            mysqli_stmt_execute($stmt_section);
                        }

                        $mess = "Student Successfully added! ";
                        header("location:../student-add.php?error=$mess");
                        unset($_SESSION['old1']);
                        exit;
                    } else {
                        $mess = "somethings went wrong try again! ";
                        header("location:../student-add.php?error=$mess");
                        exit;
                    }
                }
            }
        } else {

            $mess = "Somethings went wrong try again  ";
            header("location:../student-add.php?error=$mess");
            exit;
        }
    }
} else {

    header('location:../../login.php');
}