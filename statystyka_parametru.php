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

$user_id = $_SESSION["current_user"];
$wyniki = null;
$przekroczenia = null;
$parametr_info = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $parametr_id = mysqli_real_escape_string($conn, $_POST["parametr_id"]);
    $data_od = mysqli_real_escape_string($conn, $_POST["data_od"]);
    $data_do = mysqli_real_escape_string($conn, $_POST["data_do"]);

    $sql = "
    SELECT 
        parametry.nazwa,
        parametry.norma_min,
        parametry.norma_max,
        jednostki.symbol
    FROM parametry
    JOIN jednostki ON parametry.jednostka_id = jednostki.id
    WHERE parametry.id = '$parametr_id'
    ";

    $result = mysqli_query($conn, $sql);
    $parametr_info = mysqli_fetch_assoc($result);

    $sql = "
    SELECT
        MIN(wartosc) AS minimum,
        MAX(wartosc) AS maksimum,
        AVG(wartosc) AS srednia,
        COUNT(*) AS liczba
    FROM pomiary
    WHERE user_id = '$user_id'
    AND parametr_id = '$parametr_id'
    AND data_pomiaru BETWEEN '$data_od' AND '$data_do'
    ";

    $result = mysqli_query($conn, $sql);
    $wyniki = mysqli_fetch_assoc($result);

    $sql = "
    SELECT
        wartosc,
        data_pomiaru
    FROM pomiary
    WHERE user_id = '$user_id'
    AND parametr_id = '$parametr_id'
    AND data_pomiaru BETWEEN '$data_od' AND '$data_do'
    AND (
        wartosc < '".$parametr_info["norma_min"]."'
        OR wartosc > '".$parametr_info["norma_max"]."'
    )
    ORDER BY data_pomiaru DESC
    ";

    $przekroczenia = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Statystyka parametru</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>

<h1>Statystyka wybranego parametru</h1>

<form method="POST">

    <label>Parametr:</label>

    <select name="parametr_id" required>

        <?php
        $sql = "
        SELECT 
            parametry.id,
            parametry.nazwa,
            jednostki.symbol
        FROM parametry
        JOIN jednostki ON parametry.jednostka_id = jednostki.id
        ORDER BY parametry.nazwa ASC
        ";

        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "
            <option value='".$row["id"]."'>
                ".$row["nazwa"]." [".$row["symbol"]."]
            </option>
            ";
        }
        ?>

    </select>

    <br><br>

    <label>Data od:</label>
    <input type="datetime-local" name="data_od" required>

    <br><br>

    <label>Data do:</label>
    <input type="datetime-local" name="data_do" required>

    <br><br>

    <input type="submit" value="Pokaż statystykę">

</form>

<hr>

<?php
if ($wyniki && $wyniki["liczba"] > 0) {
?>

<h2>Wyniki analizy</h2>

<p>
    Parametr:
    <b>
        <?php echo $parametr_info["nazwa"]; ?>
    </b>
</p>

<p>
    Norma:
    <?php echo $parametr_info["norma_min"]; ?>
    -
    <?php echo $parametr_info["norma_max"]; ?>
    <?php echo $parametr_info["symbol"]; ?>
</p>

<table border="1" cellpadding="10">

<tr>
    <th>Liczba pomiarów</th>
    <th>Minimum</th>
    <th>Maksimum</th>
    <th>Średnia</th>
</tr>

<tr>
    <td><?php echo $wyniki["liczba"]; ?></td>
    <td><?php echo $wyniki["minimum"] . " " . $parametr_info["symbol"]; ?></td>
    <td><?php echo $wyniki["maksimum"] . " " . $parametr_info["symbol"]; ?></td>
    <td><?php echo round($wyniki["srednia"], 2) . " " . $parametr_info["symbol"]; ?></td>
</tr>

</table>

<h2>Przekroczenia norm</h2>

<table border="1" cellpadding="10">

<tr>
    <th>Wartość</th>
    <th>Data pomiaru</th>
    <th>Status</th>
</tr>

<?php
if (mysqli_num_rows($przekroczenia) == 0) {

    echo "<tr><td colspan='3'>Brak przekroczeń norm.</td></tr>";

} else {

    while ($row = mysqli_fetch_assoc($przekroczenia)) {

        if ($row["wartosc"] < $parametr_info["norma_min"]) {
            $status = "Poniżej normy";
        } else {
            $status = "Powyżej normy";
        }

        echo "<tr>";
        echo "<td>".$row["wartosc"]." ".$parametr_info["symbol"]."</td>";
        echo "<td>".$row["data_pomiaru"]."</td>";
        echo "<td>".$status."</td>";
        echo "</tr>";
    }
}
?>

</table>

<?php
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<p>Brak pomiarów dla wybranego parametru i okresu.</p>";
}
?>

<br><br>

<a href="index.php">Powrót</a>

</body>
</html>

<?php
mysqli_close($conn);
?>