<?php
session_start();

if (!isset($_SESSION["current_user"])) {
    header("Location: logowanie/logowanie2026.php");
    exit();
}

$conn = mysqli_connect(
    "mysql.agh.edu.pl",
    "roksanad",
    "inXmULFh3k3ByrMi",
    "roksanad"
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET["id"])) {

    $id = mysqli_real_escape_string($conn, $_GET["id"]);

    $check = "SELECT * FROM pomiary WHERE parametr_id='$id'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) == 0) {
        $sql = "DELETE FROM parametry WHERE id='$id'";
        mysqli_query($conn, $sql);
    }
}

mysqli_close($conn);

header("Location: parametry.php");
exit();
?>