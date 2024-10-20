<?php
// Function to add a comment to a post
function addComment($userId, $postId, $comment) {
    global $conn;

    $query = "INSERT INTO comments (user_id, post_id, comment) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iis", $userId, $postId, $comment);

    if ($stmt->execute()) {
        echo "Comment added!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Function to delete a comment
function deleteComment($commentId) {
    global $conn;

    $query = "DELETE FROM comments WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $commentId);
    
    if ($stmt->execute()) {
        echo "Comment deleted!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Function to get total comments for a post
function getTotalComments($postId) {
    global $conn;

    $query = "SELECT COUNT(*) as total_comments FROM comments WHERE post_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['total_comments'];
}

// Function to view all comments for a post and who made the comment at what time
// Inside comments.php
function viewComments($postId) {
    global $conn; // Ensure access to the global connection variable
    $commentsQuery = "
        SELECT 
            c.comment AS comment_content,
            c.created_at AS comment_created_at, 
            u.photo AS comment_user_photo, 
            u.name AS comment_user_name
        FROM 
            comments c
        JOIN 
            users u 
        ON 
            c.user_id = u.id
        WHERE 
            c.post_id = ?
        ORDER BY 
            c.created_at ASC;
    ";

    $commentStmt = $conn->prepare($commentsQuery);
    if ($commentStmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $commentStmt->bind_param('i', $postId);
    if (!$commentStmt->execute()) {
        die('Execute failed: ' . htmlspecialchars($commentStmt->error));
    }

    $commentsResult = $commentStmt->get_result();
    if ($commentsResult === false) {
        die('Get result failed: ' . htmlspecialchars($conn->error));
    }

    if ($commentsResult->num_rows > 0) {
        while ($comment = $commentsResult->fetch_assoc()) {
            $commentUserPhoto = $comment['comment_user_photo'];
            $commentUserName = $comment['comment_user_name'];
            $commentContent = $comment['comment_content'];
            $commentDate = $comment['comment_created_at'];

            $displayCommentImage = file_exists($commentUserPhoto) ? $commentUserPhoto : '../img/pic2.png';
            ?>

            <div class="d-flex align-items-center mt-2">
                <div class="mr-2">
                    <img class="rounded-circle" width="30" src="<?php echo htmlspecialchars($displayCommentImage); ?>" alt="">
                </div>
                <div>
                    <div class="h6 m-0"><?php echo htmlspecialchars($commentUserName); ?></div>
                    <div class="h7 text-muted"><?php echo htmlspecialchars($commentDate); ?></div>
                    <p><?php echo nl2br(htmlspecialchars($commentContent)); ?></p>
                </div>
            </div>

            <?php
        }
    } else {
        echo '<p>No comments yet.</p>';
    }

    $commentStmt->close();
}

?>

