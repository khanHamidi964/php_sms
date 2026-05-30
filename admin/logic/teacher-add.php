<?php

include('../../config/DB-connection.php');
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {
        if (
            isset($_POST['first_name']) &&
            isset($_POST['last_name']) &&
            isset($_POST['username']) &&
            isset($_POST['password']) &&
            isset($_POST['address']) &&
            isset($_POST['emp_number']) &&
            isset($_POST['phone_number']) &&
            isset($_POST['qualification']) &&
            isset($_POST['email']) &&
            isset($_POST['dob'])
        ) {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $subjects = $_POST['subjects'];

            $address = $_POST['address'];
            $emp_number = $_POST['emp_number'];
            $phone_number = $_POST['phone_number'];
            $qualification = $_POST['qualification'];
            $email = $_POST['email'];
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $classes = $_POST['classes'];
            $profile = $_FILES['image']['name'];

            $_SESSION['old'] = $_POST;

            if (empty($first_name)) {
                $mess = "First name is required ! ";
                header("location:../teacher-add.php?error=$mess");
                exit;
            } else if (empty($last_name)) {
                $mess = "Last name is required ";
                header("location:../teacher-add.php?error=$mess");
                exit;
            } else if (empty($username)) {
                $mess = "User name is required ";
                header("location:../teacher-add.php?error=$mess");
                exit;
            } else if (empty($password)) {
                $mess = "Password  is required ";
                header("location:../teacher-add.php?error=$mess");
                exit;
            } else if (empty($address)) {
                $mess = "Address is required ";
                header("location:../teacher-add.php?error=$mess");
                exit;
            } else if (empty($emp_number)) {
                $mess = "Employee number  is required ";
                header("location:../teacher-add.php?error=$mess");
                exit;
            } else if (empty($qualification)) {
                $mess = "Qualification is required ";
                header("location:../teacher-add.php?error=$mess");
                exit;
            } else if (empty($dob)) {
                $mess = "Date of birth is required ";
                header("location:../teacher-add.php?error=$mess");
                exit;
            } else if (empty($gender)) {
                $mess = "Gender  is required ";
                header("location:../teacher-add.php?error=$mess");
                exit;
            } else if (empty($classes)) {
                $mess = "class is required ";
                header("location:../teacher-add.php?error=$mess");
                exit;
            } else if (empty($subjects)) {
                $mess = "Subjects is required ";
                header("location:../teacher-add.php?error=$mess");
                exit;
            } else {
                $get_user_for_check = "SELECT * FROM teachers WHERE username = ? ";
                $get_user_for_check_stmt = mysqli_prepare($connection, $get_user_for_check);
                mysqli_stmt_bind_param($get_user_for_check_stmt, 's',  $username);
                mysqli_stmt_execute($get_user_for_check_stmt);
                $check_result = mysqli_stmt_get_result($get_user_for_check_stmt);
                $check_count = $check_result->num_rows;
                if ($check_count >= 1) {
                    $mess = "This username is already used by other user! ";
                    header("location:../teacher-add.php?error=$mess");
                    exit;
                }
                $get_user_for_check_email = "SELECT * FROM teachers WHERE email = ? ";
                $get_user_for_check_email_stmt = mysqli_prepare($connection, $get_user_for_check_email);
                mysqli_stmt_bind_param($get_user_for_check_email_stmt, 's',  $email);
                mysqli_stmt_execute($get_user_for_check_email_stmt);
                $check_result_email = mysqli_stmt_get_result($get_user_for_check_email_stmt);
                $check_count_email = $check_result_email->num_rows;
                if ($check_count_email >= 1) {
                    $mess = "This Email is already used by other user! ";
                    header("location:../teacher-add.php?error=$mess");
                    exit;
                } else {
                    if (empty($profile)) {
                        $final_name = 'assets/images/default.jpg';
                    } else {
                        if ($_FILES['image']['size'] / 1024 >= 5112) {
                            $mess = "File size is not be greater then 5MB ";
                            header("location:../teacher-add.php?error=$mess");
                            exit;
                        }
                        $path = "../../assets/images/";
                        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                        $file_name  = "Teacher_Img_" . time()  . '.' . $extension;
                        move_uploaded_file($_FILES['image']['tmp_name'],  $path . $file_name);
                        $final_name = 'assets/images/' . $file_name;
                    }
                    $new_password = password_hash($password, PASSWORD_BCRYPT);
                    $inset_query =  "INSERT INTO teachers (username ,fname , lname, password , profile , address, employee_number , date_of_birth , phone_number, qualification, gender , email )VALUES (? ,?,? , ? , ? ,? ,?, ? , ? , ?,  ? , ?) ";
                    $inset_query_stmt = mysqli_prepare($connection, $inset_query);
                    mysqli_stmt_bind_param($inset_query_stmt, 'ssssssssssss', $username, $first_name, $last_name, $new_password, $final_name, $address, $emp_number, $dob, $phone_number, $qualification, $gender, $email);
                    if (mysqli_stmt_execute($inset_query_stmt)) {
                        $teacher_id_query = "SELECT * FROM teachers ORDER BY teacher_id DESC LIMIT 1";
                        $teacher_id_query_stmt = mysqli_prepare($connection, $teacher_id_query);
                        mysqli_stmt_execute($teacher_id_query_stmt);
                        $teacher_row =  mysqli_stmt_get_result($teacher_id_query_stmt);
                        $teacher_id = $teacher_row->fetch_assoc();

                        foreach ($subjects as $subject) {
                            $subject_query = "INSERT INTO teacher_subjects (teacher_id1 , subject_id1) VALUES ( ? ,?) ";
                            $subject_query_stmt = mysqli_prepare($connection, $subject_query);
                            mysqli_stmt_bind_param($subject_query_stmt, 'ii', $teacher_id['teacher_id'], $subject);
                            $q = mysqli_stmt_execute($subject_query_stmt);
                        }
                        foreach ($classes as $class) {
                            $classes_query = "INSERT INTO teacher_class (class_id1, teacher_id1) VALUES (? ,?) ";
                            $classes_query_stmt = mysqli_prepare($connection, $classes_query);
                            mysqli_stmt_bind_param($classes_query_stmt, 'ii', $class, $teacher_id['teacher_id']);
                            $q = mysqli_stmt_execute($classes_query_stmt);
                        }


                        $mess = "Teacher successfully added! ";
                        header("location:../teacher-add.php?error=$mess");
                        unset($_SESSION['old']);
                        exit;
                    } else {
                        $mess = "somethings went wrong try again! ";
                        header("location:../teacher-add.php?error=$mess");
                        exit;
                    }
                }
            }
        } else {

            $mess = "make sure you are filled the all input and check box ";
            header("location:../teacher-add.php?error=$mess");
            exit;
        }
    }
} else {

    header('location:../../login.php');
}