<?php
/**
 * Job: Display errors 
 * Displays a multitude of errors, mostly for cases when some essential 
 * JSON files are missing, in which case display a 500, or if a user
 * request is wrong or forbidden, so 400 series errors.
 */
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chyba</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/error.css">
</head>
<body>
<?php include "header.php";?>
    <main>
        <?php
            if (!isset($_GET["code"])) {
                header("Location: index.php");
            }
            else {
                $code = $_GET["code"];
                if ($code == "404") {
                    echo("<h1>Error: Zdroj nebyl nalezen</h1>");
                }
                else if ($code == "500") {
                    echo("<h1>Error: Na serveru se stala kritická chyba</h1>");
                }
                else if ($code == "403") {
                    echo("<h1>Error: Tato operace není povolena</h1>");
                }
            }
        ?>
    </main>
</body>
</html>