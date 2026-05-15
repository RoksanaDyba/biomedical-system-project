<?php
session_start();

if (!isset($_SESSION["current_user"])) {
    header("Location: logowanie/logowanie2026.php");
    exit();
}

include "config.php";

$conn = mysqli_connect(
    $dbservername,
    $dbusername,
    $dbpassword,
    $dbname
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET["id"])) {

    $id = mysqli_real_escape_string($conn, $_GET["id"]);

    $user_id = $_SESSION["current_user"];

    $sql = "
    DELETE FROM pomiary
    WHERE id='$id'
    AND user_id='$user_id'
    ";

    mysqli_query($conn, $sql);
}

mysqli_close($conn);

header("Location: pomiary.php");
exit();
?>