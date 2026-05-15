<?php
session_start();

session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Wylogowanie</title>
    <link rel="stylesheet" href="../styl.css">
</head>
<body>

<h2>Wylogowano!</h2>

<a href="logowanie2026.php">Zaloguj ponownie</a>

</body>
</html>