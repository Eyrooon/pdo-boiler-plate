<?php 

require 'database.php';


$database = new Database;


$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


# INSERT DATA
/* if ($post['submit']) {
    $title = $post['title'];
    $body = $post['body'];

    $database->query('INSERT INTO posts (title, body) VALUES(:title, :body)');
    $database->bind(':title', $title);
    $database->bind(':body', $body);
    $database->execute();

    if ($database->lastInsertId()) {
        echo '<p> Post Added! </p>';
    }
} */


# UPDATE DATA
if (array_key_exists("submit",$post) && $post['submit']) {
    $id = $post['id'];
    $title = $post['title'];
    $body = $post['body'];

    $database->query('UPDATE posts SET title = :title, body = :body WHERE id = :id');
    $database->bind(':id', $id);
    $database->bind(':title', $title);
    $database->bind(':body', $body);
    $database->execute();
}

# DELETE DATA
if ($_POST['delete']) {
    $delete_id = $_POST['delete_id'];
    $database->query('DELETE FROM posts WHERE id = :id');
    $database->bind(':id', $delete_id);
    $database->execute();
}

$database->query('SELECT * FROM posts');
// $database->query('SELECT * FROM posts WHERE id = :id');
// $database->bind(':id', 1);

$rows = $database->resultSet();

?>

<h1>Add Post</h1>
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
    <label>Post ID</label> <br />
    <input type="text" name="id" /> <br /><br />
    <label>Title</label> <br />
    <input type="text" name="title" /> <br /><br />
    <label>Body</label><br />
    <textarea name="body" cols="30" rows="10"></textarea> <br /> <br />
    <input type="submit" name="submit" value="Submit" />
</form>

<h1>Posts</h1>
<div>
<?php foreach($rows as $row) : ?>
    <div>
        <h3><?php echo $row['title']; ?></h3>
        <p><?php echo $row['body']; ?></h3>
        <br />
        <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
            <input type="submit" name="delete" value="Delete" />
        </form>
    </div>
<?php endforeach; ?>
</div>
