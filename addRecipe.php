<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    die();
}

//PŘEDVYPLNĚNÍ CHECKBOXŮ
//blur ingredience vypsání pod to
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přidat recept</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/addRecipe.css">
    <script src="js/addRecipe.js" defer></script>
</head>
<body>
    <?php 
    include "header.php";
    ?>
    <main>
        <form method="POST" action="addRecipe.php" enctype="multipart/form-data">
            <h1 id="heading">Přidat recept</h1>
            <div class="fieldContainer">
                <label for="recipeName">Název receptu: <span class="required">*</span></label>
                <input type="text" id="recipeName" name="recipeName" value="<?php if(isset($_GET['recipeName'])) echo(htmlspecialchars($_GET['recipeName']));?>">
                <div class="error" id="recipeNameError"></div>
            </div>
            <div>
                <div id="tags">Tagy:</div>
                <div class="checkboxGroup">
                    <label class="checkboxItem"  id="first">
                      <input type="checkbox" name="breakfast">Snídaně
                    </label>
                    <label class="checkboxItem">
                      <input type="checkbox" name="lunch">Oběd
                    </label>
                    <label class="checkboxItem">
                      <input type="checkbox" name="dinner">Večeře
                    </label>
                    <label class="checkboxItem">
                      <input type="checkbox" name="vegan">Veganské
                    </label>
                    <label class="checkboxItem">
                      <input type="checkbox" name="glutenFree">Bez Lepku
                    </label>
                </div>
            </div>
            <div class="fieldContainer">
                <label for="ingredients">Napište ingredience oddělené čárkou: <span class="required">*</span></label>
                <input type="text" id="ingredients" name="ingredients" value="<?php if(isset($_GET['ingredients'])) echo(htmlspecialchars($_GET['ingredients']));?>">
                <div class="info" id="ingredientsInfo"></div>
                <div class="error" id="ingredientsError"></div>
            </div>
            </div>
            <div class="fieldContainer" id="textAreaContainer">
                <label for="description">Napište popis postupu: <span class="required">*</span></label>
                <textarea rows="4" id="description" name="description" value="<?php if(isset($_GET['description'])) echo(htmlspecialchars($_GET['description']));?>"></textarea>
                <div class="error" id="descriptionError"></div>
            </div>
            <div class="fieldContainer">
                <label for="image">Nahrajte obrázek jídla: <span class="required">*</span></label>
                <input type="file" id="image" name="image" accept="image/*">
                <div class="error" id="imageError"></div>
            </div>
            <div class="fieldContainer">
                <button type="submit" id="submitButton">Odeslat</button>
            </div>
            <p class="info">Políčka označená hvědčikou jsou povinná.</p>
            <p id="error"><?php if(isset($_GET['error'])) echo(htmlspecialchars($_GET['error']));?></p>
        </form>
    </main>
</body>
</html>