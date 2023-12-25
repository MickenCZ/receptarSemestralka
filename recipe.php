<?php
//If statements structured like guard clauses
    if (!isset($_GET["recipeid"])) {//Each recipe is identified with an ID, if it doesnt have it, url has been tampered with
        header("Location: index.php");
        die();
    }
    if (!is_readable("recipes.json")) {
        echo("Soubor s recepty nebyl nalezen. ");
        die();
    }

    $recipes = json_decode(file_get_contents("recipes.json"), true);
    if (!$recipes[$_GET["recipeid"]]) {
        echo("Recept s takovým ID neexistuje. ");
        die();
    }
    else {
        //main logic
        $recipeid = $_GET["recipeid"];
        $recipe = $recipes[$recipeid];

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recipe["recipeName"]); ?></title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/recipe.css">
</head>
<body>
<?php include "header.php" ?>
<main>
    <section id="recipe">
      <img src="<?php echo("./images/$recipeid"); ?>" alt="Obrázek receptu" id="image" height="320rem">
      <h2 id="recipeName"><?php echo htmlspecialchars($recipe["recipeName"]); ?></h2>
      <p id="author">
        <div>Autor: <?php echo htmlspecialchars($recipe["author"]); ?></div>
        <div>Tagy: <?php echo htmlspecialchars(implode(", ", $recipe["tags"])); ?></div>
    </p>
      <h3>Ingredience:</h3>
      <ul id="ingredients">
        <?php 
            foreach ($recipe["ingredients"] as $ingredient) {
                echo("<li>");
                echo(htmlspecialchars($ingredient));
                echo("</li>");
            }
        ?>
      </ul>
      <h3>Postup přípravy:</h3>
      <p id="description"><?php echo htmlspecialchars($recipe["description"]); ?></p>
      <h3>Komentáře:</h3>
    </section>
  </main>
</body>
</html>