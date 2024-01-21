<?php

require 'includes/http.php';
require 'classes/User.php';
require 'includes/db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    ## Fetch connection to DB
    $db_connection = getDB();

    if(User::userAuth($_POST['username'], $_POST['password'], $db_connection)) {

        ## Prevent session fixation
        session_regenerate_id(true);
        
        ## Set session variables
        $_SESSION['is_logged_in'] = true;
        $_SESSION['username'] = $_POST['username'];

        redirectToPath('/php-cms/index.php');

    } else {

        $error = "Username and password are required";

    }
    
}

?>

<?php require 'includes/header.php'; ?>

<h4> User login </h4>

<?php if (!empty($error)) : ?>

    <p class="error-message"><?= $error ?></p>

<?php endif; ?>

<form method="post">
    
    <div>
        <label for="username">Username</label>
        <input type="text" name="username" id="username">
    </div>

    <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
    </div>

    <button type="submit">Login</button>

</form>

<?php require 'includes/footer.php'; ?>
