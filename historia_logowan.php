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

$sql = "
SELECT *
FROM logowania
ORDER BY data_proby DESC
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Historia logowań</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>

<h1>Historia logowań</h1>

<table border="1" cellpadding="10">

<tr>
    <th>Email</th>
    <th>Status</th>
    <th>IP</th>
    <th>Data próby</th>
</tr>

<?php

while ($row = mysqli_fetch_assoc($result)) {

    echo "<tr>";

    echo "<td>".$row["email"]."</td>";

    if ($row["sukces"] == 1) {
        echo "<td>Udane</td>";
    } else {
        echo "<td>Nieudane</td>";
    }

    echo "<td>".$row["ip"]."</td>";

    echo "<td>".$row["data_proby"]."</td>";

    echo "</tr>";
}

?>

</table>

<br><br>

<a href="index.php">Powrót</a>

</body>
</html>

<?php
mysqli_close($conn);
?>