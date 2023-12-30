<?php
/**
 * Job: Showcase recipes on the website; let users sort them and filter them.
 * Recipes are loaded from recipes.json, each is given a key property which previously served as the key
 * in recipes.json, this is because my parsing algorithm will destroy the keys and replace it with
 * numbers, thus treating it like an array and easily iterating over it in a foreach loop. Only those recipes
 * whose tags contain all tags wanted by the user are let through the filter function. Then, they are
 * alphabetically sorted, or reverse alphabetically if the GET superglobal is set that way. In the view part,
 * there is a foreach loop displaying all the data for each recipe. The most complex are tags (array of
 * strings), which have to be translated using a dictionary and a map function, then displayed by joining
 * the array into a string. 
 */

 /**
 * Case-incensitive compare, returns -1 or 1 based on which is earlier in the alphabet.
 *
 * Gets used as a function for the usort below. We want to alphabetically sort an array of recipes.
 * We do this by examining its recipeName property. It takes in two recipes, and returns -1 if first
 * recipe is earlier in alphabet, and 1 if second is earlier in alphabet. This works well with the
 * usort function below, because it requires this number representation.
 * @typedef Recipe {
 *   recipeName: string,
 *   description: string,
 *   ingredients: array<int, string>,
 *   author: string,
 *   tags: array<int, string>,
 *   key?: string
 * }
 * 
 *
 * @param Recipe $a First recipe to compare
 * @param Recipe $b First recipe to compare
 *
 * @return int
 */
function compareRecipeNames($a, $b) {
    return strcasecmp($a['recipeName'], $b['recipeName']);
}

session_start();
if (is_readable("recipes.json")) {
    $recipes = json_decode(file_get_contents("recipes.json"), true);
    foreach (array_keys($recipes) as $key) {
        $recipes[$key]["key"] = $key; // "sdfjkkey" => recipeName=asd, tags=asd..           to      "sdfjkkey" => recipeName=asd, key=sdfjkkey, tags=asd..
    }//recipes dont have the key property on them, its only the key of the recipes array. It will get lost through later code, so we have to save it.

    $possibleFilters = ["breakfast", "lunch", "dinner", "vegan", "glutenFree"];
    $wantedFilters = [];
    foreach ($possibleFilters as $filter) {
        if (isset($_GET[$filter])) {
            array_push($wantedFilters, $filter);
            //Only checked checkboxes are going to be sent as get parameters, so if I check if they are set, I know which ones were checked.
        }
    }//now wanted filters has all checked filters

    $recipes = array_filter($recipes, function ($recipe) use ($wantedFilters) {
        return !array_diff($wantedFilters, $recipe["tags"]);
    });
    //removes all recipes whose tags don't adhere to filters

    usort($recipes, 'compareRecipeNames'); //Sorts the array alphabetically, in place
    if (isset($_GET["sorting"]) && $_GET["sorting"] == "reverseAlphabetic") {
        $recipes = array_reverse($recipes);//if user wants reverseAlphabetic, we will reverse the array
    }


    //Now the recipes associative array is sorted, filtered and loaded into $recipes variable.
    //We just need a simple dictionary to translate tags from their English names. Done it translate function.
    $dict = array(
        "breakfast"=>"snídaně",
        "lunch"=>"oběd",
        "dinner"=>"večeře",
        "vegan"=>"veganské",
        "glutenFree"=>"bezlepkové"
    );
}
else {
    header("Location: error.php?code=500");
    die();
}



?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Váš Receptář</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/index.css">
    <meta name="author" content="Michael Cirkl">
    <meta name="description" content="Chutné recepty online">
    <meta name="keywords" content="recepty online">
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
            <?php
                foreach ($recipes as $recipe) { ?>
                <a class="card" href="recipe.php?recipeid=<?php echo($recipe["key"]);?>">
                    <h3 class="title"><?php echo(htmlspecialchars($recipe["recipeName"]));?></h3>
                    <div class="author">Autor: <?php echo(htmlspecialchars($recipe["author"]));?></div>
                    <img src="./images/<?php echo($recipe["key"]);?>" alt="<?php echo(htmlspecialchars($recipe["recipeName"]));?>" width="230" class="image">
                    <div class="tags">Tagy: <em><?php
                        $translatedTags = array_map(function ($tag) use ($dict) {return $dict[$tag];}, $recipe["tags"]);
                        echo(htmlspecialchars(implode(", ", $translatedTags)));
                    ?></em></div>
                    <div class="ingredients">Ingredience: <?php echo(htmlspecialchars(implode(", ", $recipe["ingredients"])));?></div>
                </a>
                <?php } ?>
        </section>
    </main>
</body>
</html>