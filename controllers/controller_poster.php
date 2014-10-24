<?php
require_once('../dao/dao.php');

$controllerType = $_POST['controllerType'];

if ($controllerType === "getPosts") {
    $posts = getPosts();
    echo json_encode($posts);
}
else if ($controllerType === "getPost") {
    $id = $_POST['id'];
    $post = getPost($id);
    echo json_encode($post);
}
else if ($controllerType === "addPost") {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $userid = $_POST['userid'];
    $post = addPost($title, $body, $userid);
    echo json_encode($post);
}
else if ($controllerType === "editPost") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $body = $_POST['body'];
    $userid = $_POST['userid'];
    $post = editPost($id, $title, $body, $userid);
    echo json_encode($post);
}
else if ($controllerType === "deletePost") {
    $id = $_POST['id'];
    deletePost($id);
}

?>