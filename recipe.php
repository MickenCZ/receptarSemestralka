<?php
/**
 * Job: Display finer details about a specific recipe and let users write and access comments.
 * The page itself doesn’t do anything, but it uses a get parameter called recipeid for dynamic
 * pagination, so each recipe.php?recipeid=someid represents an individual recipe. The PHP in this file is
 * light, mostly just doing error handling and reading comments and recipe details from the json files, so
 * they can be displayed below, which contains a lot of HTML. As shown in the diagram, it calls 3 API
 * endpoints to handle comments that are explained below.
 */

session_start();
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
        $recipeid = $_GET["recipeid"]; //the id in url
        $recipe = $recipes[$recipeid];

    }
    $dict = array(
        "breakfast"=>"snídaně",
        "lunch"=>"oběd",
        "dinner"=>"večeře",
        "vegan"=>"veganské",
        "glutenFree"=>"bezlepkové"
    ); //for translating tags, they are stored in english

    //comments logic
    if (!is_readable("comments.json")) {
        header("Location: error.php?code=500");
        die();
    }
    else {
        $allComments = json_decode(file_get_contents("comments.json"), true);
        if (isset($allComments[$recipeid])) { //if key is set, add to the array that is in value, if key isnt set, create array
            $comments = $allComments[$recipeid];
        }
        else {
            $comments = [];
        }
        
        
    }

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recipe["recipeName"]); ?></title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/recipe.css">
    <meta name="author" content="Michael Cirkl">
    <meta name="description" content="Chutné recepty online">
    <meta name="keywords" content="recepty online">
</head>
<body>
<?php include "header.php" ?>
<main>
    <section id="recipe">
      <img src="<?php echo("./images/$recipeid"); ?>" alt="<?php echo(htmlspecialchars($recipe["recipeName"]));?>" id="image" height="320">
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

        <h3>Komentáře: <?php if (!isset($_SESSION['loggedin'])) {echo('(Pro komentování je nutné mít účet)');}?></h3>
        <form method="POST" action="saveComment.php" id="saveCommentForm" <?php if (!isset($_SESSION['loggedin'])) {echo('class="hidden"');}?>>
            <label for="comment">Vyjadřete se k receptu:</label>
            <div class="flexColumn">
                <input type="hidden" name="recipeid" value="<?php echo($recipeid); ?>">
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
            <?php 
            foreach ($comments as $comment) { ?>
                <div class="comment">
                    <div class="commentBody">
                        <div class="author"><?php echo(htmlspecialchars($comment["author"]." ".$comment["rating"]."★")); ?></div>
                        <div class="commentText"><?php echo(htmlspecialchars($comment["comment"])); ?></div>
                        <div id="buttonForms">
                            <?php 
                                if (isset($_SESSION["username"]) && $_SESSION["username"] == $comment["author"]) { ?>
                                <form method="POST" action="deleteComment.php">
                                    <button class="redButton" type="submit" name="delete" value="delete">Smazat</button>
                                    <input type="hidden" name="recipeid" value="<?php echo($recipeid); ?>">
                                    <input type="hidden" name="commentid" value="<?php echo($comment["commentid"]); ?>">
                                </form>
                                <form method="POST" action="changeComment.php">
                                    <button class="blueButton" type="submit" name="change" value="change">Upravit</button>
                                    <input type="hidden" name="recipeid" value="<?php echo($recipeid); ?>">
                                    <input type="hidden" name="commentid" value="<?php echo($comment["commentid"]); ?>">
                                </form>
                            <?php  } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            
        </div>
      </section>

  </main>
</body>
</html>