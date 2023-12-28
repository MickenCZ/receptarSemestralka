<?php
session_start();
    //comment and rating form
    if (isset($_POST["rating"]) && isset($_POST["comment"]) && isset($_POST["recipeid"])) {
        $error = "";
        $valid = true;
        $rating = $_POST["rating"];
        $comment = $_POST["comment"];
        $recipeid = $_POST["recipeid"]; //from hidden input
        $commentid = bin2hex(random_bytes(10));
        if (!in_array($rating, ["1", "2", "3", "4", "5"])) {
            header("Location: error.php?code=403");
            die();
        } //These would only happen if someone intentially meddled with the request, thus a forbidden error is appropriate.
        if (!isset($_SESSION['loggedin'])) {
            header("Location: error.php?code=403");
            die();
        }
        if (is_readable("comments.json")) {
            $comments = json_decode(file_get_contents("comments.json"), true); 
            /*Schema of comments.json is {
                recipeidstringthing: [{comment:"asd", author:"asd", rating:"3"}],
            }*/
            if (isset($comments[$recipeid])) {
                array_push($comments[$recipeid], array("rating"=>$rating, "comment"=>$comment, "author"=>$_SESSION['username'], "commentid"=>$commentid));
            }
            else {
                $comments[$recipeid] = [array("rating"=>$rating, "comment"=>$comment, "author"=>$_SESSION['username'], "commentid"=>$commentid)];
            }

            file_put_contents("comments.json", json_encode($comments));
            header("Location: recipe.php?recipeid=" . $recipeid);
            die();
        }
        else {
            header("Location: error.php?code=500");
            die();
        }
    }
?>