<?php
session_start();
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>LOGOWANIE</title>
    <link rel="stylesheet" href="../styl.css">
</head>

<body>

<?php

$dbservername = "mysql.agh.edu.pl";
$dbusername = "roksanad";
$dbpassword = "inXmULFh3k3ByrMi";
$dbname = "roksanad";

$dbconn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

$email = mysqli_real_escape_string($dbconn, $_POST["email"]);
$password = mysqli_real_escape_string($dbconn, $_POST["password"]);

$ip = $_SERVER['REMOTE_ADDR'];

$sql = "SELECT * FROM users WHERE user_email='$email'";
$query = mysqli_query($dbconn, $sql);

$login_success = false;

if (mysqli_num_rows($query) > 0) {

    $record = mysqli_fetch_assoc($query);

    $hash = $record["user_passwordhash"];

    if (password_verify($password, $hash)) {

        $_SESSION["current_user"] = $record["user_id"];
        $_SESSION["current_username"] = $record["user_fullname"];

        $login_success = true;
    }
}

$success_value = $login_success ? 1 : 0;

$log_sql = "
INSERT INTO logowania(email, sukces, ip)
VALUES('$email', '$success_value', '$ip')
";

mysqli_query($dbconn, $log_sql);

if ($login_success) {

    echo "Użytkownik zalogowany!<br>";
    echo "Witaj: " . $_SESSION["current_username"];

    echo "<br><br>";
    echo "<a href='../index.php'>Przejdź do aplikacji</a>";

} else {

    echo "Błąd logowania!";
}

mysqli_close($dbconn);

?>

<br><br>
<a href="logout2026.php">Wyloguj</a>

</body>
</html>