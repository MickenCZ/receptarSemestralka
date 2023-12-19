<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
    <?php
    include "header.php";
    ?>
    profil
</body>
</html>