<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přidat recept</title>
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
    <?php 
    include "header.php";
    ?>
</body>
</html>