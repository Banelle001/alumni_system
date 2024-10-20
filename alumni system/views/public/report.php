<?php
// Start session and include DB connection
session_start();
$db = mysqli_connect("localhost", "root", "", "gradalumni_db");

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to report a post.");
}

// Check if post ID is set in the URL
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
} else {
    die("No post specified to report.");
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];  // Logged in user ID
    $reason = $_POST['reason'];       // Selected reason for the report

    // Insert the report into the database
    $query = "INSERT INTO reports (user_id, post_id, reason) VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param('iis', $user_id, $post_id, $reason);

    if ($stmt->execute()) {
        echo "Report submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!-- HTML Form for Reporting the Post -->
<div class="report-form">
    <h2>Report Post</h2>
    <form method="POST" action="">
        <label for="reason">Select a reason for reporting this post:</label><br>

        <input type="radio" name="reason" value="Spam" required> Spam<br>
        <input type="radio" name="reason" value="Inappropriate Content"> Inappropriate Content<br>
        <input type="radio" name="reason" value="Harassment"> Harassment<br>
        <input type="radio" name="reason" value="Bullying Abuse"> Bullying, Abuse<br>
		<input type="radio" name="reason" value="Adult content" required> Adult Content<br>
        <input type="radio" name="reason" value="False information"> False Information<br>
        <input type="radio" name="reason" value="Violent hatefull"> Violent, Hateful<br>
        <input type="radio" name="reason" value="Other"> Other<br>

        <button type="submit">Submit Report</button>
    </form>
    <!-- Change button to an anchor tag for cancel action -->
    <button><a href="Alumni_dash.php" class="btn btn-secondary">Back</a></button>
</div>

