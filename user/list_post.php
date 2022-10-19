<?php
// Start the session
session_start();
require_once 'models/UserModel.php';
$userModel = new UserModel();
require_once 'models/PostModel.php';
$postModel = new PostModel();
$params = [];
if (!empty($_GET['keyword'])) {
    $params['keyword'] = $_GET['keyword'];
}

$posts = $postModel->getPosts($params);
$users = $userModel->getUsers($params);
$usersid = $userModel->findUserById($_SESSION['id']);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <?php include 'views/meta.php' ?>
</head>

<body>
    <?php include 'views/header.php' ?>
    <div class="container">
        <?php if (!empty($posts)) { ?>
            <div class="alert alert-warning" role="alert">
                List of users! <br>
                Hacker: http://php.local/list_users.php?keyword=ASDF%25%22%3BTRUNCATE+banks%3B%23%23
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Post_URL</th>
                        <th scope="col">Post_description</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post) { ?>
                        <tr>
                            <th scope="row"><?php echo $post['post_id'] ?></th>
                            <td>
                                <?php echo $post['post_title'] ?>
                            </td>
                            <td>
                                <?php echo $post['post_url'] ?>
                            </td>
                            <td>
                                <?php echo $post['post_description'] ?>
                            </td>
                            <td>
                                <?php foreach ($usersid as $key) { ?>
                                    <?php if (md5($_SESSION['id'] . $key['key_user']) == ($post['token'])) { ?>
                                        <a href="delete_post.php?post_id=<?php echo ($post['post_id']) ?>&token=<?php echo ($post['token']) ?>">
                                            <i class="fa fa-eraser" aria-hidden="true" title="Delete"></i>
                                        </a>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="alert alert-dark" role="alert">
                This is a dark alert—check it out!
            </div>
        <?php } ?>
    </div>
</body>

</html>