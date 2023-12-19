<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    die();
}


if (isset($_POST['logout'])) {
    //unset all session variables
    $_SESSION = array();
    //destroy the session
    session_destroy();

    header("Location: index.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
    <?php
    include "header.php";
    ?>
    <main>
        <div id="container">
            <div id="username" class="message">Ahoj, <span id="highlight"><?php echo htmlspecialchars($_SESSION['username']); ?></span>, přeji vám hezký den! Máte náladu si něco uvařit?</div>
            <p class="message">Momentálně jsou trendy štrůdly, husté polévky a houbové omáčky. Máte na něco chuť? Podívejte se na <a href="./index.php">recepty našich uživatelů</a>.</p>
            <div id="email" class="message">Váš email: <?php echo htmlspecialchars($_SESSION['email']); ?></div>
            <form method="POST" action="profile.php">
            <button type="submit" name="logout" value="logout">Odhlásit se</button>
        </form>
        </div>
    </main>
</body>
</html>