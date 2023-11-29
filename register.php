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
                <input type="text" id="username" name="username">
                <div class="error" id="usernameError"></div>
            </div>
            <div class="fieldContainer">
                <label for="email">Email: </label>
                <input type="email" id="email" name="email">
                <div class="error" id="emailError"></div>
            </div>
            <div class="fieldContainer">
                <label for="password1">Heslo: <span class="required">*</span></label>
                <input type="password" id="password1" name="password1">
                <div class="error" id="password1Error"></div>
            </div>
            <div class="fieldContainer">
                <label for="password2">Heslo znovu: <span class="required">*</span></label>
                <input type="password" id="password2" name="password2">
                <div class="error" id="password2Error"></div>
            </div>
            <div class="fieldContainer">
                <button type="submit" id="submitButton">Odeslat</button>
            </div>
        </form>
    </main>
</body>
</html>