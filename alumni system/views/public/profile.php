<?php session_start(); ?>


<?php include '../includes/nav.php'; ?>


<?php


$db = mysqli_connect("localhost", "root", "", "gradalumni_db");

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // i fetch user data
    $query = "SELECT photo, name, surname, about, education, degree, graduation_year, skills, job, company, email FROM users WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Profile image
        $profileImage = file_exists($user['photo']) ? $user['photo'] : '../img/pic2.png';
        ?>
        
        <div class="card" style="max-width: 600px; margin: 20px auto;">
		<h1 >User Profile</h1>
            <div class="card-body text-center">
                <img src="<?php echo htmlspecialchars($profileImage); ?>" alt="<?php echo $user['name'] . ' ' . $user['surname']; ?>"
                     class="rounded-circle" width="150" height="150">

                <h2 class="mt-3"><?php echo htmlspecialchars($user['name'] . ' ' . $user['surname']); ?></h2>

                <!-- About -->
                <p class="text-muted mt-2"><?php echo htmlspecialchars($user['about']); ?></p>

                <hr>

                <!-- Additional Information -->
                <ul class="list-unstyled">
                    <li><strong>Education:</strong> <?php echo htmlspecialchars($user['education']); ?></li>
                    <li><strong>Degree:</strong> <?php echo htmlspecialchars($user['degree']); ?></li>
                    <li><strong>Graduation Year:</strong> <?php echo htmlspecialchars($user['graduation_year']); ?></li>
                    <li><strong>Skills:</strong> <?php echo htmlspecialchars($user['skills']); ?></li>
                    <li><strong>Job:</strong> <?php echo htmlspecialchars($user['job']); ?></li>
                    <li><strong>Company:</strong> <?php echo htmlspecialchars($user['company']); ?></li>
                    <li><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></li>
                </ul>
            </div>
        </div>

        <?php
    } else {
        echo 'User not found.';
    }
} else {
    echo 'No user ID provided.';
}
?>

