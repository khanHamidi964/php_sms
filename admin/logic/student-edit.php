<?php


include('../../config/DB-connection.php');
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {

        if (
            isset($_POST['first_name']) &&
            isset($_POST['last_name']) &&
            isset($_POST['username']) &&
            isset($_POST['address']) &&
            isset($_POST['email']) &&
            isset($_POST['dob']) &&
            isset($_POST['pfname']) &&
            isset($_POST['plname']) &&
            isset($_POST['ppnumber']) &&
            isset($_FILES['image'])
        ) {
            $student_id = $_POST['student_id'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $username = $_POST['username'];
            $grades = $_POST['student_grades'];
            $sections = $_POST['student_section'];
            $address = $_POST['address'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            $sections = $_POST['student_section'];
            $dob = $_POST['dob'];
            $pfname = $_POST['pfname'];
            $plname = $_POST['plname'];
            $ppnumber = $_POST['ppnumber'];
            $profile = $_FILES['image']['name'];
            $all_grades = '';
            if (isset($_POST['all_grades'])) {
                $all_grades = $_POST['all_grades'];
            }
            $all_section = '';
            if (isset($_POST['all_section'])) {
                $all_section = $_POST['all_section'];
            }
            if (empty($first_name)) {
                $mess = "First name is required ! ";
                header("location:../student-edit.php?message1=$mess&student_id=$student_id");
                exit;
            } else if (empty($last_name)) {
                $mess = "Last name is required ";
                header("location:../student-edit.php?message1=$mess&student_id=$student_id");
                exit;
            } else if (empty($username)) {
                $mess = "User name is required ";
                header("location:../student-edit.php?message1=$mess&student_id=$student_id");
                exit;
            } else if (empty($address)) {
                $mess = "Address is required ";
                header("location:../student-edit.php?message1=$mess&student_id=$student_id");
                exit;
            } else if (empty($gender)) {
                $mess = "Select the gender  ";
                header("location:../student-edit.php?message1=$mess&student_id=$student_id");
                exit;
            } else if (empty($dob)) {
                $mess = "select the birth day ";
                header("location:../student-edit.php?message1=$mess&student_id=$student_id");
                exit;
            } else if (empty($pfname)) {
                $mess = "select the parent first name ";
                header("location:../student-edit.php?message1=$mess&student_id=$student_id");
                exit;
            } else if (empty($plname)) {
                $mess = "Parent last name is required ";
                header("location:../student-edit.php?message1=$mess&student_id=$student_id");
                exit;
            } else if (empty($grades)) {
                $mess = "Grades is required ";
                header("location:../student-edit.php?message1=$mess&student_id=$student_id");
                exit;
            } else if (empty($sections)) {
                $mess = "sections is required ";
                header("location:../student-edit.php?message1=$mess&student_id=$student_id");
                exit;
            } else if (empty($sections)) {
                $mess = "Sections is required ";
                header("location:../student-edit.php?message1=$mess&student_id=$student_id");
                exit;
            } else {

                $get_user_for_check = "SELECT * FROM students WHERE username = ? ";
                $get_user_for_check_stmt = mysqli_prepare($connection, $get_user_for_check);
                mysqli_stmt_bind_param($get_user_for_check_stmt, 's',  $username);
                mysqli_stmt_execute($get_user_for_check_stmt);
                $check_result = mysqli_stmt_get_result($get_user_for_check_stmt);
                $check_count = $check_result->num_rows;
                if ($check_count > 1) {
                    $mess = "This username is already used by other user! ";
                    header("location:../student-edit.php?message1=$mess&student_id=$student_id");
                    exit;
                }
                $get_user_for_check_email = "SELECT * FROM students WHERE email = ? ";
                $get_user_for_check_email_stmt = mysqli_prepare($connection, $get_user_for_check_email);
                mysqli_stmt_bind_param($get_user_for_check_email_stmt, 's',  $email);
                mysqli_stmt_execute($get_user_for_check_email_stmt);
                $check_result_email = mysqli_stmt_get_result($get_user_for_check_email_stmt);
                $check_count_email = $check_result_email->num_rows;
                
                if ($check_count_email > 1) {
                    $mess = "This Email is already used by other user! ";
                    header("location:../student-edit.php?message1=$mess&student_id=$student_id");
                    exit;
                }
                else{
                $get_user_for_check_profile = "SELECT * FROM students WHERE student_id = ? LIMIT 1 ";
                $get_user_for_check_profile_stmt = mysqli_prepare($connection, $get_user_for_check_profile);
                mysqli_stmt_bind_param($get_user_for_check_profile_stmt, 'i',  $student_id);
                mysqli_stmt_execute($get_user_for_check_profile_stmt);
                $check_result_profile = mysqli_stmt_get_result($get_user_for_check_profile_stmt);
                $check_row_profile = $check_result_profile->fetch_assoc();

                    if (empty($profile)) {
                        $final_name  = $check_row_profile['profile'];
                    } else {


                        
                        if(file_exists('../../' . $check_row_profile['profile'])){
                            if($check_row_profile['profile'] != 'assets/images/default.jpg'){
                                unlink('../../' .$check_row_profile['profile']);
                            }
                        }                        
                        if ($_FILES['image']['size'] / 1024 >= 5112) {
                            $mess = "File size is not be greater then 5MB ";
                            header("location:../student-edit.php?error=$mess");
                            exit;
                        }
                        $path = "../../assets/images/";
                        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                        $file_name  = "Student_Img_" . time()  . '.' . $extension;
                        move_uploaded_file($_FILES['image']['tmp_name'],  $path . $file_name);
                        $final_name = 'assets/images/' . $file_name;

                        

                        
                    }
                    $update_query =  "UPDATE students SET  username = ? , fname = ? , lname = ? , profile = ?,  address= ? , gender= ? , email= ?, date_of_birth= ? , parent_first_name= ?,parent_last_name= ?, parent_phone_number= ? WHERE student_id = ? ";
                    $update_query_stmt = mysqli_prepare($connection, $update_query);
                    mysqli_stmt_bind_param($update_query_stmt, 'sssssssssssi', $username, $first_name, $last_name, $final_name,  $address, $gender, $email, $dob, $pfname, $plname, $ppnumber, $student_id);
    
                    if (mysqli_stmt_execute($update_query_stmt)) {
    
                        if (!empty($all_grades)) {
                            $grade_query = "UPDATE student_grades SET grade_id1 =' {$all_grades}' WHERE student_id1 = ? ";
                            $grade_result = mysqli_prepare($connection, $grade_query);
                            mysqli_stmt_bind_param($grade_result, 'i',  $student_id);
                            mysqli_stmt_execute($grade_result);
                        }
    
                        if (!empty($all_section)) {
                            $section_query = "UPDATE student_section SET section_id1 = '{$all_section}' WHERE student_id1 = ? ";
                            $section_result = mysqli_prepare($connection, $section_query);
                            mysqli_stmt_bind_param($section_result, 'i',  $student_id);
                            mysqli_stmt_execute($section_result);
                        }
                        $mess = 'student successfully updated!';
                        header("location: ../student-edit.php?message1= $mess&student_id=$student_id");
                        exit;
                    } else {
                        $mess = "somethings went wrong ";
                        header("location:../student-edit.php?message1=$mess");
                        exit;
                    }
                }


            }
        } else {

            $mess = " somethings went wrong  ";
            header("location:../student-edit.php?message1=$mess");
            exit;
        }
    }
} else {

    header('location:../../login.php');
}