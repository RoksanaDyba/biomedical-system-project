<?php
session_start();

if (!isset($_SESSION["current_user"])) {
    header("Location: logowanie/logowanie2026.php");
    exit();
}

include "config.php";

$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$komunikat = "";
$user_id = $_SESSION["current_user"];

$wybrany_parametr = "";

if (isset($_GET["parametr_id"])) {
    $wybrany_parametr = $_GET["parametr_id"];
}

if (isset($_POST["parametr_id"])) {
    $wybrany_parametr = $_POST["parametr_id"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $parametr_id = mysqli_real_escape_string($conn, $_POST["parametr_id"]);
    $wartosc = mysqli_real_escape_string($conn, $_POST["wartosc"]);
    $data_pomiaru = mysqli_real_escape_string($conn, $_POST["data_pomiaru"]);

    $sql = "
    INSERT INTO pomiary
    (user_id, parametr_id, wartosc, data_pomiaru)
    VALUES
    ('$user_id', '$parametr_id', '$wartosc', '$data_pomiaru')
    ";

    if (mysqli_query($conn, $sql)) {
        $komunikat = "Dodano pomiar dla wybranego parametru.";
    } else {
        $komunikat = "Błąd: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pomiary jednego parametru</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>

<h1>Pomiary jednego parametru</h1>

<p><?php echo $komunikat; ?></p>

<form method="GET">

    <label>Wybierz parametr:</label>

    <select name="parametr_id" required>

        <?php
        $sql = "
        SELECT
            parametry.id,
            parametry.nazwa,
            jednostki.symbol
        FROM parametry
        JOIN jednostki
        ON parametry.jednostka_id = jednostki.id
        ";

        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {

            $selected = "";

            if ($wybrany_parametr == $row["id"]) {
                $selected = "selected";
            }

            echo "
            <option value='".$row["id"]."' $selected>
                ".$row["nazwa"]." [".$row["symbol"]."]
            </option>
            ";
        }
        ?>

    </select>

    <input type="submit" value="Pokaż">

</form>

<hr>

<?php
if ($wybrany_parametr != "") {
?>

<h2>Dodaj pomiar dla wybranego parametru</h2>

<form method="POST">

    <input type="hidden" name="parametr_id" value="<?php echo $wybrany_parametr; ?>">

    <label>Wartość:</label>
    <input type="number" step="0.01" name="wartosc" required>

    <br><br>

    <label>Data pomiaru:</label>
    <input type="datetime-local" name="data_pomiaru" required>

    <br><br>

    <input type="submit" value="Dodaj pomiar">

</form>

<hr>

<h2>Historia pomiarów wybranego parametru</h2>

<table border="1" cellpadding="10">

<tr>
    <th>Parametr</th>
    <th>Wartość</th>
    <th>Jednostka</th>
    <th>Data</th>
</tr>

<?php

$parametr_id = mysqli_real_escape_string($conn, $wybrany_parametr);

$sql = "
SELECT
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
AND pomiary.parametr_id = '$parametr_id'

ORDER BY pomiary.data_pomiaru DESC
";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {

    echo "<tr>";
    echo "<td>".$row["nazwa"]."</td>";
    echo "<td>".$row["wartosc"]."</td>";
    echo "<td>".$row["symbol"]."</td>";
    echo "<td>".$row["data_pomiaru"]."</td>";
    echo "</tr>";
}

?>

</table>

<?php
}
?>

<br><br>

<a href="index.php">Powrót</a>

</body>
</html>

<?php
mysqli_close($conn);
?>