<?php
include("config.php");
$wielkosc = $_GET["wielkosc"];
$sql_ilosc = "SELECT COUNT(DISTINCT(jednostka_wejsciowa)) FROM przelicznik where wielkosc=\"" . $wielkosc . "\";";
$sql_tablica_jednostek = "SELECT DISTINCT(jednostka_wejsciowa) FROM przelicznik where wielkosc=\"" . $wielkosc . "\";";
$ilosc = $db->query($sql_ilosc);
$tablica_jednostek = $db->query($sql_tablica_jednostek);
$ilosc_fetch = $ilosc->fetch();
for ($i = 0; $i < $ilosc_fetch[0]; $i++) {
    $tablica_jednostek_fetch = $tablica_jednostek->fetch();
    $tablica_jednostek_koncowa[$i] = $tablica_jednostek_fetch[0];
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Formularz wzorcowy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<br><br>
<div class="wyloguj"><a href="wyloguj.php">Wyloguj</a><br></div>
<div class="wyloguj"><a href="zalogowano.php">Wróć do wyboru wielkości fizycznej</a><br></div>
<div class="welcome_text">
    <h3>Przeliczasz jednostki dla wielkości fizycznej: <?php echo $wielkosc; ?></h3>
</div>
<div class="main_table">
    <form method="get" action="przelicznik.php">
        <input type="hidden" name="wielkosc" id="wielkosc" value="<?php echo $wielkosc; ?>">
        <label for="ilosc_wejsciowa">Podaj liczbę:</label><br>
        <input type="number" step="0.00001" id="ilosc_wejsciowa" name="ilosc_wejsciowa"><br>
        <label for="jednostka_wejsciowa">Wybierz jednostkę wejściową:</label><br>
        <select id="jednostka_wejsciowa" name="jednostka_wejsciowa">
            <?php
            for ($i = 0;
                 $i < $ilosc_fetch[0];
                 $i++) {
                ?>
                <option value="<?php
                echo $tablica_jednostek_koncowa[$i];
                ?>"><?php
                    echo $tablica_jednostek_koncowa[$i]; ?> </option> <?php
            } ?>
        </select>
        <br>
        <label for="jednostka_wyjsciowa">Wybierz jednostkę wyjściową:</label><br>
        <select id="jednostka_wyjsciowa" name="jednostka_wyjsciowa"><?php
            for ($i = 0;
                 $i < $ilosc_fetch[0];
                 $i++) {
                ?>
                <option value="<?php
                echo $tablica_jednostek_koncowa[$i];
                ?>"><?php echo $tablica_jednostek_koncowa[$i]; ?> </option> <?php
            } ?>
        </select>
        <br>
        <input type="submit" value="Przelicz">
    </form>
</div>
<?php
if (isset($_GET["ilosc_wejsciowa"], $_GET["jednostka_wejsciowa"], $_GET["jednostka_wyjsciowa"]) && !empty($_GET["ilosc_wejsciowa"]) && !empty($_GET["jednostka_wejsciowa"]) && !empty($_GET["jednostka_wyjsciowa"])) {
    ?>
    <div class="wynik">
        <p>Wynik:</p>
        <?php
        $sql_wspolczynnik = "SELECT wspolczynnik FROM przelicznik WHERE jednostka_wejsciowa=\"" . $_GET["jednostka_wejsciowa"] . "\" AND jednostka_wyjsciowa=\"" . $_GET["jednostka_wyjsciowa"] . "\";";
        $wspolczynnik = $db->query($sql_wspolczynnik);
        $wspolczynnik_fetch = $wspolczynnik->fetch();
        if ($_GET["wielkosc"] != "TEMPERATURA") {
            $wynikPretty = $_GET["ilosc_wejsciowa"] * $wspolczynnik_fetch[0];
            printf("%f %.s = ", $_GET["ilosc_wejsciowa"], $_GET["jednostka_wejsciowa"]);
            printf("%.5f %.s", $wynikPretty, $_GET["jednostka_wyjsciowa"]);
        } elseif ($_GET["wielkosc"] == "TEMPERATURA" && $_GET["jednostka_wejsciowa"] == "K" && $_GET["jednostka_wyjsciowa"] == "st. C") {
            echo PHP_EOL . $_GET["ilosc_wejsciowa"] . " " . $_GET["jednostka_wejsciowa"] . " = " . $_GET["ilosc_wejsciowa"] + $wspolczynnik_fetch[0] . " " . $_GET["jednostka_wyjsciowa"];
        } elseif ($_GET["wielkosc"] == "TEMPERATURA" && $_GET["jednostka_wejsciowa"] == "K" && $_GET["jednostka_wyjsciowa"] == "K") {
            echo PHP_EOL . $_GET["ilosc_wejsciowa"] . " " . $_GET["jednostka_wejsciowa"] . " = " . $_GET["ilosc_wejsciowa"] * $wspolczynnik_fetch[0] . " " . $_GET["jednostka_wyjsciowa"];
        } elseif ($_GET["wielkosc"] == "TEMPERATURA" && $_GET["jednostka_wejsciowa"] == "K" && $_GET["jednostka_wyjsciowa"] == "st. F") {
            $wynik = ($_GET["ilosc_wejsciowa"] + $wspolczynnik_fetch[0]) * 1.8 + 32;
            echo PHP_EOL . $_GET["ilosc_wejsciowa"] . " " . $_GET["jednostka_wejsciowa"] . " = " . $wynik . " " . $_GET["jednostka_wyjsciowa"];
        } elseif ($_GET["wielkosc"] == "TEMPERATURA" && $_GET["jednostka_wejsciowa"] == "st. F" && $_GET["jednostka_wyjsciowa"] == "st. F") {
            echo PHP_EOL . $_GET["ilosc_wejsciowa"] . " " . $_GET["jednostka_wejsciowa"] . " = " . $_GET["ilosc_wejsciowa"] * $wspolczynnik_fetch[0] . " " . $_GET["jednostka_wyjsciowa"];
        } elseif ($_GET["wielkosc"] == "TEMPERATURA" && $_GET["jednostka_wejsciowa"] == "st. C" && $_GET["jednostka_wyjsciowa"] == "st. F") {
            $wynik = ($_GET["ilosc_wejsciowa"] * $wspolczynnik_fetch[0]) + 32;
            echo PHP_EOL . $_GET["ilosc_wejsciowa"] . " " . $_GET["jednostka_wejsciowa"] . " = " . $wynik . " " . $_GET["jednostka_wyjsciowa"];
        } elseif ($_GET["wielkosc"] == "TEMPERATURA" && $_GET["jednostka_wejsciowa"] == "st. C" && $_GET["jednostka_wyjsciowa"] == "st. C") {
            echo PHP_EOL . $_GET["ilosc_wejsciowa"] . " " . $_GET["jednostka_wejsciowa"] . " = " . $_GET["ilosc_wejsciowa"] * $wspolczynnik_fetch[0] . " " . $_GET["jednostka_wyjsciowa"];
        } elseif ($_GET["wielkosc"] == "TEMPERATURA" && $_GET["jednostka_wejsciowa"] == "st. F" && $_GET["jednostka_wyjsciowa"] == "st. C") {
            $wynik = ($_GET["ilosc_wejsciowa"] - 32) * $wspolczynnik_fetch[0];
            echo PHP_EOL . $_GET["ilosc_wejsciowa"] . " " . $_GET["jednostka_wejsciowa"] . " = " . $wynik . " " . $_GET["jednostka_wyjsciowa"];
        } elseif ($_GET["wielkosc"] == "TEMPERATURA" && $_GET["jednostka_wejsciowa"] == "st. C" && $_GET["jednostka_wyjsciowa"] == "K") {
            echo PHP_EOL . $_GET["ilosc_wejsciowa"] . " " . $_GET["jednostka_wejsciowa"] . " = " . $_GET["ilosc_wejsciowa"] + $wspolczynnik_fetch[0] . " " . $_GET["jednostka_wyjsciowa"];
        } elseif ($_GET["wielkosc"] == "TEMPERATURA" && $_GET["jednostka_wejsciowa"] == "st. F" && $_GET["jednostka_wyjsciowa"] == "K") {
            $wynik = ($_GET["ilosc_wejsciowa"] + 459.67) * $wspolczynnik_fetch[0];
            echo PHP_EOL . $_GET["ilosc_wejsciowa"] . " " . $_GET["jednostka_wejsciowa"] . " = " . $wynik . " " . $_GET["jednostka_wyjsciowa"];
        }
        ?>
    </div> <?php
} else {
    ?>
    <div class="notes">Pamiętaj: Wypełnij wszystkie powyższe pola.</div> <?php
}
?>
</body>
</html>