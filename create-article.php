<?php 
    require 'includes/db.php';

    $errors = [];
    $title = '';
    $body = '';
    $time_of = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $title = $_POST['title'];
        $body = $_POST['body'];
        $time_of = $_POST['time_of'];

        ## Check for empty fields
        if (empty($title)) {
            $errors[] = "Title is required";
        }
        if (empty($body)) {
            $errors[] = "Body is required";
        }

        ## Check for errors in form
        if(empty($errors)) {
            ## Fetch connection to DB
            $db_connection = get_db_connection();

            $prepared_query = mysqli_prepare($db_connection, "INSERT INTO article (title, body, time_of) VALUES (?, ?, ?)");

            ## Check for error in query
            if ( $prepared_query === false) {

                echo mysqli_error($db_connection);

            } else {
                
                if ($time_of == '') {
                    $time_of = null;
                }

                # Handle quotes, escape characters, SQL injection etc.
                mysqli_stmt_bind_param($prepared_query, "sss", $title, $body, $time_of);

                if (mysqli_stmt_execute($prepared_query)) {

                    # Fetch and print id of new entry
                    $id = mysqli_insert_id($db_connection);

                    # Redirect to article page
                    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
                        $protocol = 'https';
                    } else {
                        $protocol = 'http';
                    }
                    header("Location: $protocol://" . $_SERVER['HTTP_HOST'] . "/php-cms" . "/article.php?id=$id");
                    exit;

                } else {

                    echo mysqli_stmt_error($prepared_query);

                }
            }
        }
        
    }
?>

<?php require 'includes/header.php'; ?>

<h3> Create a new article </h3>

<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error) { ?>
            <li><?= $error; ?></li>
        <?php } ?>
    </ul>
<?php endif; ?>

<form method="post">

    <div>
        <label for="title">Title</label>
        <input name="title" id="title" placeholder="Place a name for article" value="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>">
    </div>

    <div>
        <label for="body">Body</label>
        <textarea name="body" rows="10" cols="25" id="body" placeholder="Body of your article"><?= htmlspecialchars($body, ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div>

    <div>
        <label for="time_of">Article date</label>
        <input type="datetime-local" name="time_of" id="time_of" value="<?= htmlspecialchars($time_of, ENT_QUOTES, 'UTF-8'); ?>">
    </div>

    <button>Create</button>

</form>
<?php require 'includes/footer.php'; ?>