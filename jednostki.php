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

$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$komunikat = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nazwa = mysqli_real_escape_string($conn, $_POST["nazwa"]);
    $symbol = mysqli_real_escape_string($conn, $_POST["symbol"]);

    if (isset($_POST["id"]) && $_POST["id"] != "") {

        $id = mysqli_real_escape_string($conn, $_POST["id"]);

        $sql = "
        UPDATE jednostki
        SET nazwa='$nazwa', symbol='$symbol'
        WHERE id='$id'
        ";

        if (mysqli_query($conn, $sql)) {
            $komunikat = "Jednostka została zaktualizowana.";
        } else {
            $komunikat = "Błąd edycji: " . mysqli_error($conn);
        }

    } else {

        $sql = "
        INSERT INTO jednostki(nazwa, symbol)
        VALUES('$nazwa', '$symbol')
        ";

        if (mysqli_query($conn, $sql)) {
            $komunikat = "Dodano nową jednostkę.";
        } else {
            $komunikat = "Błąd dodawania: " . mysqli_error($conn);
        }
    }
}

$edytowana_jednostka = null;

if (isset($_GET["edit"])) {

    $edit_id = mysqli_real_escape_string($conn, $_GET["edit"]);

    $sql = "SELECT * FROM jednostki WHERE id='$edit_id'";
    $result = mysqli_query($conn, $sql);

    $edytowana_jednostka = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Jednostki biomedyczne</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>

<h1>Jednostki wielkości biomedycznych</h1>

<p><?php echo $komunikat; ?></p>

<h2>
<?php
if ($edytowana_jednostka) {
    echo "Edytuj jednostkę";
} else {
    echo "Dodaj nową jednostkę";
}
?>
</h2>

<form method="POST">

    <input 
        type="hidden" 
        name="id" 
        value="<?php echo $edytowana_jednostka ? $edytowana_jednostka["id"] : ""; ?>"
    >

    <label>Nazwa jednostki:</label>
    <input 
        type="text" 
        name="nazwa" 
        required
        value="<?php echo $edytowana_jednostka ? $edytowana_jednostka["nazwa"] : ""; ?>"
    >

    <br><br>

    <label>Symbol:</label>
    <input 
        type="text" 
        name="symbol" 
        required
        value="<?php echo $edytowana_jednostka ? $edytowana_jednostka["symbol"] : ""; ?>"
    >

    <br><br>

    <input 
        type="submit" 
        value="<?php echo $edytowana_jednostka ? "Zapisz zmiany" : "Dodaj jednostkę"; ?>"
    >

</form>

<hr>

<h2>Lista jednostek</h2>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Nazwa</th>
    <th>Symbol</th>
    <th>Akcja</th>
</tr>

<?php

$sql = "SELECT * FROM jednostki ORDER BY id ASC";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {

    echo "<tr>";

    echo "<td>".$row["id"]."</td>";
    echo "<td>".$row["nazwa"]."</td>";
    echo "<td>".$row["symbol"]."</td>";

    echo "
    <td>
        <a href='jednostki.php?edit=".$row["id"]."'>Edytuj</a>
        |
        <a href='usun_jednostke.php?id=".$row["id"]."'>Usuń</a>
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
mysqli_close($conn);
?>