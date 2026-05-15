<?php
session_start();

if (!isset($_SESSION["current_user"])) {
    header("Location: logowanie/logowanie2026.php");
    exit();
}

include "config.php";

$dbconn = mysqli_connect(
    $dbservername,
    $dbusername,
    $dbpassword,
    $dbname
);

if (!$dbconn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "
SELECT
    parametry.id,
    parametry.nazwa,
    parametry.norma_min,
    parametry.norma_max,
    jednostki.symbol,
    users.user_fullname
FROM parametry
JOIN jednostki
ON parametry.jednostka_id = jednostki.id
LEFT JOIN users
ON parametry.user_id = users.user_id
ORDER BY parametry.nazwa ASC
";

$query = mysqli_query($dbconn, $sql);
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>Parametry biomedyczne</title>
    <link rel="stylesheet" href="styl.css">
</head>

<body>

<h1>Parametry biomedyczne</h1>

<a href="dodaj_parametr.php">
    Dodaj parametr
</a>

<br><br>

<table border="1" cellpadding="10">

<tr>
    <th>Parametr</th>
    <th>Jednostka</th>
    <th>Norma</th>
    <th>Utworzył</th>
    <th>Akcja</th>
</tr>

<?php

while ($row = mysqli_fetch_assoc($query)) {

    echo "<tr>";

    echo "<td>" . $row["nazwa"] . "</td>";

    echo "<td>" . $row["symbol"] . "</td>";

    echo "<td>" . $row["norma_min"] . " - " . $row["norma_max"] . " " . $row["symbol"] . "</td>";

    echo "<td>" . ($row["user_fullname"] ? $row["user_fullname"] : "brak danych") . "</td>";

    echo "
    <td>
        <a href='edytuj_parametr.php?id=".$row["id"]."'>Edytuj</a>
        |
        <a href='usun_parametr.php?id=".$row["id"]."'>Usuń</a>
    </td>
    ";

    echo "</tr>";
}

?>

</table>

<br><br>

<a href="index.php">Powrót</a>

</body>

</html>

<?php
mysqli_close($dbconn);
?>