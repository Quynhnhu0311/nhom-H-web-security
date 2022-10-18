<?php
// Start the session
session_start();
require_once 'models/PostModel.php';
$postModel = new PostModel();

$post = NULL; //Add new post
$post_id = NULL;

if (!empty($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $post = $postModel->findPostById($post_id);//Update existing user
}


if (!empty($_POST['submit'])) {

    if (!empty($post_id)) {
        $postModel->updatePost($_POST);
    } else {
        $postModel->insertPost($_POST);
        header('location: list_post.php');
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>User form</title>
    <?php include 'views/meta.php' ?>
</head>
<body>
    <?php include 'views/header.php'?>
    <div class="container">

            <?php if ($post || !isset($post_id)) { ?>
                <div class="alert alert-warning" role="alert">
                    Post form
                </div>
                <form method="POST">
                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                    <div class="form-group">
                        <label for="title">URL Post</label>
                        <input class="form-control" name="post_url" placeholder="URL" value='<?php if (!empty($post[0]['post_url'])) echo $post[0]['post_url'] ?>' required>
                    </div>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input class="form-control" name="post_title" placeholder="Title" value='<?php if (!empty($post[0]['post_title'])) echo $post[0]['post_title'] ?>' required>
                    </div>
                    <div class="form-group">
                        <label for="title">Description</label>
                        <input class="form-control" name="post_description" placeholder="Description" value='<?php if (!empty($post[0]['post_description'])) echo $post[0]['post_description'] ?>' required>
                    </div>
                    <div class="form-group">
                        <label for="token">Token</label>
                        <input type="password" name="token" class="form-control" value='<?php echo md5($_SESSION['id']); ?>'>
                    </div>

                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                </form>
            <?php } else { ?>
                <div class="alert alert-success" role="alert">
                    User not found!
                </div>
            <?php } ?>
    </div>
</body>
</html>