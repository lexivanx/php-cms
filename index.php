<?php

require 'includes/db.php';
require 'includes/authentication.php';

session_start();

## Fetch connection to DB
$db_connection = getDB();

$results = mysqli_query($db_connection, "SELECT * FROM article ORDER BY time_of");

## Check for error in query
if ( $results === false) {
    echo mysqli_error($db_connection);
} else {
    $articles = mysqli_fetch_all($results, MYSQLI_ASSOC);
}

?>
<?php require 'includes/header.php'; ?>

<div class="logged-in-info">
<?php if (checkAuthentication()): ?>

    <p> Currently logged in as: <strong> <?php echo $_SESSION['username']; ?> </strong> </p>
        <a href="logout.php">Logout</a>
    <p>
        <a href="create-article.php">Create article</a>
    </p>

<?php else: ?>

    <p> No user logged in </p>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>

<?php endif; ?>
</div>


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
                <p>
                    Created by: <strong> <?= htmlspecialchars($article['created_by'], ENT_QUOTES, 'UTF-8'); ?> </strong> 
                </p>
                <p>
                    Created at: <em> <?= htmlspecialchars($article['time_of'], ENT_QUOTES, 'UTF-8'); ?> </em> 
                </p>

            </article>
        </li>
    <?php } ?>
</ul>

<?php endif; ?>
<?php require 'includes/footer.php'; ?>