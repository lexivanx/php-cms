<?php

require 'includes/db.php';
require 'includes/article-funs.php';

## Fetch connection to DB
$db_connection = getDB();

if (isset($_GET['id'])) {

    $article = getArticle($db_connection, $_GET['id']);

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

            <a href="edit-article.php?id=<?= $article['id']; ?>">Edit</a>
            <a href="remove-article.php?id=<?= $article['id']; ?>">Delete</a>

        <?php endif; ?>
<?php require 'includes/footer.php'; ?>