<?php

include "../config.php";

$dbconn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);
if (!$dbconn) {
    die("Błąd połączenia z bazą danych");
}

function holyfunc($dejta) {
    $dejta = trim($dejta);
    $dejta = stripslashes($dejta);
    $dejta = htmlspecialchars($dejta);
    return $dejta;
}

$komunikat = "";
$link = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($dbconn, holyfunc($_POST["name"]));
    $email = mysqli_real_escape_string($dbconn, holyfunc($_POST["email"]));
    $password = mysqli_real_escape_string($dbconn, holyfunc($_POST["password"]));

    $passwordhash = password_hash($password, PASSWORD_DEFAULT);

    $check_sql = "SELECT * FROM users WHERE user_email='$email'";
    $check_query = mysqli_query($dbconn, $check_sql);

    if (mysqli_num_rows($check_query) > 0) {
        $komunikat = "Użytkownik o takim emailu już istnieje!";
        $link = "<a href='rejestracja2026.php'>Spróbuj ponownie</a>";
    } else {
        $sql = "INSERT INTO users (user_fullname, user_email, user_passwordhash) VALUES ('$name', '$email', '$passwordhash')";
        if (mysqli_query($dbconn, $sql)) {
            $komunikat = "Użytkownik zarejestrowany!";
            $link = "<a href='logowanie2026.php'>Kliknij tutaj, aby się zalogować</a>";
        } else {
            $komunikat = "Błąd rejestracji!";
            $link = "<a href='rejestracja2026.php'>Powrót</a>";
        }
    }
}
mysqli_close($dbconn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Status rejestracji</title>
    <link rel="stylesheet" href="../styl.css">
</head>
<body>
    <h1>Rejestracja</h1>
    <p><?php echo $komunikat; ?></p>
    <?php echo $link; ?>
    <br><br>
    <a href="../index.php">Strona główna</a>
</body>
</html>