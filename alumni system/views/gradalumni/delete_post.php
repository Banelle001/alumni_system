<?php
// Connect to the database
$db = mysqli_connect("localhost", "root", "", "gradalumni_db");

// Check if connection was successful
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if post ID is sent via POST
if (isset($_POST['id'])) {
    $postId = intval($_POST['id']);

    // Start a transaction to ensure that both queries succeed or fail together
    mysqli_begin_transaction($db);

    try {
        // First, delete all related reports
        $deleteReportsQuery = "DELETE FROM reports WHERE post_id = ?";
        $stmt = $db->prepare($deleteReportsQuery);
        $stmt->bind_param('i', $postId);

        if (!$stmt->execute()) {
            throw new Exception("Error deleting related reports: " . $stmt->error);
        }

        // Now, delete the post
        $deletePostQuery = "DELETE FROM posts WHERE id = ?";
        $stmt = $db->prepare($deletePostQuery);
        $stmt->bind_param('i', $postId);

        if (!$stmt->execute()) {
            throw new Exception("Error deleting post: " . $stmt->error);
        }

        // Commit the transaction if both deletions were successful
        mysqli_commit($db);
        echo "Post and related reports deleted successfully.";

    } catch (Exception $e) {
        // If there is any error, rollback the transaction
        mysqli_rollback($db);
        echo $e->getMessage();
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
mysqli_close($db);
?>
