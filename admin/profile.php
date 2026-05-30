<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Admin') {


?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Admin- Add Class</title>
            <link rel="stylesheet" href="../assets/css/bootstrap.css">
            <link rel="stylesheet" href="../assets/css/home.css">
            <link rel="icon" href="../assets/logo/logo.png">

            <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">

            <style>
                body {
                    background: #f4f6f9;
                    font-family: 'Segoe UI', sans-serif;
                }

                /* Card Style */
                .custom-card {
                    background: #fff;
                    border-radius: 14px;
                    padding: 25px;
                    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
                    transition: 0.3s ease;
                }

                .custom-card:hover {
                    transform: translateY(-3px);
                }

                /* Title */
                .card-title {
                    font-size: 20px;
                    font-weight: 600;
                    margin-bottom: 20px;
                    color: #333;
                    border-left: 4px solid #0d6efd;
                    padding-left: 10px;
                }

                /* Form */
                .form-group {
                    margin-bottom: 15px;
                }

                .form-group label {
                    font-size: 14px;
                    font-weight: 500;
                    margin-bottom: 6px;
                    display: block;
                    color: #555;
                }

                .form-group input {
                    width: 100%;
                    padding: 10px 12px;
                    border-radius: 8px;
                    border: 1px solid #ddd;
                    outline: none;
                    transition: 0.3s;
                }

                .form-group input:focus {
                    border-color: #0d6efd;
                    box-shadow: 0 0 5px rgba(13, 110, 253, 0.2);
                }

                /* Buttons */
                .btn-primary-custom,
                .btn-success-custom {
                    width: 100%;
                    padding: 10px;
                    border: none;
                    border-radius: 8px;
                    color: white;
                    font-weight: 600;
                    cursor: pointer;
                    transition: 0.3s;
                }

                .btn-primary-custom {
                    background: #0d6efd;
                }

                .btn-primary-custom:hover {
                    background: #0b5ed7;
                }

                .btn-success-custom {
                    background: #198754;
                }

                .btn-success-custom:hover {
                    background: #157347;
                }

                /* Profile Image Preview */
                .image-preview {
                    display: flex;
                    justify-content: center;
                    margin: 15px 0;
                }

                .image-preview img {
                    width: 110px;
                    height: 110px;
                    border-radius: 50%;
                    object-fit: cover;
                    border: 3px solid #ddd;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                }

                .alert-div {
                    position: relative;
                    margin-bottom: 15px;
                }

                /* Custom alert box styling */
                .alert-div .alert {
                    border: none;
                    border-radius: 10px;
                    padding: 12px 18px;
                    font-size: 14px;
                    font-weight: 500;
                    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                }

                /* Warning style enhancement */
                .alert-warning {
                    background: linear-gradient(135deg, #fff3cd, #ffe8a1);
                    color: #7a5d00;
                }

                /* Close button */
                #close-btn {
                    font-weight: bold;
                    font-size: 14px;
                    padding: 2px 8px;
                    border-radius: 6px;
                    transition: 0.3s ease;
                }

                #close-btn:hover {
                    background: rgba(255, 0, 0, 0.1);
                    color: red !important;
                }

                /* Optional animation */
                .alert-div .alert {
                    animation: slideDown 0.4s ease-in-out;
                }

                @keyframes slideDown {
                    from {
                        transform: translateY(-10px);
                        opacity: 0;
                    }

                    to {
                        transform: translateY(0);
                        opacity: 1;
                    }
                }
            </style>
        </head>

        <body>

            <?php include('common/navbar.php') ?>
            <?php include('../config/DB-connection.php') ?>

            <div class="container-fluid mt-4">

                <div class="row g-4">


                    <!-- Change Password -->
                    <div class="col-md-6">
                        <div class="custom-card">
                            <div class="col">
                                <div class="d-flex justify-content-end alert-div">

                                    <?php
                                    if (isset($_GET['mess1'])) {

                                    ?>
                                        <div class="alert alert-warning alert-div"> <?= $_GET['mess1'] ?>&nbsp;&nbsp;&nbsp; <a href="javascript:void(0)" id="close-btn"
                                                class="text-decoration-none text-danger c-pointer">
                                                X
                                            </a>
                                        </div>
                                    <?php

                                    } ?>

                                </div>
                            </div>
                            <div class="card-title">Change Password</div>

                            <form action="logic/change-password.php" method="POST">

                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input type="password" name="current_password" required>
                                </div>

                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" name="new_password" required>
                                </div>

                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" name="confirm_password" required>
                                </div>

                                <button type="submit" class="btn-primary-custom">Update Password</button>

                            </form>

                        </div>
                    </div>

                    <!-- Change Profile -->
                    <div class="col-md-6">
                        <div class="custom-card">
                            <div class="col">
                                <div class="d-flex justify-content-end alert-div">

                                    <?php
                                    if (isset($_GET['mess'])) {

                                    ?>
                                        <div class="alert alert-warning alert-div"> <?= $_GET['mess'] ?>&nbsp;&nbsp;&nbsp; <a href="javascript:void(0)" id="close-btn"
                                                class="text-decoration-none text-danger c-pointer">
                                                X
                                            </a>
                                        </div>
                                    <?php

                                    } ?>

                                </div>
                            </div>

                            <div class="card-title">Change Profile Data</div>
                            <form action="logic/update-profile.php" method="POST" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label>first Name</label>
                                    <input type="text" name="first_name" value="" required>
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" required>
                                </div>
                                <div class="form-group">
                                    <label>User Name</label>
                                    <input type="text" name="user_name" required>
                                </div>


                                <!-- Image Preview -->


                                <button type="submit" class="btn-success-custom">Update Profile</button>

                            </form>

                        </div>
                    </div>

                </div>
            </div>


        </body>
        <script>
            function previewImage(event) {
                const reader = new FileReader();
                reader.onload = function() {
                    document.getElementById('profilePreview').src = reader.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            }
        </script>
        <script>
            $(document).ready(function() {
                $('#navLink li:nth-child(6) a').addClass('active');
                $('#close-btn').on('click', function(e) {
                    e.preventDefault()
                    $('.alert-div').removeClass('alert alert-warning').addClass('text-white')
                    $('#close-btn').removeClass('text-danger').addClass('text-white')
                })




            })
        </script>

        <script>
            document.getElementById("close-btn").addEventListener("click", function() {
                this.closest(".alert-div").style.display = "none";
            });
        </script>

        </html>

<?php
        unset($_SESSION['old_grade']);
    } else {
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
}



?>