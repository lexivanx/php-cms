<?php

require 'includes/db.php';
require 'includes/article-funs.php';
require 'includes/http.php';

### Fetch connection to DB
$db_connection = getDB();

### If ID is not set, print error and exit script
if (isset($_GET['id'])) {

    $article = getArticle($db_connection, $_GET['id'], 'id');

    ## If ID is invalid, print error and exit script
    if ($article) {

        $id = $article['id'];

    } else {

        die("No article found");

    }

} else {

    die("ID not specified, no article found");

}

### Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    ## Delete query
    $prepared_query = mysqli_prepare($db_connection, "DELETE FROM article WHERE id = ?");

    ## Check for error in query
    if ( $prepared_query === false) {

        echo mysqli_error($db_connection);

    } else {
        
        # Handle quotes, escape characters, SQL injection etc.
        mysqli_stmt_bind_param($prepared_query, "i", $id);

        if (mysqli_stmt_execute($prepared_query)) {

            # Redirect to article page
            redirectToPath("/php-cms" . "/index.php");
            
        } else {

            echo mysqli_stmt_error($prepared_query);

        }
    }

}

?>

<?php require 'includes/header.php'; ?>

<h4> Remove article </h4>

<form method="post">
    <p>Are you sure you want to remove this article?</p>

    <button>Remove</button>

    <a href="article.php?id=<?= $article['id']; ?>">Cancel</a>
</form>

<?php require 'includes/footer.php'; ?>