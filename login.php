<?php
session_start();

$accounts = [
    "user" => "abc",
    "fre" => "123",
];

function checkUser($user, $password)
{
    global $accounts;
    foreach ($accounts as $u => $p) if ($user === $u && $password === $p) return true;
    return false;
}

$loginErr = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["accedi"])) {
        $user = $_POST["nome"];
        $password = $_POST["password"];
        if (checkUser($user, $password)) {
            $_SESSION["username"] = $user;
            $_SESSION["password"] = $password;
            header(isset($_SESSION["prezzo"]) ? "Location: ticket.php" : "Location: index.php");
        } else {
            $loginErr = "username or password incorrect!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="./style/style.css">
    <link rel="shortcut icon" href="./icon.png" type="image/x-icon">
</head>

<body>
    <div id="login_bd">
        <div id="login_main">
            <form action="" method="post">
                <h1>login</h1>
                <?= $loginErr ?>
                <input type="text" placeholder="nome" id="nome" name="nome">
                <input type="password" placeholder="password" id="password" name="password">
                <input type="submit" value="accedi" name="accedi">
            </form>
        </div>
    </div>
    <footer id="index_footer">
        <h1>sito a cura di francesco arzilli 5g</h1>
    </footer>
</body>

</html>