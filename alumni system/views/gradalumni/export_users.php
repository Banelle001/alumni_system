<?php
// Database connection
$host = 'localhost';
$dbname = 'gradalumni_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to get users
    $sql = "SELECT id,name,surname,about,education,degree,graduation_year,student_number,skills,employment_status,job,company,email FROM users";  // Update with your actual table and columns
    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($users) {
        // Set headers to download the CSV file
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=users.csv');

        // Open PHP output stream
        $output = fopen('php://output', 'w');

        // Set the column headers
        fputcsv($output, ['ID', 'Name','Surname','About','Education','Degree','Graduation Year','Student Number','Skills','Employment Status','Job','Company', 'Email']);

        // Output each row of the data
        foreach ($users as $user) {
            fputcsv($output, $user);
        }

        fclose($output);
        exit;
    } else {
        echo 'No users found.';
    }
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
