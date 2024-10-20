<?php
// Include necessary files and start the session
session_start();
include '../../model/conn.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['post_id'];
    $newContent = $_POST['content'];

    if (!empty($postId) && !empty($newContent)) {
        $query = "UPDATE posts SET content = ? WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            // Prepare error handling
            echo json_encode(['success' => false, 'error' => 'Database error: ' . htmlspecialchars($conn->error)]);
            exit();
        }
        $stmt->bind_param("sii", $newContent, $postId, $_SESSION['user_id']);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update the post']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid input']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>
