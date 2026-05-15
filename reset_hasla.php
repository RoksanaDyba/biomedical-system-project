<?php
session_start();

include "config.php";

$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$komunikat = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $nowe_haslo = $_POST["nowe_haslo"];
    $powtorz_haslo = $_POST["powtorz_haslo"];

    if ($nowe_haslo != $powtorz_haslo) {

        $komunikat = "Hasła nie są takie same.";

    } else {

        $sql = "SELECT * FROM users WHERE user_email='$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 0) {

            $komunikat = "Nie znaleziono użytkownika o podanym adresie email.";

        } else {

            $nowy_hash = password_hash($nowe_haslo, PASSWORD_DEFAULT);

            $update = "
            UPDATE users
            SET user_passwordhash='$nowy_hash'
            WHERE user_email='$email'
            ";

            if (mysqli_query($conn, $update)) {
                $komunikat = "Hasło zostało zresetowane. Możesz się zalogować.";
            } else {
                $komunikat = "Błąd resetowania hasła.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset hasła</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>

<h1>Reset hasła</h1>

<p><?php echo $komunikat; ?></p>

<form method="POST">

    <label>Email:</label>
    <input type="email" name="email" required>

    <br><br>

    <label>Nowe hasło:</label>
    <input type="password" name="nowe_haslo" required>

    <br><br>

    <label>Powtórz nowe hasło:</label>
    <input type="password" name="powtorz_haslo" required>

    <br><br>

    <input type="submit" value="Resetuj hasło">

</form>

<br>

<a href="logowanie/logowanie2026.php">Logowanie</a>

</body>
</html>

<?php
mysqli_close($conn);
?>