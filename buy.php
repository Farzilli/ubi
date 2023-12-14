<?php
session_start();
include_once("./inc/data.php");

if (isset($_POST["sendmail"])) {
    $cinema = $_SESSION["cinema"];
    $cinemaName = $cinemas[$cinema]["desc"];
    $film = $_SESSION["film"];
    $filmName = $films[$film]["desc"];
    $giorno = $_SESSION["giorno"];
    $orario =  $_SESSION["orario"];
    $posto = $_SESSION["posto"];
    $poltrona = $_SESSION["poltrona"];
    $prezzo = $_SESSION["prezzo"];

    if (isset($_SESSION["username"]) && isset($_SESSION["password"]) && isset($prezzo)) {
        $subject = "Prenotazione Faz";
        $txt = <<<HTML
        <html>
            <body style="background-color: #001c38; font-family: 'Nunito', sans-serif; display: flex; flex-direction: column; align-items: center; justify-content: center">
                <table style="width: 95%; margin: auto">
                    <tr>
                        <td style="text-align: center">
                            <img src="https://francescoarzilli3g.altervista.org/ubi/icon.png" alt="" style="width: 150px; height: 150px; margin-bottom: 10px; cursor: pointer" />
                            <p style="width: 200px; border: 2px solid #ffd900; background-color: #00244d; padding: 10px; margin-top: 10px; border-radius: 10px; color: white; text-decoration: none; margin: auto">Ecco a te il tuo ticket, mostra il qrcode per accedere alla sala. <br>
    HTML;

        $txt .= "cinema: $cinemaName <br>";
        $txt .= "film: $filmName <br>";

        switch ($giorno) {
            case "day1":
                $txt .= "giorno: " . date("d/m/y") . "<br>";
                break;
            case "day2":
                $txt .= "giorno: " . date("d") + 1 . date("/m/y") . "<br>";
                break;
            case "day3":
                $txt .= "giorno: " . date("d") + 2 . date("/m/y") . "<br>";
                break;
            default:
                break;
        }

        switch ($orario) {
            case "time1":
                $txt .= "orario: 16:00 <br>";
                break;
            case "time2":
                $txt .= "orario: 18:30 <br>";
                break;
            case "time3":
                $txt .= "orario: 21:00 <br>";
                break;
            default:
                break;
        }

        switch ($posto) {
            case "1":
                $txt .= "posto: davanti <br>";
                break;
            case "2":
                $txt .= "posto: centro <br>";
                break;
            case "3":
                $txt .= "posto: dietro <br>";
                break;
            default:
                break;
        }

        $txt .= "poltrona: $poltrona <br>";
        $txt .= "prezzo: $prezzo <br>";

        $txt .= "</p><img style='width: 250px; height: 250px; margin-top: 10px; cursor: pointer' src='https://api.qrserver.com/v1/create-qr-code/?size=700x700&data=";

        $txt .= "cinema=$cinemaName ";
        $txt .= "film=$filmName ";

        switch ($giorno) {
            case "day1":
                $txt .= "giorno=" . date("d/m/y") . " ";
                break;
            case "day2":
                $txt .= "giorno=" . date("d") + 1 . date("/m/y") . " ";
                break;
            case "day3":
                $txt .= "giorno=" . date("d") + 2 . date("/m/y") . " ";
                break;
            default:
                break;
        }

        switch ($orario) {
            case "time1":
                $txt .= "orario=16:00 ";
                break;
            case "time2":
                $txt .= "orario=18:30 ";
                break;
            case "time3":
                $txt .= "orario=21:00 ";
                break;
            default:
                break;
        }

        switch ($posto) {
            case "1":
                $txt .= "posto=davanti ";
                break;
            case "2":
                $txt .= "posto=centro ";
                break;
            case "3":
                $txt .= "posto=dietro ";
                break;
            default:
                break;
        }

        $txt .= "poltrona=$poltrona ";
        $txt .= "prezzo=$prezzo ";

        $txt .= "'/>";

        $txt .= <<<HTML
                        </td>
                    </tr>
                </table>
            </body>
        </html>
    HTML;

        $mailHead = implode("\r\n", [
            "MIME-Version: 1.0",
            "Content-type: text/html; charset=utf-8"
        ]);

        echo mail($_POST["mail"], $subject, $txt, $mailHead) ? "a breve riceverai una mail con il tuo ticket" : "errore nel invio della mail";

        echo <<<JS
            <script>
                setTimeout(() => {
                    window.location = "index.php";
                }, 5000);
            </script>
        JS;
    }

    unset($_SESSION["cinema"]);
    unset($_SESSION["film"]);
    unset($_SESSION["giorno"]);
    unset($_SESSION["orario"]);
    unset($_SESSION["posto"]);
    unset($_SESSION["poltrona"]);
    unset($_SESSION["prezzo"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>buy</title>
    <link rel="stylesheet" href="./style/style.css">
    <link rel="shortcut icon" href="./icon.png" type="image/x-icon">
</head>

<body>
    <div id="buy_bd">
        <div id="buy_main">
            <form action="" method="post" <?= isset($_SESSION["prezzo"]) ? "" : "style='display:none;'"  ?>>
                <input type="email" name="mail" id="mail" placeholder="inserisci una mail a cui mandare il ticket" required>
                <input type="submit" value="invia" name="sendmail">
            </form>
        </div>
    </div>
    <footer id="index_footer">
        <h1>sito a cura di francesco arzilli 5g</h1>
    </footer>
</body>

</html>