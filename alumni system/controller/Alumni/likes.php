<?php

require '../../model/conn.php';



// Function to like a post
function likePost($userId, $postId) {
    global $conn;

    $query = "INSERT INTO likes (user_id, post_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $userId, $postId);

    if ($stmt->execute()) {
        echo "Liked post!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Function to unlike a post
function unlikePost($userId, $postId) {
    global $conn;

    $query = "DELETE FROM likes WHERE user_id = ? AND post_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $userId, $postId);
    
    if ($stmt->execute()) {
        echo "Unliked post!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Function to get total likes for a post
function getTotalLikes($postId) {
    global $conn;

    $query = "SELECT COUNT(*) as total_likes FROM likes WHERE post_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['total_likes'];
}
?>