<?php 
session_start();
if (isset($_SESSION['loggedin'])) {
    header("Location: index.php");
}


//If all fields are set, validate inputs, if not valid, send back prefilled form and errors, if valid, register user
if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password1"]) && isset($_POST["password2"])) {
    $error = "";
    $valid = true;
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) && $email != "") {
        $valid = false;
        $error .= "Zadali jste neplatný email. ";
    }
    if (strlen($password1) < 8) {
        $valid = false;
        $error .= "Heslo má mít alespoň 8 znaků. ";
    }
    if (strtolower($password1) === $password1 || strtoupper($password1) == $password1) {
        $valid = false;
        $error .= "Heslo má mít velká i malá písmena. ";
    }
    if (!preg_match("/\d/", $password1)) {
        $valid = false;
        $error .= "Heslo musí obsahovat číslo. ";
    }
    if ($password1 != $_POST["password2"]) {
        $valid = false;
        $error .= "Hesla se musí shodovat. ";
    }
    if (strlen($username) <= 0) {
        $valid = false;
        $error .= "Uživatelské jméno je moc krátké. ";
    }
    if (is_readable("users.json")) {
        $users = json_decode(file_get_contents("users.json"), true);
        if (array_key_exists($_POST["username"], $users)) {
            $valid = false;
            $error .= "Uživatel s takovým jménem už existuje. ";
        }
    }
    else {
        $valid = false;
        $error .= "Stala se chyba serveru. ";
    }


    if (!$valid) {
        header("Location: "."register.php?error=$error&username=$username&email=$email");
    }
    else {
        //goals - create user in users.json, create session, redirect to index.php
        $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);
        $user = array("email"=>$email, "password"=>$hashedPassword);
        $users = json_decode(file_get_contents("users.json"), true); //I know its readable, checked before
        $users[$username] = $user; //I checked user already doesnt exist, key is username value is assoc array
        file_put_contents("users.json", json_encode($users));
        //created user in users.json

        //session_start(); already done above
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        //created session

        header("Location: index.php");
        //redirected to index.php
        
    }
}
   
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrace</title>
    <link rel="stylesheet" href="./css/authForm.css">
    <link rel="stylesheet" href="./css/header.css">
    <script src="./js/register.js" defer></script>
    <link rel="shortcut icon" href="./images/cookbook.svg" type="image/x-icon">
</head>
<body>
    <?php include "header.php" ?>
    <main>
        <h1 id="heading">Registrace</h1>
        <form action="register.php" method="POST">
            <div class="fieldContainer">
                <label for="username">Uživatelské jméno: <span class="required">*</span></label>
                <input type="text" id="username" name="username" autocomplete="on" value="<?php if(isset($_GET['username'])) echo(htmlspecialchars($_GET['username']));?>">
                <div class="error" id="usernameError"></div>
            </div>
            <div class="fieldContainer">
                <label for="email">Email: </label>
                <input type="email" id="email" name="email" autocomplete="on" value="<?php if(isset($_GET['email'])) echo(htmlspecialchars($_GET['email']));?>">
                <div class="error" id="emailError"></div>
            </div>
            <div class="fieldContainer">
                <label for="password1">Heslo: <span class="required">*</span></label>
                <input type="password" id="password1" name="password1" value="<?php if(isset($_GET['password1'])) echo(htmlspecialchars($_GET['password1']));?>">
                <div class="error" id="password1Error"></div>
            </div>
            <div class="fieldContainer">
                <label for="password2">Heslo znovu: <span class="required">*</span></label>
                <input type="password" id="password2" name="password2" value="<?php if(isset($_GET['password2'])) echo(htmlspecialchars($_GET['password2']));?>">
                <div class="error" id="password2Error"></div>
            </div>
            <div class="fieldContainer">
                <button type="submit" id="submitButton">Odeslat</button>
            </div>
            <div id="authSwitch">Máte už účet? <a href="./login.php">Přihlašte se</a></div>
            <p id="error"><?php if(isset($_GET['error'])) echo(htmlspecialchars($_GET['error']));?></p>
        </form>
    </main>
</body>
</html>