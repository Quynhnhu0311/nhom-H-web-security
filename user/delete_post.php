<?php
require_once 'models/PostModel.php';
session_start();
$postModel = new PostModel();

$post = NULL; //Add new user
$post_id = NULL;
$token = NULL;


if (!empty($_GET['post_id'] || $_GET['token'])) {
    $post_id = $_GET['post_id'];
    $token = $_GET['token'];
    $postModel->deletePostById( $post_id, $token);//Delete existing post
}
header('location: list_post.php');
?>