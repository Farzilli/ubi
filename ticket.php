<?php
session_start();
include_once("./inc/data.php");

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET['location'])) {
        header("Location: index.php");
    }
}

if (isset($_POST["cinema"])) $_SESSION["cinema"] = $_POST["cinema"];
if (isset($_POST["film"])) $_SESSION["film"] = $_POST["film"];
if (isset($_POST["giorno"])) $_SESSION["giorno"] = $_POST["giorno"];
if (isset($_POST["orario"])) $_SESSION["orario"] = $_POST["orario"];
if (isset($_POST["posto"])) $_SESSION["posto"] = $_POST["posto"];
if (isset($_POST["poltrona"])) $_SESSION["poltrona"] = $_POST["poltrona"];

$cinema = $_SESSION["cinema"];
$cinemaName = $cinemas[$cinema]["desc"];
$film = $_SESSION["film"];
$filmName = $films[$film]["desc"];
$giorno = $_SESSION["giorno"];
$orario =  $_SESSION["orario"];
$posto = $_SESSION["posto"];
$poltrona = $_SESSION["poltrona"];
$prezzo = $_SESSION["prezzo"];

if (isset($_POST["select"])) {
    $prezzo = 5;

    switch ($posto) {
        case "1":
            $prezzo += 0;
            break;
        case "2":
            $prezzo += 1;
            break;
        case "3":
            $prezzo += 2;
            break;
        default:
            break;
    }

    switch ($poltrona) {
        case "normale":
            $prezzo += 0;
            break;
        case "vip":
            $prezzo += 5;
            break;
        default:
            break;
    }

    $prezzo .= "€";
}
if (isset($_COOKIE["lastCinema"]) && $_COOKIE["lastCinema"] !== "off") {
    setcookie("lastCinema", $cinema, time() + (86400 * 30), "/"); //? 30 giorni
}

if (isset($_POST["login"])) {
    if (isset($_POST["prezzo"])) $_SESSION["prezzo"] = $_POST["prezzo"];
    header("Location: login.php");
    exit();
}
if (isset($_POST["buy"])) {
    if (isset($_POST["prezzo"])) $_SESSION["prezzo"] = $_POST["prezzo"];
    header("Location: buy.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ticket</title>
    <link rel="stylesheet" href="./style/style.css">
    <link rel="shortcut icon" href="./icon.png" type="image/x-icon">
</head>

<body>
    <div id="ticket_bd">
        <a id="ticket_homebtn" href="?location"><i></i></a>
        <section id="ticket_main">

            <img src="<?= $films[$film]["img"] ?>" alt="">

            <div id="ticket_options">

                <form action="" method="post" id="ticket_form">
                    <label><?= $filmName ?></label>
                    <label><?= $cinemaName ?></label>

                    <select name="giorno" id="giorno" place required>
                        <option value="day1" <?= $giorno == "day1" ? "selected" : "" ?>><?= date("d/m/y") ?></option>
                        <option value="day2" <?= $giorno == "day2" ? "selected" : "" ?>><?= date("d") + 1 . date("/m/y") ?></option>
                        <option value="day3" <?= $giorno == "day3" ? "selected" : "" ?>><?= date("d") + 2 . date("/m/y") ?></option>
                    </select>

                    <select name="orario" id="orario" place required>
                        <option value="time1" <?= $orario == "time1" ? "selected" : "" ?>>16:00</option>
                        <option value="time2" <?= $orario == "time2" ? "selected" : "" ?>>18:30</option>
                        <option value="time3" <?= $orario == "time3" ? "selected" : "" ?>>21:00</option>
                    </select>

                    <select name="posto" id="posto" place required>
                        <option value="" disabled selected hidden>posto in sala</option>
                        <option value="1" <?= $posto == "1" ? "selected" : "" ?>>davanti +0€</option>
                        <option value="2" <?= $posto == "2" ? "selected" : "" ?>>centro +1€</option>
                        <option value="3" <?= $posto == "3" ? "selected" : "" ?>>infondo +2€</option>
                    </select>

                    <select name="poltrona" id="poltrona" place required>
                        <option value="" disabled selected hidden>tipo di poltrona</option>
                        <option value="normale" <?= $poltrona == "normale" ? "selected" : "" ?>>normale +0€</option>
                        <option value="vip" <?= $poltrona == "vip" ? "selected" : "" ?>>vip +5€</option>
                    </select>

                    <input type="submit" value="seleziona" name="select">
                </form>

                <form action="" method="post" id="buy" <?= (isset($prezzo) ? "" : "style='display:none;'")  ?>>
                    <input type="text" name="prezzo" id="prezzo" value="<?= $prezzo ?>" readonly>
                    <?=
                    (isset($_SESSION["username"]) && isset($_SESSION["password"])) ?
                        '<input type="submit" name="buy" value="accuista il biglietto">' :
                        '<input type="submit" name="login" value="accedi">';
                    ?>
                </form>
            </div>
        </section>
    </div>
    <footer id="index_footer">
        <h1>sito a cura di francesco arzilli 5g</h1>
    </footer>
</body>

</html>