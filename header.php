
<header>
    <nav>
        <a href="./">Feed</a>
        <a href="./addRecipe.php">Přidat recept</a>
        <a href="
        <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
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
