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
    <title>Teacher - Students</title>
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
                <div class=" text-center  ">
                    <div class=" table-responsive n-table  mt-3 ">
                        <table class="table table-bordered table-hover shadow ">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">#</th>

                                    <th scope="col">Class</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                        $tech_query = "SELECT * FROM teacher_class JOIN classes ON teacher_class.class_id1 = classes.class_id JOIN grades ON classes.grade_id = grades.grade_id JOIN section ON classes.section_id = section.section_id    WHERE teacher_id1 = {$_SESSION['id']}  ";
                                        $tech_result = mysqli_query($connection,  $tech_query);
                                        if (mysqli_num_rows($tech_result) > 0) {

                                            $count = 0;
                                            while ($class = mysqli_fetch_assoc($tech_result)) {
                                                $count++;
                                        ?>
                                <tr class="text-center">
                                    <th scope="row"><?= $count ?></th>

                                    <?php

                                                    $grades = "SELECT * FROM grades WHERE grade_id = {$class['grade_id']}";
                                                    $grades_result = mysqli_query($connection, $grades);
                                                    $grades_row = mysqli_fetch_assoc($grades_result);
                                                    $sections = "SELECT * FROM section WHERE section_id = {$class['section_id']}";
                                                    $section_result = mysqli_query($connection, $sections);
                                                    $section_row = mysqli_fetch_assoc($section_result);
                                                    ?>
                                    <td>
                                        <a
                                            href="student-in-class.php?section_id=<?php echo $section_row['section_id']?>&grade_id=<?php echo $grades_row['grade_id'] ?>"><?= $grades_row['grade_code'] .  '-' . $grades_row['grade'] . $section_row['section'] ?></a>

                                    </td>
                                </tr>

                                <?php
                                            }
                                        } else {

                                            ?>
                                <tr>
                                    <td colspan="8">
                                        <div class="alert alert-info">Empty!</div>
                                    </td>
                                </tr>
                                <?php
                                        }
                                        ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



    </div>



    <script src="../assets/js/bootstrap.js"></script>
    <script src="../assets/js/jquery.js"></script>


</body>

<script>
$(document).ready(function() {
    $('#navLink li:nth-child(3) a').addClass('active')




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