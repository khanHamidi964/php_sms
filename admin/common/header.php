<?php
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['role'])) {

    header('../login.php');
}
?>