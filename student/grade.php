<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'Student') {


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Student - Grade</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="icon" href="../assets/logo/logo.png">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body class="bg-light">

    <?php include('common/navbar.php')   ?>

    <div class="container my-5">
        <div class="container">
            <div class="row d-flex justify-content-center mb-4">
                <div class=" table-responsive G-table  mt-2">

                    <?php

                            $semester_query = "SELECT * FROM semesters ORDER BY semester DESC  ";
                            $semester_query_stmt = mysqli_prepare($connection, $semester_query);
                            mysqli_stmt_execute($semester_query_stmt);
                            $semester_result = mysqli_stmt_get_result($semester_query_stmt);
                            while ($semester_row = $semester_result->fetch_assoc()) {

                                $stu_query = "SELECT * FROM student_score JOIN subjects ON student_score.subject_id1 = subjects.subject_id WHERE student_id1 = ?";
                                $stu_query_stmt =  mysqli_prepare($connection, $stu_query);
                                mysqli_stmt_bind_param($stu_query_stmt, 'i', $_SESSION['id']);
                                mysqli_stmt_execute($stu_query_stmt);
                                $result = mysqli_stmt_get_result($stu_query_stmt);

                                while ($student_row = $result->fetch_assoc()) {
                                    if ($semester_row['semester_id'] == $student_row['semester']) {
                            ?>
                    <h5 class="text-center mb-3 mt-5">year <?= $student_row['year'] . ' ' ?> - semester
                        <?= $semester_row['semester'] ?></h5>
                    <table class="table table-bordered table-hover shadow">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">#</th>
                                <th scope="col">Course Code </th>
                                <th scope="col">Course Title </th>
                                <th scope="col">Grade </th>
                                <th scope="col">Results</th>
                                <th scope="col">Total</th>
                                <th scope="col">Chance 1</th>
                                <th scope="col">Chance 2</th>
                                <th scope="col">Chance 3</th>
                                <th scope="col">Chance 4</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">

                            <?php

                                                $query = "SELECT * FROM student_score JOIN subjects ON student_score.subject_id1 = subjects.subject_id WHERE student_id1 = ? AND semester = ?";
                                                $query_stmt =  mysqli_prepare($connection, $query);
                                                mysqli_stmt_bind_param($query_stmt, 'ii', $_SESSION['id'],  $semester_row['semester_id']);
                                                mysqli_stmt_execute($query_stmt);

                                                $result = mysqli_stmt_get_result($query_stmt);
                                                $count = $result->num_rows;

                                                if ($count >= 0) {
                                                    $count11 = 0;

                                                    while ($row = $result->fetch_assoc()) {

                                                        $count11++;

                                                ?>
                            <tr>
                                <td><?= $count11 ?></td>
                                <td><?= $row['subject_code']  ?></td>
                                <td><?= $row['subject'] ?></td>
                                <?php

                                                            if ($row['results'] >= 90 &&  $row['results'] <= 100) {
                                                                echo "<th> A+ </th>";
                                                            } else if ($row['results'] >= 80 &&  $row['results'] <= 90) {
                                                                echo "<th> B+ </th>";
                                                            } else if ($row['results'] >= 70 &&  $row['results'] <= 80) {
                                                                echo "<th> C+ </th>";
                                                            } else if ($row['results'] >= 60 &&  $row['results'] <= 70) {
                                                                echo "<th> D+ </th>";
                                                            } else if ($row['results'] >= 55 &&  $row['results'] <= 60) {
                                                                echo "<th> E+ </th>";
                                                            } else {
                                                                echo "<th> 0 </th>";
                                                            }
                                                            ?>

                                <?php

                                                            if ($row['results'] >= 55) {
                                                                echo " <td>Success</td>";
                                                            } else {
                                                                echo "  <td>Failure</td>";
                                                            }


                                                            ?>


                                <th>
                                    <?= $row['results'] ?></th>
                                <td><?php

                                                                if ($row['results'] >= 55) {
                                                                    echo "Pass";
                                                                } else {
                                                                    echo "Fail";
                                                                }


                                                                ?></td>
                                <td>
                                </td>
                                <td>

                                </td>
                                <td></td>
                            </tr>

                            <?php

                                                    }
                                                }


                                                ?>
                        </tbody>
                    </table>

                    <?php
                                    }
                                }
                            }
                            ?>
                </div>
            </div>
        </div>

    </div>




    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/jquery.js"></script>


</body>

<script>
$(document).ready(function() {
    $('#navLink li:nth-child(2) a').addClass('active')
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
?>