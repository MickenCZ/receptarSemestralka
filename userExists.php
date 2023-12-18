<?php
/* 
This endpoint gets a GET request with a username included. (GET because its a readonly idempotent operation)
It needs to send back true or false based on if a user with this username already exists, using AJAX
Steps:
1. Read username from request
2. Read users.json file
3. Check if username is in users object
4. respond with true, false, or an error in case someone deleted the database
*/
if (isset($_GET["username"])) {
    $username = $_GET["username"];
    if (is_readable("users.json")) {
        $users = json_decode(file_get_contents("users.json"), true);
        if (array_key_exists($username, $users)) {
            echo("true");
        }
        else {
            echo("false");
        }
    }
    else {
        echo("dberror");
    }
}
?>