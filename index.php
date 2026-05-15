<?php
session_start();

$zalogowany = isset($_SESSION["current_user"]);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>System danych biomedycznych</title>
    <link rel="stylesheet" href="styl.css">
</head>

<body>

<h1>System danych biomedycznych</h1>

<?php if ($zalogowany) { ?>

    <p>
        Jesteś zalogowana jako:
        <b><?php echo $_SESSION["current_username"]; ?></b>
    </p>

    <ul>
        <li><a href="parametry.php">Parametry biomedyczne</a></li>
        <li><a href="statystyka_parametru.php">Statystyka parametru</a></li>
        <li><a href="jednostki.php">Jednostki biomedyczne</a></li>
        <li><a href="pomiary.php">Moje pomiary</a></li>
        <li><a href="dodaj_pomiar.php">Dodaj pomiar</a></li>
        <li><a href="parametr_pomiary.php">Pomiary jednego parametru</a></li>
        <li><a href="dodaj_parametr.php">Dodaj parametr biomedyczny</a></li>
        <li><a href="historia_logowan.php">Historia logowań</a></li>
        <li><a href="zmiana_hasla.php">Zmień hasło</a></li>
        <li><a href="logowanie/logout2026.php">Wyloguj</a></li>
    </ul>

<?php } else { ?>

    <p>
        Nie jesteś zalogowana.
    </p>

    <ul>
        <li><a href="logowanie/logowanie2026.php">Logowanie</a></li>
        <li><a href="logowanie/rejestracja2026.php">Rejestracja</a></li>
        <li><a href="reset_hasla.php">Reset hasła</a></li>
    </ul>

<?php } ?>

</body>
</html>