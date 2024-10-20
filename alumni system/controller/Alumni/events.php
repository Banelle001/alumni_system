<?php
include '../model/conn.php'; 

$sql = "SELECT * FROM events ORDER BY date_created DESC LIMIT 3";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        $imagePath = '../views/gradalumni/assets/uploads/events/' . $row['banner'];
        $defaultImagePath = '../views/img/eventdefault.jpeg';

        $displayImage = file_exists($imagePath) ? $imagePath : $defaultImagePath;

        echo '<div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">';
        echo '<div class="events-item">';
        echo '<img src="' . htmlspecialchars($displayImage) . '" class="img-fluid" alt="Event Image" style="width: 70%; height: 60%;">';
        echo '<div class="events-content">';
        echo '<div class="d-flex justify-content-between align-items-center mb-3">';
        echo '</div>';
        echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
        echo '<p class="description">' . htmlspecialchars($row['content']) . '</p>';
        echo '<p class="schedule">Scheduled on: ' . htmlspecialchars($row['schedule']) . '</p>'; 
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No events found.";
}

$conn->close();
?>
