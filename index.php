<?php

require 'includes/db.php';

## Fetch connection to DB
$db_connection = get_db_connection();

$results = mysqli_query($db_connection, "SELECT * FROM article ORDER BY time_of");

## Check for error in query
if ( $results === false) {
    echo mysqli_error($db_connection);
} else {
    $articles = mysqli_fetch_all($results, MYSQLI_ASSOC);
}

?>
<?php require 'includes/header.php'; ?>

<a href="create-article.php">Create article</a>

<?php if (empty($articles)): ?>
    <p>No articles found.</p>
<?php else: ?>

<ul>
    <?php foreach ($articles as $article) { ?>
        <li>
            <article>
                <h3>
                    <a href ="article.php?id=<?= $article['id']; ?>">
                        <?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </h3>
                <p>
                    <?= htmlspecialchars($article['body'], ENT_QUOTES, 'UTF-8'); ?>
                </p>
            </article>
        </li>
    <?php } ?>
</ul>

<?php endif; ?>
<?php require 'includes/footer.php'; ?>