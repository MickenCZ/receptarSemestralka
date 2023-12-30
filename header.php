<?php
/**
 * Job: Basic HTML for the header. 
 * Some a tags in a nav and header. The last anchor tag goes to user's profile
 * or login page, based on if user is logged in. The reason for line 15 is that
 * we need to start a session, but only if one already doesn't exist.
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start(); //if session hasnt been started, start it
}
?>
<header>
    <nav>
        <a href="./">Feed</a>
        <a href="./addRecipe.php">Přidat recept</a>
        <a href="
        <?php
            if (isset($_SESSION['loggedin'])) {
                    echo("./profile.php");
                }
            else {
                echo("./login.php");
            }
        ?>

        ">Profil</a>
    </nav>
</header>
