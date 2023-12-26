<?php
/*session_start();
if (isset($_SESSION['loggedin'])) {
echo("Jste přihlášen");
}
else {
    echo("nejstep řihlášen");
}*/


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Váš Receptář</title>
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <?php 
    include "header.php";
    ?>
    <main>
        <form id="controls" method="GET" action="index.php">
            <label for="sorting">Řadit: </label>
            <select name="sorting" id="sorting">
                <option value="alphabetic">Abecedně</option>
                <option value="reverseAlphabetic">Obráceně abecedně</option>
            </select>
            <span id="filters">Filtry:</span>
            <input type="checkbox" name="breakfast" value="breakfast" id="breakfast">
            <label for="breakfast">Snídaně</label>
            <input type="checkbox" name="lunch" value="lunch" id="lunch">
            <label for="lunch">Oběd</label>
            <input type="checkbox" name="dinner" value="dinner" id="dinner">
            <label for="dinner">Večeře</label>
            <input type="checkbox" name="vegan" value="vegan" id="vegan">
            <label for="vegan">Veganské</label>
            <input type="checkbox" name="glutenFree" value="glutenFree" id="glutenFree">
            <label for="glutenFree">Bez lepku</label>
            <button type="submit" id="submitButton">Aplikovat</button>
        </form>
        <section id="recipes">
            <a class="card" href="#">
                <h3 class="title">Pizza s olovnatými hovna</h3>
                <img src="./images/c837e1c732f0d5d22258" alt="image" width="230rem" class="image">
                <div class="tags">Tagy: <em>Vega, vegentairna</em></div>
                <div class="ingredients">Ingredience: Rajčata, sůl, pepř</div>
                <div class="description">asdasdasdasdsads ssssssssssssssssssssssssss asdaasasasasasasasasasaaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaaaaaaa aaaaaaaaa aaaaaaaaaaaaa aaaaaaaaaa aaaaa aaaaaasas...</div>
            </a>
            <a class="card" href="#">
                <h3 class="title">Pizza s olovnatými hovna</h3>
                <img src="./images/c837e1c732f0d5d22258" alt="image" width="230rem" class="image">
                <div class="tags">Tagy: <em>Vega, vegentairna</em></div>
                <div class="ingredients">Ingredience: Rajčata, sůl, pepř</div>
                <div class="description">asdasdasdasdsads ssssssssssssssssssssssssss asdaasasasasasasasasasaaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaaaaaaa aaaaaaaaa aaaaaaaaaaaaa aaaaaaaaaa aaaaa aaaaaasas...</div>
            </a>
            <a class="card" href="#">
                <h3 class="title">Pizza s olovnatými hovna</h3>
                <img src="./images/c837e1c732f0d5d22258" alt="image" width="230rem" class="image">
                <div class="tags">Tagy: <em>Vega, vegentairna</em></div>
                <div class="ingredients">Ingredience: Rajčata, sůl, pepř</div>
                <div class="description">asdasdasdasdsads ssssssssssssssssssssssssss asdaasasasasasasasasasaaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaaaaaaa aaaaaaaaa aaaaaaaaaaaaa aaaaaaaaaa aaaaa aaaaaasas...</div>
            </a>
            <a class="card" href="#">
                <h3 class="title">Pizza s olovnatými hovna</h3>
                <img src="./images/c837e1c732f0d5d22258" alt="image" width="230rem" class="image">
                <div class="tags">Tagy: <em>Vega, vegentairna</em></div>
                <div class="ingredients">Ingredience: Rajčata, sůl, pepř</div>
                <div class="description">asdasdasdasdsads ssssssssssssssssssssssssss asdaasasasasasasasasasaaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaaaaaaa aaaaaaaaa aaaaaaaaaaaaa aaaaaaaaaa aaaaa aaaaaasas...</div>
            </a>
            
            
            
        </section>
    </main>
</body>
</html>