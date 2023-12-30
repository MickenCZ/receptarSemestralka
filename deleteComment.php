<?php
/**
 * Job: Take recipeid and commentid from hidden inputs beside the delete button and remove comment
 * from comments.json.
 * If recipeid and commentid are set, it reads the file, tries finding the comment, and if successful (ids
 * match) and if the logged in user is the same as comment author, it removes the comment and writes
 * changes to comments.json by unsetting that comment.
 * 
 * This endpoint gets hit when a user wants to delete a comment, it will get the commentid and recipeid from post params. 
 * We want to delete it from our comments.json file and redirect the user back to the original recipe where the comment was.
 * We need a lot of validation to check if the recipe and comment exist, and if the user has the rights to delete it.
 */

session_start();
if (isset($_POST["delete"]) && isset($_POST["recipeid"]) && isset($_POST["commentid"])) { //Did click delete comment button?
    if (!isset($_SESSION['loggedin'])) {//is logged in?
        header("Location: error.php?code=403");
        die();
    }
    $currentUser = $_SESSION["username"];
    $recipeid = $_POST["recipeid"];
    $commentid = $_POST["commentid"];

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
                    unset($comments[$recipeid][$foundCommentIndex]); //remove comment
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


