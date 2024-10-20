<?php
// Database configuration
include '../../model/conn.php';
include '../../controller/Alumni/likes.php';
include '../../controller/Alumni/comments.php';
include '../../config/database.php'; // Include your database connection

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get the post ID from the request
if (!isset($_GET['post_id']) || !is_numeric($_GET['post_id'])) {
    header("Location: index.php?error=InvalidPostID");
    exit();
}

$postId = intval($_GET['post_id']);
$userId = $_SESSION['user_id'];

// Prepare and execute the query to delete the post
$query = "DELETE FROM posts WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param('ii', $postId, $userId);
if (!$stmt->execute()) {
    die('Execute failed: ' . htmlspecialchars($stmt->error));
}

// Check if any rows were affected
if ($stmt->affected_rows > 0) {
    // Post deleted successfully
    header("Location: ../../views/public/Alumni_dash.php");
} else {
    // Post not found or not owned by user
    header("Location: ../../views/public/Alumni_dash.php");
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
