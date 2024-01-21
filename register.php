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

        // Check if username already exists
        $existing_user_query = mysqli_prepare($db_connection, "SELECT COUNT(*) FROM user WHERE username = ?");
        mysqli_stmt_bind_param($existing_user_query, "s", $username);
        mysqli_stmt_execute($existing_user_query);
        mysqli_stmt_bind_result($existing_user_query, $existing_user_count);
        mysqli_stmt_fetch($existing_user_query);
        mysqli_stmt_close($existing_user_query);

        if ($existing_user_count > 0) {
            $error = 'Username already exists. Please choose a different username.';
        } else {
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
                    header("Location: success-page.php"); // Redirect to a success page
                    exit;
                } else {
                    $error = mysqli_stmt_error($prepared_query);
                }
            }
        }
    }

}

?>

<?php require 'includes/header.php'; ?>

<h4> User registration </h4>

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

<button type="submit">Register</button>

</form>

<?php require 'includes/footer.php'; ?>
