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

$komunikat = "";
$user_id = $_SESSION["current_user"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $check = "
    SELECT COUNT(*) AS ile
    FROM parametry
    WHERE user_id = '$user_id'
    ";

    $result_check = mysqli_query($conn, $check);
    $row_check = mysqli_fetch_assoc($result_check);

    if ($row_check["ile"] >= 5) {

        $komunikat = "Nie możesz dodać więcej niż 5 pozycji katalogowych.";

    } else {

        $nazwa = mysqli_real_escape_string($conn, $_POST["nazwa"]);
        $jednostka_id = mysqli_real_escape_string($conn, $_POST["jednostka_id"]);

        $sql = "
        INSERT INTO parametry(nazwa, jednostka_id, user_id)
        VALUES('$nazwa', '$jednostka_id', '$user_id')
        ";

        if (mysqli_query($conn, $sql)) {
            $komunikat = "Dodano nowy parametr.";
        } else {
            $komunikat = "Błąd dodawania: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dodaj parametr</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>

<h1>Dodaj parametr biomedyczny</h1>

<p><?php echo $komunikat; ?></p>

<form method="POST">

    <label>Nazwa parametru:</label>
    <input type="text" name="nazwa" required>

    <br><br>

    <label>Jednostka:</label>
    <select name="jednostka_id" required>

        <?php
        $sql = "SELECT * FROM jednostki ORDER BY nazwa ASC";
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

    <input type="submit" value="Dodaj parametr">

</form>

<br><br>

<a href="parametry.php">Lista parametrów</a>
<br><br>
<a href="index.php">Powrót</a>

</body>
</html>

<?php
mysqli_close($conn);
?>