<?php
//If statements structured like guard clauses
    if (!isset($_GET["recipeid"])) {//Each recipe is identified with an ID, if it doesnt have it, url has been tampered with
        header("Location: error.php?code=404");
        die();
    }
    if (!is_readable("recipes.json")) {
        echo("Soubor s recepty nebyl nalezen. ");
        die();
    }

    $recipes = json_decode(file_get_contents("recipes.json"), true);
    if (!$recipes[$_GET["recipeid"]]) {
        header("Location: error.php?code=404");
        die();
    }
    else {
        //main logic
        $recipeid = $_GET["recipeid"];
        $recipe = $recipes[$recipeid];

    }
    $dict = array(
        "breakfast"=>"snídaně",
        "lunch"=>"oběd",
        "dinner"=>"večeře",
        "vegan"=>"veganské",
        "glutenFree"=>"bezlepkové"
    ); //for translating tags



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
        <div>Tagy: <?php
                        $translatedTags = array_map(function ($tag) use ($dict) {return $dict[$tag];}, $recipe["tags"]);
                        echo(htmlspecialchars(implode(", ", $translatedTags)));
        ?></div>
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
        <form action="POST" action="recipe.php">
            <label for="comment">Vyjadřete se k receptu:</label>
            <div class="flexColumn">
                <textarea name="comment" id="comment" rows="3"></textarea>

                <div id="ratingContainer">
                <select name="rating" id="rating">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <label for="rating" id="star">★</label>
                </div>
                
                <button type="submit" id="submitButton">Odeslat</button>
            </div>
        </form>
        <div class="comments">
            <div class="comment">
                <div class="commentBody">
                    <div class="author">Angry man 5★</div>
                    <div class="commentText">adsdsdsdsdsdsds            adsasddddddddd dsaaaaaaaaaa adsadsadsadsadsads sadsads sadsads sadsads sadsads</div>
                    <button class="redButton">Smazat</button>
                    <button class="blueButton">Upravit</button>
                </div>
            </div>
            
            
        </div>
      </section>

  </main>
</body>
</html>