
<?php


include('../../config/DB-connection.php');
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {


        $user_id = $_SESSION['id'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // 🔹 Get form data safely
            $first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
            $last_name  = mysqli_real_escape_string($connection, $_POST['last_name']);
            $user_name  = mysqli_real_escape_string($connection, $_POST['user_name']);

            // 🔹 Optional: check if username already exists (important)
            $checkQuery = "SELECT admin_id FROM admin WHERE username='$user_name' AND admin_id != '$user_id'";
            $checkResult = mysqli_query($connection, $checkQuery);

            if (mysqli_num_rows($checkResult) > 0) {
                die("Username already taken!");
            }

            // 🔹 Update query
            $query = "UPDATE admin 
              SET fname='$first_name',
                  lname='$last_name',
                  username='$user_name'
              WHERE admin_id='$user_id'";

            $result = mysqli_query($connection, $query);

            if ($result) {
                header("Location: ../profile.php?mess=Profile updated successfully");
                exit();
            } else {
                echo "Error updating profile: " . mysqli_error($connection);
            }
        }
    } else {
        $message = "some things went wrong try again ";
        header("location:../profile.php?mess=$message");
        exit;
    }
} else {

    header('location:../../login.php');
}
