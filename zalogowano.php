<html>
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>Strona domowa</title>
</head>
<?php
session_start();
$_SESSION['login'] = $_REQUEST['login'];
echo "Jesteś poprawnie zalogowany jako: {$_COOKIE['login']}"; ?>
<br> <?php
$id = session_id();
echo "Twój identyfikator sesji to: {$id}"; ?>
<br>
<div class="wyloguj"><a href="wyloguj.php">Wyloguj</a></div>
<div class="welcome_text">
    <h1>
        Witaj w świecie kalkulatora jednostek fizycznych!<br>
        Wybierz wielkość, którą chcesz przekonwertować ;)
    </h1>
</div>
<div class="main_table">
    <table>
        <tr>
            <th><h2>Wielkość fizyczna</h2></th>
        </tr><?php
        include("config.php");

        $sql = "SELECT wielkosc FROM wielkosc_fizyczna;";
        $wielkosc_sql = $db->query($sql);

        for ($i = 0; $i < 10; $i++) {
            $wielkosc_array = $wielkosc_sql->fetch();
            ?>
            <tr>
            <td><h2>
                    <a href="przelicznik.php?wielkosc=<?php echo $wielkosc_array["wielkosc"]; ?> "> <?php echo $wielkosc_array["wielkosc"] ?></a>
                </h2></td></tr><?php
        }
        ?></table>
</div>

</html>
