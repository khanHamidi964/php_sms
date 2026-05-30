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
            isset($_POST['emp_number']) &&
            isset($_POST['phone_number']) &&
            isset($_POST['qualification']) &&
            isset($_POST['email']) &&
            isset($_POST['dob'])

        ) {
            
            $teacher_id = $_POST['teacher_id'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $username = $_POST['username'];
            $address = $_POST['address'];
            $emp_number = $_POST['emp_number'];
            $phone_number = $_POST['phone_number'];
            $qualification = $_POST['qualification'];
            $email = $_POST['email'];
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            $profile = $_FILES['image']['name'];

            if (empty($first_name)) {
                $mess = "First name is required ! ";
                header("location:../teacher-edit.php?error=$mess&teacher_id=$teacher_id");
                exit;
            } else if (empty($last_name)) {
                $mess = "Last name is required ";
                header("location:../teacher-edit.php?error=$mess&teacher_id=$teacher_id");
                exit;
            } else if (empty($username)) {
                $mess = "User name is required ";
                header("location:../teacher-edit.php?error=$mess&teacher_id=$teacher_id");
                exit;
            } else if (empty($address)) {
                $mess = "Address is required ";
                header("location:../teacher-edit.php?error=$mess&teacher_id=$teacher_id");
                exit;
            } else if (empty($emp_number)) {
                $mess = "Employee number  is required ";
                header("location:../teacher-edit.php?error=$mess&teacher_id=$teacher_id");
                exit;
            } else if (empty($qualification)) {
                $mess = "Qualification is required ";
                header("location:../teacher-edit.php?error=$mess&teacher_id=$teacher_id");
                exit;
            } else if (empty($dob)) {
                $mess = "Date of birth is required ";
                header("location:../teacher-edit.php?error=$mess&teacher_id=$teacher_id");
                exit;
            } else if (empty($gender)) {
                $mess = "Gender  is required ";
                header("location:../teacher-edit.php?error=$mess&teacher_id=$teacher_id");
                exit;
            } 
            
            else{



                $all_subjects = [];
                if (isset($_POST['all_subjects'])) {
                    $all_subjects = $_POST['all_subjects'];
                }

                $teacher_subjects = [];
                if (isset($_POST['teacher_subjects'])) {
                    $teacher_subjects = $_POST['teacher_subjects'];
                }
                $all_classes = [];
                if (isset($_POST['all_classes'])) {
                    $all_classes = $_POST['all_classes'];
                }
                $teacher_classes = [];
                if (isset($_POST['teacher_classes'])) {
                    $teacher_classes = $_POST['teacher_classes'];
                }
                $get_user_for_check = "SELECT * FROM teachers WHERE username = ? ";
                $get_user_for_check_stmt = mysqli_prepare($connection, $get_user_for_check);
                mysqli_stmt_bind_param($get_user_for_check_stmt, 's',  $username);
                mysqli_stmt_execute($get_user_for_check_stmt);
                $check_result = mysqli_stmt_get_result($get_user_for_check_stmt);
                $check_count = $check_result->num_rows;
                if ($check_count > 1) {
                    $mess = "This username is already used by other user! ";
                    header("location:../teacher-edit.php?message1=$mess&teacher_id=$teacher_id");
                    exit;
                }
                $get_user_for_check_email = "SELECT * FROM teachers WHERE email = ? ";
                $get_user_for_check_email_stmt = mysqli_prepare($connection, $get_user_for_check_email);
                mysqli_stmt_bind_param($get_user_for_check_email_stmt, 's',  $email);
                mysqli_stmt_execute($get_user_for_check_email_stmt);
                $check_result_email = mysqli_stmt_get_result($get_user_for_check_email_stmt);
                $check_count_email = $check_result_email->num_rows;

                if ($check_count_email > 1) {
                    $mess = "This Email is already used by other user! ";
                    header("location:../teacher-edit.php?message1=$mess&teacher_id=$teacher_id");
                    exit;
                } else {
                    $get_user_for_check_profile = "SELECT * FROM teachers WHERE teacher_id = ? LIMIT 1 ";
                    $get_user_for_check_profile_stmt = mysqli_prepare($connection, $get_user_for_check_profile);
                    mysqli_stmt_bind_param($get_user_for_check_profile_stmt, 'i',  $teacher_id);
                    mysqli_stmt_execute($get_user_for_check_profile_stmt);
                    $check_result_profile = mysqli_stmt_get_result($get_user_for_check_profile_stmt);
                    $check_row_profile = $check_result_profile->fetch_assoc();

                    if (empty($profile)) {
                        $final_name  = $check_row_profile['profile'];
                    } else {
                        if (file_exists('../../' . $check_row_profile['profile'])) {
                            if ($check_row_profile['profile'] != 'assets/images/default.jpg') {
                                unlink('../../' . $check_row_profile['profile']);
                            }
                        }
                        if ($_FILES['image']['size'] / 1024 >= 5112) {
                            $mess = "File size is not be greater then 5MB ";
                            header("location:../teacher-edit.php?error=$mess");
                            exit;
                        }
                        $path = "../../assets/images/";
                        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                        $file_name  = "Teacher_Img_" . time()  . '.' . $extension;
                        move_uploaded_file($_FILES['image']['tmp_name'],  $path . $file_name);
                        $final_name = 'assets/images/' . $file_name;
                    }

                $update_query =  "UPDATE teachers SET  username =  ?, fname = ? , lname =? ,address = ? , profile = ? , employee_number = ? , date_of_birth =?, phone_number = ? , qualification = ? , gender = ?, email = ?  WHERE teacher_id = ? ";
                $update_query_stmt = mysqli_prepare($connection , $update_query);
                mysqli_stmt_bind_param($update_query_stmt , 'sssssssssssi' , $username , $first_name , $last_name ,  $address ,$final_name, $emp_number , $dob , $phone_number , $qualification , $gender , $email , $teacher_id);
                if (mysqli_stmt_execute($update_query_stmt)) {
                                
                    $teacher_subject_delete_query = "DELETE FROM  teacher_subjects WHERE teacher_id1 = ?";
                    $teacher_subject_delete_query_stmt = mysqli_prepare($connection , $teacher_subject_delete_query);
                    mysqli_stmt_bind_param($teacher_subject_delete_query_stmt , 'i' , $teacher_id);
                    $dd = mysqli_stmt_execute($teacher_subject_delete_query_stmt);
                    $subjects11 = array_unique(array_merge($teacher_subjects, $all_subjects));
                    foreach ($subjects11 as $subject) {
                        $subject_query = "INSERT INTO  teacher_subjects  (teacher_id1 ,subject_id1) VALUES(? ,?) ";
                        $subject_query_stmt = mysqli_prepare($connection ,  $subject_query);
                        mysqli_stmt_bind_param($subject_query_stmt , 'ii' , $teacher_id , $subject);
                        $dddd = mysqli_stmt_execute($subject_query_stmt);
                    }

                    $teacher_class_delete_query = "DELETE FROM  teacher_class WHERE teacher_id1 = ?";
                    $teacher_class_delete_query_stmt = mysqli_prepare($connection , $teacher_class_delete_query);
                    mysqli_stmt_bind_param($teacher_class_delete_query_stmt , 'i'  , $teacher_id);
                    $dd = mysqli_stmt_execute($teacher_class_delete_query_stmt);
                    
                    $classes11 = array_unique(array_merge($teacher_classes, $all_classes));
                    foreach ($classes11 as $class) {
                        $class_query = "INSERT INTO  teacher_class  (teacher_id1 , class_id1) VALUES(? ,?) ";
                        $class_query_stmt = mysqli_prepare($connection , $class_query);
                        mysqli_stmt_bind_param($class_query_stmt , 'ii'  , $teacher_id , $class);
                        $dddd = mysqli_stmt_execute($class_query_stmt);
                    }
                    $mess = 'Teacher successfully updated!';
                    header("location: ../teacher-edit.php?error= $mess&teacher_id=$teacher_id");
                    exit;
                }
            }
        }
        } else {

            $mess = "make sure you are filled the all input and check box ";
            header("location:../teacher-edit.php?error=$mess&teacher_id=$teacher_id");
            exit;
        }
    }
} else {

    header('location:../../login.php');
}