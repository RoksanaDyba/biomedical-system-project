<?php
session_start();

if (!isset($_SESSION["current_user"])) {
    header("Location: logowanie/logowanie2026.php");
    exit();
}

$dbservername = "mysql.agh.edu.pl";
$dbusername = "roksanad";
$dbpassword = "inXmULFh3k3ByrMi";
$dbname = "roksanad";

$conn = mysqli_connect(
    $dbservername,
    $dbusername,
    $dbpassword,
    $dbname
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>Moje pomiary</title>
    <link rel="stylesheet" href="styl.css">
</head>

<body>

<h1>Moje pomiary</h1>

<a href="dodaj_pomiar.php">Dodaj nowy pomiar</a>

<br><br>

<table border="1" cellpadding="10">

<tr>
    <th>Parametr</th>
    <th>Wartość</th>
    <th>Jednostka</th>
    <th>Data</th>
    <th>Akcja</th>
</tr>

<?php

$user_id = $_SESSION["current_user"];

$sql = "
SELECT
    pomiary.id,
    pomiary.wartosc,
    pomiary.data_pomiaru,
    parametry.nazwa,
    jednostki.symbol
FROM pomiary

JOIN parametry
ON pomiary.parametr_id = parametry.id

JOIN jednostki
ON parametry.jednostka_id = jednostki.id

WHERE pomiary.user_id = '$user_id'

ORDER BY pomiary.data_pomiaru DESC
";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {

    echo "<tr>";

    echo "<td>".$row["nazwa"]."</td>";

    echo "<td>".$row["wartosc"]."</td>";

    echo "<td>".$row["symbol"]."</td>";

    echo "<td>".$row["data_pomiaru"]."</td>";

    echo "
    <td>
        <a href='edytuj_pomiar.php?id=".$row["id"]."'>Edytuj</a>
        |
        <a href='usun_pomiar.php?id=".$row["id"]."'>Usuń</a>
    </td>
    ";
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