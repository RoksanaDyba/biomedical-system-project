<?php
session_start();

if (!isset($_SESSION["current_user"])) {
    header("Location: logowanie/logowanie2026.php");
    exit();
}

function chgw($dane) {

    $dane = trim($dane);
    $dane = stripslashes($dane);
    $dane = htmlspecialchars($dane);

    return $dane;
}

include "config.php";;

$conn = mysqli_connect(
    $dbservername,
    $dbusername,
    $dbpassword,
    $dbname
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$komunikat = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $parametr = chgw($_POST["parametr"]);
    $wartosc = chgw($_POST["wartosc"]);
    $data = chgw($_POST["data_pomiaru"]);

    $user_id = $_SESSION["current_user"];

    $sql = "
    INSERT INTO pomiary
    (user_id, parametr_id, wartosc, data_pomiaru)
    VALUES
    ('$user_id', '$parametr', '$wartosc', '$data')
    ";

    if (mysqli_query($conn, $sql)) {

        $komunikat = "Pomiar został dodany!";

    } else {

        $komunikat = "Błąd: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>Dodaj pomiar</title>
    <link rel="stylesheet" href="styl.css">
</head>

<body>

<h1>Dodaj pomiar biomedyczny</h1>

<p><?php echo $komunikat; ?></p>

<form method="POST">

    <label>Parametr:</label>

    <select name="parametr">

        <?php

        $sql = "SELECT * FROM parametry";

        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)) {

            echo "
            <option value='".$row["id"]."'>
                ".$row["nazwa"]."
            </option>
            ";
        }

        ?>

    </select>

    <br><br>

    <label>Wartość:</label>

    <input
        type="number"
        step="0.01"
        name="wartosc"
        required
    >

    <br><br>

    <label>Data pomiaru:</label>

    <input
        type="datetime-local"
        name="data_pomiaru"
        required
    >

    <br><br>

    <input type="submit" value="Dodaj pomiar">

</form>

<br><br>

<a href="pomiary.php">
    Moje pomiary
</a>

<br><br>

<a href="index.php">
    Strona główna
</a>

</body>

</html>

<?php
mysqli_close($conn);
?>