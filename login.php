<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    header("Location: index.php");
    die();
}

if (isset($_POST["username"]) && isset($_POST["password1"])) {
    $valid = true;
    $error = "";
    $username = $_POST["username"];
    $password = $_POST["password1"];
    if (is_readable("users.json")) {
        $users = json_decode(file_get_contents("users.json"), true);
        if (!array_key_exists($username, $users)) {
            $valid = false;
            $error .= "Uživatel s takovým jménem neexistuje. ";
        }
        else {
            if (!password_verify($password, $users[$username]["password"])) {
                $valid = false;
                $error .= "Vaše heslo je špatně. ";
            }
        }
    }
    else {
        $valid = false;
        $error .= "Stala se chyba serveru";
    }

    if (!$valid) {
        header("Location: "."login.php?error=$error&username=$username");
        die();
    }
    else {
        //main login logic
        //session_start(); already done above
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $users[$username]["email"];
        //created session

        header("Location: index.php");
        die();
        //redirected to index.php
    }
}
?>


<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení</title>
    <link rel="stylesheet" href="./css/authForm.css">
    <link rel="stylesheet" href="./css/header.css">
    <script src="./js/login.js" defer></script>
    <link rel="shortcut icon" href="./images/cookbook.svg" type="image/x-icon">
</head>
<body>
    <?php include "header.php" ?>
    <main>
        <h1 id="heading">Přihlášení</h1>
        <form action="login.php" method="POST">
            <div class="fieldContainer">
                <label for="username">Uživatelské jméno: <span class="required">*</span></label>
                <input type="text" id="username" name="username" value="<?php if(isset($_GET['username'])) echo(htmlspecialchars($_GET['username']));?>">
                <div class="error" id="usernameError"></div>
            </div>
            <div class="fieldContainer">
                <label for="password1">Heslo: <span class="required">*</span></label>
                <input type="password" id="password1" name="password1" value="<?php if(isset($_GET['password1'])) echo(htmlspecialchars($_GET['password1']));?>">
                <div class="error" id="password1Error"></div>
            </div>
            <div class="fieldContainer">
                <button type="submit" id="submitButton">Odeslat</button>
            </div>
            <div id="authSwitch">Nemáte ještě účet? <a href="./register.php">Zaregistrujte se</a></div>
            <div id="error"><?php if(isset($_GET['error'])) echo(htmlspecialchars($_GET['error']));?></div>
        </form>
    </main>
</body>
</html>