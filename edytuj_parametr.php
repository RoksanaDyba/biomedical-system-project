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

$komunikat = "";

if (!isset($_GET["id"]) && !isset($_POST["id"])) {
    die("Brak ID parametru.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = mysqli_real_escape_string($conn, $_POST["id"]);

    $nazwa = mysqli_real_escape_string($conn, $_POST["nazwa"]);

    $jednostka_id = mysqli_real_escape_string(
        $conn,
        $_POST["jednostka_id"]
    );

    $norma_min = mysqli_real_escape_string(
        $conn,
        $_POST["norma_min"]
    );

    $norma_max = mysqli_real_escape_string(
        $conn,
        $_POST["norma_max"]
    );

    $sql = "
    UPDATE parametry
    SET
        nazwa='$nazwa',
        jednostka_id='$jednostka_id',
        norma_min='$norma_min',
        norma_max='$norma_max'
    WHERE id='$id'
    AND user_id='".$_SESSION["current_user"]."'
    ";

    if (mysqli_query($conn, $sql)) {

        $komunikat = "Parametr został zaktualizowany.";

    } else {

        $komunikat = "Błąd edycji: " . mysqli_error($conn);
    }
}

$id = isset($_GET["id"])
    ? $_GET["id"]
    : $_POST["id"];

$id = mysqli_real_escape_string($conn, $id);

$sql = "SELECT * FROM parametry WHERE id='$id'";

$result = mysqli_query($conn, $sql);

$parametr = mysqli_fetch_assoc($result);

if (!$parametr) {
    die("Parametr nie istnieje.");
}

if ((int)$parametr["user_id"] !== (int)$_SESSION["current_user"]) {
    die("Brak dostępu.");
}

?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>Edytuj parametr</title>
    <link rel="stylesheet" href="styl.css">
</head>

<body>

<h1>Edytuj badanie / parametr</h1>

<p><?php echo $komunikat; ?></p>

<form method="POST">

    <input
        type="hidden"
        name="id"
        value="<?php echo $parametr["id"]; ?>"
    >

    <label>Nazwa badania:</label>

    <input
        type="text"
        name="nazwa"
        required
        value="<?php echo $parametr["nazwa"]; ?>"
    >

    <br><br>

    <label>Jednostka:</label>

    <select name="jednostka_id" required>

        <?php

        $sql = "
        SELECT *
        FROM jednostki
        ORDER BY nazwa ASC
        ";

        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {

            $selected = "";

            if ($row["id"] == $parametr["jednostka_id"]) {
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

    <br><br>

    <label>Norma minimalna:</label>

    <input
        type="number"
        step="0.01"
        name="norma_min"
        value="<?php echo $parametr["norma_min"]; ?>"
    >

    <br><br>

    <label>Norma maksymalna:</label>

    <input
        type="number"
        step="0.01"
        name="norma_max"
        value="<?php echo $parametr["norma_max"]; ?>"
    >

    <br><br>

    <input type="submit" value="Zapisz zmiany">

</form>

<br><br>

<a href="parametry.php">
    Powrót do katalogu badań
</a>

</body>

</html>

<?php
mysqli_close($conn);
?>