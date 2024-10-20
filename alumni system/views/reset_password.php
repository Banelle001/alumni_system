<?php
require 'conn.php';  // Include your database connection file

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Validate the token
    $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()");
    $stmt->execute([$token]);
    $resetRequest = $stmt->fetch();

    if ($resetRequest) {
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            // Check if passwords match
            if ($newPassword !== $confirmPassword) {
                $error = "Passwords do not match!";
            } else {
                // Hash the new password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the user's password in the users table (Assuming table 'users' exists)
                $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
                $stmt->execute([$hashedPassword, $resetRequest['email']]);

                // Delete the password reset request from the table
                $stmt = $pdo->prepare("DELETE FROM password_resets WHERE email = ?");
                $stmt->execute([$resetRequest['email']]);

                $success = "Your password has been successfully reset!";
            }
        }
    } else {
        $error = "Invalid or expired token!";
    }
} else {
    $error = "No token provided!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>

    <?php if (!isset($success)) { ?>
        <form action="reset_password.php?token=<?php echo htmlspecialchars($token); ?>" method="POST">
            <label for="new_password">New Password:</label><br>
            <input type="password" name="new_password" required><br><br>
            <label for="confirm_password">Confirm Password:</label><br>
            <input type="password" name="confirm_password" required><br><br>
            <button type="submit">Reset Password</button>
        </form>
		<br>
		<hr>
		<a href="../controller/Alumni/login.php"><button>Back To Login</button></a>
    <?php } ?>
</body>
</html>
