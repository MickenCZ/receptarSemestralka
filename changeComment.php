<?php
session_start();
if (isset($_POST["recipeid"]) && isset($_POST["commentid"]) && isset($_POST["rating"]) && isset($_POST["comment"])) { //Did click delete comment button?
    if (!isset($_SESSION['loggedin'])) {//is logged in?
        header("Location: error.php?code=403");
        die();
    }
    $currentUser = $_SESSION["username"];
    $recipeid = $_POST["recipeid"];
    $commentid = $_POST["commentid"];
    if (!in_array($_POST["rating"], ["1", "2", "3", "4", "5"])) {
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
                    $foundComment = $comment; //load it into foundcomment variable
                    $foundCommentIndex = $index;
                }
            }

            if ($foundComment == null) {
                header("Location: error.php?code=404");
                die();
            }
            else { //if comment is found
                if ($foundComment["author"] == $currentUser) {//if its the same user
                    //change file, this is the different code as opposedd ot deleteComment.php
                    $comments[$recipeid][$foundCommentIndex]["rating"] = $_POST["rating"]; //change set values of comment in assocArray
                    $comments[$recipeid][$foundCommentIndex]["comment"] = $_POST["comment"];

                    file_put_contents("comments.json", json_encode($comments)); //write to filesystem
                    header("Location: recipe.php?recipeid=".$recipeid); //success, take them back
                    die();
                }
                else {
                    header("Location: error.php?code=403");
                    die();
                }
            }
        }
        else {
            header("Location: error.php?code=404");
            die();
        }
    }
    else {
        header("Location: error.php?code=500");
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upravit komentář</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/recipe.css">
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