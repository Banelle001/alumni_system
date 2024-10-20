<?php

// Database configuration
include '../../model/conn.php';
include 'functions.php';


if (isset($_GET['post_id'])) {
    $postId = $_GET['post_id'];
    viewComments($postId);
}
?>


