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

    $check = "SELECT * FROM parametry WHERE jednostka_id='$id'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) == 0) {
        $sql = "DELETE FROM jednostki WHERE id='$id'";
        mysqli_query($conn, $sql);
    }
}

mysqli_close($conn);

header("Location: jednostki.php");
exit();
?>