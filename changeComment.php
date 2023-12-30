<?php
/**
 * Job: Use recipeid and commentid from hidden inputs, then let the user write a new comment and/or
 * rating and use all four pieces of information to make a valid change to comments.json.
 * It is an actual page with html, not just an API endpoint. Hidden inputs with recipeid and commentid
 * are echoed into the html form, which we need to do to preserve information from recipe.php. The
 * user doesn’t see that though, they need to fill in the other form elements to change rating and/or
 * comment text. If everything is set correctly, we use the same finding algorithm for the comment as
 * we did in deleteComment and we change the values in the object/assocArray to their new rating and
 * comment. After everything is done, it is written to comments.json and user is taken back. In general,
 * changeComment and deleteComment work almost the exact same way, except changeComment has
 * the added complexity of also needing to take in information from the second form on the page itself.
 */
session_start();
if (isset($_POST["recipeid"]) && isset($_POST["commentid"]) && isset($_POST["rating"]) && isset($_POST["comment"])) { //Did click delete comment button?
    if (!isset($_SESSION['loggedin'])) {//is logged in?
        header("Location: error.php?code=403");
        die();
    }
    $currentUser = $_SESSION["username"];
    $recipeid = $_POST["recipeid"];
    $commentid = $_POST["commentid"];
    if (!in_array($_POST["rating"], ["1", "2", "3", "4", "5"])) { //submitted rating must be 1 to 5.
        header("Location: error.php?code=403");
        die();
    }//is rating valid?
    

    if (is_readable("comments.json")) {
        $comments = json_decode(file_get_contents("comments.json"), true);
        if (isset($comments[$recipeid])) { //if such recipe exists
            $foundComment = null;
            $foundCommentIndex = null;
            foreach ($comments[$recipeid] as $index => $comment) {
                if (isset($comment["commentid"]) && $comment["commentid"] == $commentid) {//if comment in iteration has desired commentid
                    $foundComment = $comment; //load comment we want to change into foundcomment variable
                    $foundCommentIndex = $index;
                }
            }

            if ($foundComment == null) {
                header("Location: error.php?code=404");
                die();
            }
            else { //if comment is found
                if ($foundComment["author"] == $currentUser) {//if its the correct user
                    //change comments.json file, this is the different code as opposed to deleteComment.php
                    $comments[$recipeid][$foundCommentIndex]["rating"] = $_POST["rating"]; //change set values of comment in assocArray
                    $comments[$recipeid][$foundCommentIndex]["comment"] = $_POST["comment"];

                    file_put_contents("comments.json", json_encode($comments)); //write to filesystem
                    header("Location: recipe.php?recipeid=".$recipeid); //success, take them back
                    die();
                }
                else {
                    header("Location: error.php?code=403");
                    die(); //trying to change someone elses recipe
                }
            }
        }
        else {
            header("Location: error.php?code=404");
            die(); //trying to change comment on an unknown recipe
        }
    }
    else {
        header("Location: error.php?code=500");
        die(); //file comments.json is not readable.
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upravit komentář</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/recipe.css">
    <meta name="author" content="Michael Cirkl">
    <meta name="description" content="Chutné recepty online">
    <meta name="keywords" content="recepty online">
</head>
<body>
    <?php include "header.php" ?>
<form method="POST" action="changeComment.php">
<input type="hidden" name="recipeid" value="<?php echo($_POST["recipeid"]); ?>">
<input type="hidden" name="commentid" value="<?php echo($_POST["commentid"]); ?>">
<label for="comment" id="commentChange">Změňte svůj komentář: </label>
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
</form>
</body>
</html>