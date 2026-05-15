<?php

$user_name = "";
$user_email = "";
$user_password = "";

function holyfunc($dejta) {

    $dejta = trim($dejta);
    $dejta = stripslashes($dejta);
    $dejta = htmlspecialchars($dejta);

    return $dejta;
}

$dbservername = "mysql.agh.edu.pl";
$dbusername = "roksanad";
$dbpassword = "inXmULFh3k3ByrMi";
$dbname = "roksanad";

$dbconn = mysqli_connect(
    $dbservername,
    $dbusername,
    $dbpassword,
    $dbname
);

if (!$dbconn) {
    die("Błąd połączenia z bazą danych");
}

$user_name = holyfunc($_POST["name"]);
$user_email = holyfunc($_POST["email"]);
$user_password = holyfunc($_POST["password"]);

$name = mysqli_real_escape_string($dbconn, $user_name);
$email = mysqli_real_escape_string($dbconn, $user_email);
$password = mysqli_real_escape_string($dbconn, $user_password);

$passwordhash = password_hash($password, PASSWORD_DEFAULT);

$check_sql = "SELECT * FROM users WHERE user_email='$email'";
$check_query = mysqli_query($dbconn, $check_sql);

if (mysqli_num_rows($check_query) > 0) {

    echo "Użytkownik o takim emailu już istnieje!";

} else {

    $sql = "
    INSERT INTO users
    (user_fullname, user_email, user_passwordhash)
    VALUES
    ('$name', '$email', '$passwordhash')
    ";

    if (mysqli_query($dbconn, $sql)) {

        echo "Użytkownik zarejestrowany!<br><br>";
        echo "<a href='logowanie2026.php'>Zaloguj się</a>";

    } else {

        echo "Błąd rejestracji!";
    }
}

mysqli_close($dbconn);

?>