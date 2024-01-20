<?php

require 'includes/db.php';

## Fetch connection to DB
$db_connection = get_db_connection();

### Prevent SQL injection - is id a number and is it set
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $sql_query = "SELECT * FROM article WHERE id = $id";
    $results = mysqli_query($db_connection, $sql_query);

    ## Check for error in query
    if ( $results === false) {
        echo mysqli_error($db_connection);
    } else {
        $article = mysqli_fetch_assoc($results);
    }

} else {
    $article = null;
}

?>
<?php require 'includes/header.php'; ?>
        <?php if ($article === null): ?>
            <p>No articles found.</p>
        <?php else: ?>

            <article>
                <h3><?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                <p><?=  htmlspecialchars($article['body'], ENT_QUOTES, 'UTF-8'); ?></p>
            </article>

        <?php endif; ?>
<?php require 'includes/footer.php'; ?>