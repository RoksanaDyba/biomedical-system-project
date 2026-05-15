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

if (!isset($_GET["id"]) && !isset($_POST["id"])) {
    die("Brak ID pomiaru.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $wartosc = mysqli_real_escape_string($conn, $_POST["wartosc"]);
    $data_pomiaru = mysqli_real_escape_string($conn, $_POST["data_pomiaru"]);

    $sql = "
    UPDATE pomiary
    SET
        wartosc='$wartosc',
        data_pomiaru='$data_pomiaru'
    WHERE id='$id'
    AND user_id='$user_id'
    ";

    if (mysqli_query($conn, $sql)) {
        $komunikat = "Pomiar został zaktualizowany.";
    } else {
        $komunikat = "Błąd edycji: " . mysqli_error($conn);
    }
}

$id = isset($_GET["id"]) ? $_GET["id"] : $_POST["id"];
$id = mysqli_real_escape_string($conn, $id);

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

WHERE pomiary.id='$id'
AND pomiary.user_id='$user_id'
";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    die("Nie masz dostępu do tego pomiaru.");
}

$pomiar = mysqli_fetch_assoc($result);

$data_do_inputa = date("Y-m-d\TH:i", strtotime($pomiar["data_pomiaru"]));
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edytuj pomiar</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>

<h1>Edytuj pomiar</h1>

<p><?php echo $komunikat; ?></p>

<p>
    Parametr:
    <b>
        <?php echo $pomiar["nazwa"] . " [" . $pomiar["symbol"] . "]"; ?>
    </b>
</p>

<form method="POST">

    <input type="hidden" name="id" value="<?php echo $pomiar["id"]; ?>">

    <label>Wartość:</label>

    <input
        type="number"
        step="0.01"
        name="wartosc"
        required
        value="<?php echo $pomiar["wartosc"]; ?>"
    >

    <br><br>

    <label>Data i czas pomiaru:</label>

    <input
        type="datetime-local"
        name="data_pomiaru"
        required
        value="<?php echo $data_do_inputa; ?>"
    >

    <br><br>

    <input type="submit" value="Zapisz zmiany">

</form>

<br><br>

<a href="pomiary.php">Powrót do pomiarów</a>

</body>
</html>

<?php
mysqli_close($conn);
?>