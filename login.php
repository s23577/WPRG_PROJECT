<?php
include("config.php");
$login = $_POST['login'];
$password = $_POST['password_login'];

$query_login = $db->prepare("SELECT login FROM user WHERE login = '" . $login . "'");
$query_login->execute();
if ($query_login->rowCount() > 0) {
    $query = "SELECT password FROM user WHERE login='" . $login . "';";
    $password_from_db = $db->query($query);
    $password_from_db_row = $password_from_db->fetch();
    echo $password_from_db_row['password'] . "\n";
    if ($password_from_db_row['password'] === $password) {
        setcookie("login", $_POST['login'], time() + (60 * 60 * 24 * 365));
        header('Location: zalogowano.php');
    } else {
        echo "Błędne hasło. Kliknij wróć, aby zalogować się ponownie"; ?>
        <div class="main_table"><a href="index.php">Wróć</a></div> <?php
    }
} else {
    echo "Użytkownik nie istnieje w bazie. Mozesz sie zarejestrowac lub wrócić"; ?>
    <a href="zarejestruj.php">Zarejestruj się</a>
    <a href="index.php">Wróć</a> <?php
}
