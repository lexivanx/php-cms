<?php

require 'includes/db.php';

$sql_query = "SELECT * FROM article ORDER BY time_of";

$results = mysqli_query($db_connection, $sql_query);

## Check for error in query
if ( $results === false) {
    echo mysqli_error($db_connection);
} else {
    $articles = mysqli_fetch_all($results, MYSQLI_ASSOC);
}


?>
<?php require 'includes/header.php'; ?>
        <?php if (empty($articles)): ?>
            <p>No articles found.</p>
        <?php else: ?>

        <ul>
            <?php foreach ($articles as $article) { ?>
                <li>
                    <article>
                        <h3>
                            <a href ="article.php?id=<?= $article['id']; ?>"><?= $article['title'];?>
                            </a>
                        </h3>
                        <p><?php echo $article['body']; ?></p>
                    </article>
                </li>
            <?php } ?>
        </ul>

        <?php endif; ?>
<?php require 'includes/footer.php'; ?>