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

    <div class="dashboard-container">
        <div class="menu-card">
            <h2>Ustawienia konta</h2>
            <ul class="menu-list">
                <li><a href="historia_logowan.php" class="btn-history">Historia logowań</a></li>
                <li><a href="zmiana_hasla.php" class="btn-password">Zmień hasło</a></li>
                <li><a href="logowanie/logout2026.php" class="btn-logout">Wyloguj</a></li>
            </ul>
        </div>

        <div class="menu-card">
            <h2>Pomiary i dane biomedyczne</h2>
            <ul class="menu-list">
                <li><a href="parametry.php">Parametry biomedyczne</a></li>
                <li><a href="statystyka_parametru.php">Statystyka parametru</a></li>
                <li><a href="jednostki.php">Jednostki biomedyczne</a></li>
                <li><a href="pomiary.php">Moje pomiary</a></li>
                <li><a href="dodaj_pomiar.php">Dodaj pomiar</a></li>
                <li><a href="parametr_pomiary.php">Pomiary jednego parametru</a></li>
                <li><a href="dodaj_parametr.php">Dodaj parametr biomedyczny</a></li>
            </ul>
        </div>
    </div>

<?php } else { ?>

    <p>
        Nie jesteś zalogowana.
    </p>

    <div class="dashboard-container single-card">
        <div class="menu-card">
            <h2>Dostęp do systemu</h2>
            <ul class="menu-list">
                <li><a href="logowanie/logowanie2026.php" class="btn-login">Logowanie</a></li>
                <li><a href="logowanie/rejestracja2026.php" class="btn-register">Rejestracja</a></li>
                <li><a href="reset_hasla.php" class="btn-reset">Reset hasła</a></li>
            </ul>
        </div>
    </div>

<?php } ?>

</body>
</html>