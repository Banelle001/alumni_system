<?php
include '../../model/conn.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user input from the POST request
    $userId = $_POST['user_id']; // Ensure user_id is sent in the form
    $postId = $_POST['post_id']; // Ensure post_id is sent in the form
    $comment = $_POST['comment'];

    // Validate input to ensure no empty comment is submitted
    if (!empty($comment)) {
        // Prepare the SQL query to insert the comment into the comments table
        $query = "INSERT INTO comments (user_id, post_id, comment) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);

        // Check if the statement was successfully prepared
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        // Bind the parameters to the SQL query
        $stmt->bind_param("iis", $userId, $postId, $comment);

        // Execute the query
        if ($stmt->execute()) {
            // On successful execution, redirect back to the post page or show a success message
            echo "Comment added successfully!";
            header("Location: ../../views/public/Alumni_dash.php"); // Redirect to dashboard or post page
        } else {
            // If an error occurred, display it
            echo "Error: " . $conn->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // If the comment is empty, display an error message
        echo "Please enter a comment.";
    }
} else {
    // If the request method is not POST, show an error message
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>
