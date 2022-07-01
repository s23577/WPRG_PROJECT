<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="style.css">
    <title>Rejestracja</title>
</head>

<body>
<br><br>
<div class="wyloguj"><a href="index.php">Wróć</a></div>
<div class="main_table">
    <form name="form" method="post" action="zarejestruj.php">
        login:<input type="text" name="login"><br>
        imie:<input type="text" name="name"><br>
        haslo:<input type="password" name="password"><br>
        plec:<input type="text" name="gender"><br>
        wiek:<input type="number" min="1" max="150" name="age"><br>
        <input type="submit" name="forms" value="Zarejestruj">
    </form>
</div>
</body>
</html>

<?php
include("config.php");

$login_from_form = $_REQUEST['login'];
$name = $_REQUEST['name'];
$password = $_REQUEST['password'];
$gender = $_REQUEST['gender'];
$age = $_REQUEST['age'];

$query_name = $db->prepare("SELECT login FROM user WHERE login='" . $login_from_form . "'");
$query_name->execute();
if ($query_name->rowCount() > 0) {
    echo "Użytkownik o imieniu " . $login_from_form . " już istnieje. Spróbuj ponownie";
} else {
    $sql = "INSERT INTO user (login, name, password, gender, age) VALUES ('$login_from_form', '$name','$password','$gender','$age')";
    $user_amount_query = "SELECT COUNT(login) FROM user";
    $user_amount_row = $db->query($user_amount_query);
    $user_amount = $user_amount_row->fetch();
    ?>
    <div class="main_table"> <?php echo PHP_EOL . "----Do tej pory zarejestrowalo sie " . $user_amount[0] . " uzytkownikow.----"; ?></div>
    <?php

    if ($db->query($sql)) {
        echo "<div class='main_table'><h3>Dane pomyślnie zapisano w bazie danych :)</h3></div>"; ?>
        <div class="main_table>" <?php
        echo nl2br("ZAPISANE DO BAZY DANE:\n" . "login= $login_from_form\n imie= $name\nhaslo= $password\n plec= $gender\n wiek= " . $age);
        echo "<br>Jesteś " . $user_amount[0] + 1 . " użytkownikiem! Gratulacje!\n" . PHP_EOL . "<br>";
        echo "\nAby się zalogować naciśnij przycisk \"Wróć\" znajdujący się w prawym górnym rogu ekranu."; ?>
        </div><?php
    } else {
        echo "ERROR: Hush! UWAGA $sql. " . $db->errorInfo();
    }
}

