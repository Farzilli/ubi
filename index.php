<?php
session_start();

include_once "./inc/data.php";


if (isset($_GET['cookieDecision'])) {
    $selection = $_GET['cookieDecision'];

    if ($selection == "on") setcookie("lastCinema", "unset", time() + (86400 * 30), "/"); //? 30 giorni
    else if ($selection == "off") setcookie("lastCinema", "off", time() + (86400 * 30), "/"); //? 30 giorni

    header("Location: index.php");
}

if (isset($_GET['logout'])) {
    unset($_SESSION["username"]);
    unset($_SESSION["password"]);
}

$novitaInfo = "";
foreach ($offerte as $e) {
    $novitaInfo .= <<<HTML
        <div class="item">
            <div style="background-image: url($e[img]);"></div>
            <h1>$e[desc]</h1>
        </div>
    HTML;
}

$filmlist = "";
foreach ($films as $e) {
    $filmlist .= <<<HTML
        <article class="film">
            <div class="filmimage" style="background-image: url($e[img]);"></div>
            <p>$e[desc]</p>
        </article>
    HTML;
}

$cinemalist = "";
foreach ($cinemas as $e) {
    $cinemalist .= <<<HTML
        <article class="cine">
        <iframe src="$e[map]" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <p>$e[desc]</p>
        </article>
    HTML;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="./style/style.css">
    <link rel="shortcut icon" href="./icon.png" type="image/x-icon">
</head>

<body>
    <nav id="index_nav">
        <div id="index_nav_logo">
            <p>ubi</p>
        </div>
        <div id="index_nav_btns">
            <a href="#cinema_position" class="index_nav_elem">cinema</a>
            <a href="#programmazione" class="index_nav_elem">film</a>
            <a href="#index_novita" class="index_nav_elem">offerte</a>
        </div>
        <div id="index_nav_user_btns">
            <a href="" id="index_mytickets_account">my tickets</a>
            <?= !isset($_SESSION["username"]) ? "<a href='login.php' id='index_login_account'>login</a>" : "<a href='?logout' id='index_login_account'>$_SESSION[username]</a>"; ?>
        </div>
    </nav>

    <div id="index_cookie_banner" <?= isset($_COOKIE["lastCinema"]) ? "style='display:none;'" : "" ?>>
        <div id="banner">
            <p>Cliccando su “Accetta tutti i cookie”, l'utente accetta di memorizzare i cookie sul dispositivo per migliorare la navigazione del sito, analizzare l'utilizzo del sito e assistere nelle nostre attività di marketing.</p>
            <a href="?cookieDecision=off">rifiuta tutti</a>
            <a href="?cookieDecision=on">accetta tutti i cookie</a>
        </div>
    </div>

    <section id="index_optionbar">
        <form action="ticket.php" method="post">
            <select name="cinema" id="cinema" place>
                <option value="" disabled hidden <?= !isset($_COOKIE["lastCinema"]) || $_COOKIE["lastCinema"] === "unset" || $_COOKIE["lastCinema"] === "off" ? "selected" : "" ?>>cinema</option>
                <option value="fe" <?= $_COOKIE["lastCinema"] === "fe"  ? "selected" : "" ?>>ferrara</option>
                <option value="bo" <?= $_COOKIE["lastCinema"] === "bo"  ? "selected" : "" ?>>bologna</option>
                <option value="ct" <?= $_COOKIE["lastCinema"] === "ct"  ? "selected" : "" ?>>catanzaro</option>
            </select>

            <select name="film" id="film" place <?= !isset($_COOKIE["lastCinema"]) || $_COOKIE["lastCinema"] === "off" || $_COOKIE["lastCinema"] === "unset" ? "disabled" : "" ?>>
                <option value="" disabled selected hidden>film</option>
                <option value="rf1">ritorno al futuro 1</option>
                <option value="rf2">ritorno al futuro 2</option>
                <option value="rf3">ritorno al futuro 3</option>
            </select>

            <select name="giorno" id="giorno" place disabled>
                <option value="" disabled selected hidden>giorno</option>
                <option value="day1"><?= date("d/m/y") ?></option>
                <option value="day2"><?= date("d") + 1 . date("/m/y") ?></option>
                <option value="day3"><?= date("d") + 2 . date("/m/y") ?></option>
            </select>

            <select name="orario" id="orario" place disabled>
                <option value="" disabled selected hidden>orario</option>
                <option value="time1">16:00</option>
                <option value="time2">18:30</option>
                <option value="time3">21:00</option>
            </select>
        </form>
    </section>

    <section id="index_novita">
        <div id="slider">
            <div id="list"><?= $novitaInfo ?></div>
        </div>
    </section>

    <section id="programmazione">
        <h1 id="title">programmazione</h1>
        <div id="films"><?= $filmlist ?></div>
    </section>

    <section id="cinema_position">
        <h1 id="title">le nostre sedi</h1>
        <div id="cinemas"><?= $cinemalist ?></div>
    </section>

    <footer id="index_footer">
        <h1>sito a cura di francesco arzilli 5g</h1>
    </footer>
</body>

<script src="./index_script.js"></script>

</html>