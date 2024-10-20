<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GradConnect</title>
    <link rel="stylesheet" href="../gradalumni/css/admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <style>
.container {
    padding: 20px;
}

.grid-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.grid-item {
    border: 1px solid #ddd;
    padding: 15px;
    box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
    border-radius: 8px;
    background-color: #f9f9f9;
    text-align: center;
}

.event-banner {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 10px;
}

.grid-item h3 {
    margin-bottom: 10px;
    font-size: 1.5em;
    color: #333;
}

.rsvp-button {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.rsvp-button:hover {
    background-color: #0056b3;
}

/* Modal styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 60px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    border-radius: 8px;
    text-align: left;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

input[type="text"],
input[type="email"],
input[type="number"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
}
</style>

</head>
<body>
    <div class="dashboard">
    <aside class="sidebar">
			<ul>
				<a href="home.php"><img src="assets/uploads/images.png" alt="" width="80%" height="70%"></a>
				<hr>
				<li><a href="home.php"><img width="30" height="30" src="https://img.icons8.com/3d-fluency/94/control-panel.png" alt="control-panel"/>&nbsp; Dashboard</a></li>
				<li><a href="gallery.php"><img width="30" height="30" src="https://img.icons8.com/color/48/image-gallery.png" alt="image-gallery"/>&nbsp; Gallery</a></li>
				<li><a href="alumnilist.php"><img width="30" height="30" src="https://img.icons8.com/fluency/48/overview-pages-3.png" alt="overview-pages-3"/>&nbsp; Alumni List</a></li>
				<li><a href="jobs.php"><img width="30" height="30" src="https://img.icons8.com/stickers/100/new-job.png" alt="new-job"/>&nbsp; Jobs</a></li>
				<li><a href="events.php"><img width="30" height="30" src="https://img.icons8.com/fluency/48/event-accepted--v1.png" alt="event-accepted--v1"/>&nbsp; Events</a></li>
				<li><a href="news.php"><img width="30" height="30" src="https://img.icons8.com/3d-fluency/94/news.png" alt="news"/>&nbsp; News</a></li>
				<li><a href="rsvplist.php"><img width="30" height="30" src="https://img.icons8.com/external-flaticons-lineal-color-flat-icons/64/external-rsvp-event-management-flaticons-lineal-color-flat-icons-3.png" alt="external-rsvp-event-management-flaticons-lineal-color-flat-icons-3"/>&nbsp; RSVP List</a></li>
				<li><a href="logout.php"><img width="30" height="30" src="https://img.icons8.com/matisse/100/exit.png" alt="exit"/>&nbsp; Logout</a></li>
			</ul>
		</aside>
        <main class="main-content">
    <header class="header">
        <h3>UMP GradConnect System</h3>
    </header>
    <section class="content">
    <div class="container">
        <div>
            <h1>Reported Posts</h1>
        </div>

        <?php
        // Connect to the database
        $db = mysqli_connect("localhost", "root", "", "gradalumni_db");

        // Check if connection was successful
        if (!$db) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // SQL query to fetch reported posts with user information
        $sql = "
            SELECT rp.report_id AS report_id, rp.reason, rp.user_id AS reporter_id, rp.post_id, 
                   u.name AS reporter_name, u.surname AS reporter_surname, 
                   p.content AS post_content, p.user_id AS post_owner_id
            FROM reports rp
            JOIN users u ON rp.user_id = u.id
            JOIN posts p ON rp.post_id = p.id
            ORDER BY rp.created_at DESC
        ";
        $result = mysqli_query($db, $sql);

        // Check if query execution was successful
        if (!$result) {
            die("Error executing query: " . mysqli_error($db));
        }

        // Check if any rows are returned
        if (mysqli_num_rows($result) > 0) {
            echo '<div class="grid-container">';

            // Loop through each row
            while ($row = mysqli_fetch_assoc($result)) {
                $reportId = htmlspecialchars($row['report_id'], ENT_QUOTES, 'UTF-8');
                $reason = htmlspecialchars($row['reason'], ENT_QUOTES, 'UTF-8');
                $reporterName = htmlspecialchars($row['reporter_name'], ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($row['reporter_surname'], ENT_QUOTES, 'UTF-8');
                $postContent = htmlspecialchars($row['post_content'], ENT_QUOTES, 'UTF-8');
                $postId = htmlspecialchars($row['post_id'], ENT_QUOTES, 'UTF-8');

                echo '<div class="grid-item">';
                echo '<h4>' . 'Reported by: ' . $reporterName . '</h4>';
                echo '<p>' . "Reason: " . $reason . '</p>';
                echo '<p>' . "Post Content: " . $postContent . '</p>';
                echo '<button class="btn btn-danger" onclick="deletePost(' . $postId . ')">Delete Post</button>';
                echo '</div>';
            }

            echo '</div>'; // Close grid-container
        } else {
            echo "<p>No reported posts found.</p>";
        }

        // Close database connection
        mysqli_close($db);
        ?>
    </div>
</section>



</main>

        
    </div>
    <script src="../gradalumni/script/script.js"></script>
	<script>
function deletePost(postId) {
    if (confirm("Are you sure you want to delete this post?")) {
        // Make an AJAX call to delete the post
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_post.php", true); // Call the PHP script to handle deletion
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
            if (xhr.status === 200) {
                alert(xhr.responseText);
                location.reload(); // Reload the page to refresh the reported posts
            } else {
                alert("Error deleting post.");
            }
        };

        xhr.send("id=" + postId); // Send post ID to delete
    }
}
</script>

    
</body>
</html>