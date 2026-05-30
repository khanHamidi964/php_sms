<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Teacher') {


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher - Students Grade</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="icon" href="../assets/logo/logo.png">
    <link rel="stylesheet" href="../assets/css/bootstrapIcon.css">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">





</head>

<body class="">
    <?php include('common/navbar.php') ?>


    <div class="container mt-4">
        <div class="row">
            <div class="col ">
                <?php
                        $query_stmt = "SELECT * FROM subjects JOIN teacher_subjects ON subjects.subject_id = teacher_subjects.subject_id1 WHERE teacher_id1 = {$_SESSION['id']}";
                        $data_query_stmt = mysqli_prepare($connection, $query_stmt);
                        mysqli_stmt_execute($data_query_stmt);
                        $data_result = mysqli_stmt_get_result($data_query_stmt);
                        $count = $data_result->num_rows;


                        while ($data = $data_result->fetch_assoc()) {



                        ?>
                <div class="div my-2">
                    <div class="table-responsive border border-2 p-4">
                        <div>


                        </div>
                        <table class="table">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Last Name</th>
                                    <th>Marks</th>
                                    <th>Result</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                            $query = "SELECT * FROM student_score JOIN students ON student_score.student_id1 = students.student_id WHERE subject_id1 = {$data['subject_id']} ";
                                            $query_stmt = mysqli_prepare($connection, $query);
                                            mysqli_stmt_execute($query_stmt);
                                            $result = mysqli_stmt_get_result($query_stmt);
                                            $count = $result->num_rows;
                                            $count22 = 0;
                                            if ($count >= 1) {

                                                while ($row = $result->fetch_assoc()) {
                                                    $count22++;
                                                
                                                        
                                                    

                                            ?>
                                <tr>

                                    <td><?= $count22 ?> </td>
                                    <td><?= $row['fname'] ?> </td>
                                    <td><?= $row['lname'] ?> </td>
                                    <td><?= $row['results'] ?> </td>
                                    <td><?php

                                                            if ($row['results'] >= 55) {
                                                                echo "<button class ='btn btn-success btn-sm w-100'>Success </button>";
                                                            } else {
                                                                echo "<button class ='btn btn-danger btn-sm w-100'>Fail </button>";
                                                            }
                                                            ?> </td>
                                </tr>
                                <?php
                                                }
                                            } else {
                                                echo "<div class='alert alert-info text-center'>NOT found the mark sheet</div>";
                                            }




                                            ?>
                            </tbody>
                        </table>
                    </div>


                </div>

                <?php   } ?>
            </div>


        </div>
    </div>



    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/jquery.js"></script>


</body>

<script>
$(document).ready(function() {
    $('#navLink li:nth-child(4) a').addClass('active')




    $('#close-btn').on('click', function(e) {
        e.preventDefault()
        $('.alert-div').removeClass('alert alert-warning').addClass('text-white')
        $('#close-btn').removeClass('text-danger').addClass('text-white')
    })
})
</script>

</html>

<?php

    } else {
        header("location:../login.php");
    }
} else {
    header("location:../login.php");
}

?>