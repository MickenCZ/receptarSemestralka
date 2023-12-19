<?php
session_start();
if (isset($_SESSION['loggedin'])) {
echo("Jste přihlášen");
}
else {
    echo("nejstep řihlášen");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Váš Receptář</title>
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
    <?php 
    include "header.php";
    ?>
</body>
</html>