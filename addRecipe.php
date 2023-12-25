<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    die();
}

//If all fields are set, validate inputs, if not valid, send back prefilled form and errors, if valid, register user

if (isset($_POST["recipeName"]) && isset($_POST["ingredients"]) && isset($_POST["description"]) && isset($_FILES["image"])) {
    $error = "";
    $valid = true;
    $recipeName = $_POST["recipeName"];
    $ingredients = $_POST["ingredients"];
    $description = $_POST["description"];
    $image = $_FILES["image"];
    //checkbox prefill
    $checkBoxValues = ["breakfast", "lunch", "dinner", "vegan", "glutenFree"];
    $checkBoxURL = "";
    foreach ($checkBoxValues as $value) {
        if (isset($_POST[$value])) {
            $checkBoxURL .= "&".$value."=checked";
        }
    /*For each checked checkbox, it appends for example &breakfast=checked to the URL as get parameters,
    which is then read by $_GET["breakfast"]. Used for prefilling*/
    }

    if (strlen($recipeName) < 3) {
        $valid = false;
        $error .= "Jméno receptu je moc krátké. ";
    }
    if (strlen($ingredients) == 0) {
        $valid = false;
        $error .= "Ingredience nesmí být prázdné. ";
    }
    if (strlen($description) <= 20) {
        $valid = false;
        $error .= "Popis postupu je moc krátký. ";
    }
    if ($_FILES["image"]["error"] == 4) {
        $valid = false;
        $error .= "Nebyl nahrán obrázek. ";
    }
    else if ($_FILES["image"]["error"] != 0) {
        $valid = false;
        $error .= "Stala se chyba s obrázkem. ";
    }
    if (!in_array(exif_imagetype($image["tmp_name"]), [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP])) {
        $valid = false;
        $error .= "Nenahráli jste obrázek. Podporujeme formáty PNG, JPEG, WEBP. ";
    }
    if (!is_readable("recipes.json")) {
        $valid = false;
        $error .= "Stala se chyba serveru. ";
    }

    if (!$valid) {
        header("Location: "."addRecipe.php?error=$error&recipeName=$recipeName&ingredients=$ingredients&description=$description$checkBoxURL");
        die();
    }
    else {
        //goals - read recipes.json, parse to a recipe assocArray, update recipes.json
        //Know its readable, checked before
        $recipes = json_decode(file_get_contents("recipes.json"), true);
        $recipeID = bin2hex(random_bytes(10));
        while (isset($recipes[$recipeID])) {
            $recipeID = bin2hex(random_bytes(10));
        }//Generate a unique Id. If it already has an entry, generate another one. Works similar to youtube video ids in urls.

        $ingredientsArray = explode(",", $ingredients); //ingredients are separated by commas in an array
        $ingredientsArray = array_map('trim', $ingredientsArray); //trim the space at end or start of each ingredient, to prevent asd, qwe => ["asd", " qwe"]
        $ingredientsArray = array_filter($ingredientsArray, function($item) {return $item !== "";}); //remove empty items caused by comma at end
        //now we have a valid array of ingredients

        $uploadFilePath = "./images/" . $recipeID;
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadFilePath);

        $tags = [];
        $dict = array("breakfast"=>"snídaně", "lunch"=>"oběd", "dinner"=>"večeře", "vegan"=>"veganské","glutenFree" => "bez lepku");
        foreach ($checkBoxValues as $value) {
            if (isset($_POST[$value])) {
                array_push($tags, $dict[$value]);
            }
        }
        //parsing the tags

        $recipes[$recipeID] = array(
        "recipeName" => $recipeName, 
        "description" => $description, 
        "ingredients" => $ingredientsArray, 
        "author"=>$_SESSION["username"], 
        "tags"=>$tags);
        //image is in images/$recipeID
        
        file_put_contents("recipes.json", json_encode($recipes));
        //now that everything is done, put the updated recipes assocArray into the recipes.json file.
    }
}



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
                      <input type="checkbox" name="breakfast" <?php if(isset($_GET['breakfast'])) echo(htmlspecialchars($_GET['breakfast']));?>>Snídaně
                    </label>
                    <label class="checkboxItem">
                      <input type="checkbox" name="lunch" <?php if(isset($_GET['lunch'])) echo(htmlspecialchars($_GET['lunch']));?>>Oběd
                    </label>
                    <label class="checkboxItem">
                      <input type="checkbox" name="dinner" <?php if(isset($_GET['dinner'])) echo(htmlspecialchars($_GET['dinner']));?>>Večeře
                    </label>
                    <label class="checkboxItem">
                      <input type="checkbox" name="vegan" <?php if(isset($_GET['vegan'])) echo(htmlspecialchars($_GET['vegan']));?>>Veganské
                    </label>
                    <label class="checkboxItem">
                      <input type="checkbox" name="glutenFree" <?php if(isset($_GET['glutenFree'])) echo(htmlspecialchars($_GET['glutenFree']));?>>Bez Lepku
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
                <label for="description">Napište postup přípravy: <span class="required">*</span></label>
                <textarea rows="4" id="description" name="description"><?php if(isset($_GET['description'])) echo(htmlspecialchars($_GET['description']));?></textarea>
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