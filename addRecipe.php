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
    <link rel="stylesheet" href="css/authForm.css">
    <link rel="stylesheet" href="css/addRecipe.css">
</head>
<body>
    <?php 
    include "header.php";
    ?>
    <main>
        <form>
            <h2 id="heading">Add Recipe</h2>

            <div class="fieldContainer">
                <label for="recipeName">Recipe Name: <span class="required">*</span></label>
                <input type="text" id="recipeName" name="recipeName" autocomplete="on">
                <div class="error" id="recipeNameError"></div>
            </div>

            <div class="fieldContainer">
                <label for="ingredients">Ingredients: <span class="required">*</span></label>
                <textarea id="ingredients" name="ingredients" rows="4"></textarea>
                <div class="error" id="ingredientsError"></div>
            </div>

            <div class="fieldContainer">
                <label for="instructions">Instructions: <span class="required">*</span></label>
                <textarea id="instructions" name="instructions" rows="6"></textarea>
                <div class="error" id="instructionsError"></div>
            </div>

            <div class="fieldContainer">
                <label for="author">Author: </label>
                <input type="text" id="author" name="author" autocomplete="on">
                <div class="error" id="authorError"></div>
            </div>

            <button type="submit" id="submitButton">Add Recipe</button>
        </form>
    </main>
</body>
</html>