<?php
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
                //header("Location: error.php?code=404");
                echo("tohle");
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


