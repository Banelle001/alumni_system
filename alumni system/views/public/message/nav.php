<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Dashboard Navigation</title>
    <link rel="stylesheet" href="styles.css">
    <style>
    /* Isolate Navbar Styles */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: white;
        padding: 5px 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .navbar-left {
        display: flex;
        align-items: center;
    }

    .logo {
        margin-right: 10px;
    }

    .navbar-title {
        font-size: 18px;
        font-weight: bold;
    }

    .navbar-right {
        display: flex;
        align-items: center;
    }

    .navbar-icons {
        display: flex;
        align-items: center;
        margin-right: 15px;
    }

    .navbar-icon {
        width: 20px;
        height: 20px;
        margin-right: 15px;
        cursor: pointer;
    }

    .navbar-profile-menu {
        position: relative;
        display: flex;
        align-items: center;
    }

    .navbar-profile {
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .navbar-profile-pic {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .navbar-profile-name {
        font-size: 14px;
        margin-right: 5px;
    }

    .navbar-caret {
        font-size: 10px;
    }

    .navbar-dropdown-content {
        display: none;
        position: absolute;
        top: 40px;
        right: 0;
        background-color: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        min-width: 160px;
        z-index: 1000;
        border-radius: 5px;
    }

    .navbar-dropdown-content a {
        color: black;
        padding: 10px 15px;
        text-decoration: none;
        display: block;
    }

    .navbar-dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    </style>
</head>
<body>
    <nav class="navbar">
        <a href="../Alumni_dash.php" class="logo">
            <img src="../../img/background-removed.png" class="logo-img" alt="Logo" width="25%">
        </a>
        <div class="navbar-right">
            <div class="navbar-icons">
            <a href="../Alumni_dash.php"><img src="home.png" alt="" class="navbar-icon"></a>
                <a href="../profile/bio.php"><img src="profile.png" alt="" class="navbar-icon"></a>
                <a href="users.php"><img src="message.png" alt="" class="navbar-icon"></a>
                <a href="../jobs.php"><img src="job.png" alt="" class="navbar-icon"></a>
                <a href="../gallery.php"><img src="gallery.png" alt="" class="navbar-icon"></a>
            </div>
            <div class="navbar-profile-menu">
            <?php
                // Include your database connection file
                include('conn.php');

                // Assuming the session is already started
                $user_id = $_SESSION['user_id'];

                // Prepare and execute the query
                $query = "SELECT name, photo FROM users WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    // Check if photo is empty or invalid
                    if (empty($user['photo']) || !file_exists($user['photo'])) {
                        $user['photo'] = '../../img/pic2.png';
                    }
                } else {
                    $user = ['name' => 'Unknown', 'photo' => '../../img/pic2.png']; 
                }
            ?>

            <div class="navbar-profile" onclick="toggleDropdown()">
                <img src="<?php echo htmlspecialchars($user['photo']); ?>" alt="Profile" class="navbar-profile-pic">
                <span class="navbar-profile-name"><?php echo htmlspecialchars($user['name']); ?></span>
                <span class="navbar-caret">&#9660;</span>
            </div>


                <div id="dropdown" class="navbar-dropdown-content">
                    <a href="../../profile/bio.php">Profile</a>
                    <a href="../jobs.php" class="nav-link">Jobs</a>
                    <a href="../gallery.php" class="nav-link">Gallery</a>
                    <a href="../events.php" class="nav-link">Events</a>
                    <a href="../news.php" class="nav-link">News</a>
					<a href="../alumni_chapters.php" class="nav-link">Alumni Chapters</a>
                    <a class="dropdown-item" href="../message/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById("dropdown");
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        }

        window.onclick = function(event) {
            if (!event.target.closest('.navbar-profile')) {
                const dropdown = document.getElementById("dropdown");
                if (dropdown.style.display === "block") {
                    dropdown.style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
