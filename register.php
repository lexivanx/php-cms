<?php

require 'includes/http.php';
require 'classes/User.php';
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $error = '';

    // Basic validation for user and pass
    if (!$username || !$password) {
        $error = 'Username and password are required';
    } else {
        // Fetch connection to DB
        $db_connection = getDB();

        // Prepare the query
        $prepared_query = mysqli_prepare($db_connection, "INSERT INTO user (username, password) VALUES (?, ?)");

        if ($prepared_query === false) {
            $error = mysqli_error($db_connection);
        } else {
            // Secure password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Bind and execute
            mysqli_stmt_bind_param($prepared_query, "ss", $username, $hashed_password);
            
            if (mysqli_stmt_execute($prepared_query)) {
                // Redirect or show success message
                header("Location: success_page.php"); // Redirect to a success page
                exit;
            } else {
                $error = mysqli_stmt_error($prepared_query);
            }
        }
    }
    
}

?>

<?php require 'includes/header.php'; ?>

<h3> User registration </h3>

<?php if (!empty($error)) : ?>

    <p><?= $error ?></p>

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

<button type="submit">Register</button>

</form>

<?php require 'includes/footer.php'; ?>
