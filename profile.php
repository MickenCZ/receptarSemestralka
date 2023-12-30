<?php
/**
 * Job: Show user information to the user
 * It checks if the user is logged in and if not, redirects him. It greets the user, 
 * recommends him some food, shows username and email and shows a button to log out.
 * Logging out just submits a form to this file, which in turn destroys the session.
 */


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
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/profile.css">
    <meta name="author" content="Michael Cirkl">
    <meta name="description" content="Chutné recepty online">
    <meta name="keywords" content="recepty online">
</head>
<body>
    <?php
    include "header.php";
    ?>
    <main>
        <div id="container">
            <div id="username" class="message">Ahoj, <span id="highlight"><?php echo htmlspecialchars($_SESSION['username']); ?></span>, přeji vám hezký den! Máte náladu si něco uvařit?</div>
            <p class="message">Momentálně jsou trendy štrůdly, husté polévky a houbové omáčky. Máte na něco chuť? Podívejte se na <a href="./index.php">recepty našich uživatelů</a>.</p>
            <?php if ($_SESSION['email'] != "") {
                echo('<div id="email" class="message">Váš email: '.htmlspecialchars($_SESSION["email"]).'</div>');
            }?>
            <form method="POST" action="profile.php">
            <button type="submit" name="logout" value="logout" class="redButton">Odhlásit se</button>
        </form>
        </div>
    </main>
</body>
</html>