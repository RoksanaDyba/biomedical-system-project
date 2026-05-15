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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $stare_haslo = $_POST["stare_haslo"];
    $nowe_haslo = $_POST["nowe_haslo"];
    $powtorz_haslo = $_POST["powtorz_haslo"];

    $user_id = $_SESSION["current_user"];

    $sql = "SELECT * FROM users WHERE user_id='$user_id'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if (!password_verify($stare_haslo, $user["user_passwordhash"])) {

        $komunikat = "Stare hasło jest nieprawidłowe.";

    } else if ($nowe_haslo != $powtorz_haslo) {

        $komunikat = "Nowe hasła nie są takie same.";

    } else {

        $nowy_hash = password_hash($nowe_haslo, PASSWORD_DEFAULT);

        $update = "
        UPDATE users
        SET user_passwordhash='$nowy_hash'
        WHERE user_id='$user_id'
        ";

        if (mysqli_query($conn, $update)) {
            $komunikat = "Hasło zostało zmienione.";
        } else {
            $komunikat = "Błąd zmiany hasła.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Zmiana hasła</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>

<h1>Zmiana hasła</h1>

<p><?php echo $komunikat; ?></p>

<form method="POST">

    <label>Stare hasło:</label>
    <input type="password" name="stare_haslo" required>

    <br><br>

    <label>Nowe hasło:</label>
    <input type="password" name="nowe_haslo" required>

    <br><br>

    <label>Powtórz nowe hasło:</label>
    <input type="password" name="powtorz_haslo" required>

    <br><br>

    <input type="submit" value="Zmień hasło">

</form>

<br>

<a href="index.php">Powrót</a>

</body>
</html>

<?php
mysqli_close($conn);
?>