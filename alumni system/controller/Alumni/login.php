<?php
session_start();
// Database configuration
include '../../model/conn.php';

// Function to sanitize user inputs
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$error = ''; // Initialize the error variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);

    // Prepare and bind statements to check user credentials
    $stmt = $conn->prepare("SELECT id, password_hash, role_id, name, surname, email, about, education, skills, job, company FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($userId, $passwordHash, $roleId, $name, $surname, $email, $about, $education, $skills, $job, $company);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $passwordHash)) {
            // Set session variables
            $_SESSION['user_id'] = $userId;
            $_SESSION['role_id'] = $roleId;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_surname'] = $surname;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_about'] = $about;
            $_SESSION['user_education'] = $education;
            $_SESSION['user_skills'] = $skills;
            $_SESSION['user_job'] = $job;
            $_SESSION['user_company'] = $company;

            // Update user status to 'online' after successful login
            $updateStatus = "UPDATE users SET status = 'online' WHERE id = $userId";
            mysqli_query($conn, $updateStatus);

            // Redirect based on role
            if ($roleId == 1) { // Alumni
                header("Location: ../../views/public/Alumni_dash.php");
            }
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "No user found with this email.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <title>Login</title>
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
   <link rel="stylesheet" href="../views/css/home2.css">

   <style>
       body {
           position: relative; /* Position relative to contain the pseudo-element */
           margin: 0; /* Remove default margin */
           height: 100vh; /* Full viewport height */
           overflow: hidden; /* Prevent scrolling */
       }

       /* Faded background image */
       body::before {
           content: ""; /* Required to create a pseudo-element */
           position: absolute; /* Position it absolutely */
           top: 0; /* Start at the top */
           left: 0; /* Start at the left */
           right: 0; /* Extend to the right */
           bottom: 0; /* Extend to the bottom */
          /* background-image: url('../../views/img/login.png');  Set your background image */
           background-size: cover; /* Cover the entire viewport */
           background-repeat: no-repeat; /* Prevents the image from repeating */
           background-position: center; /* Center the image */
           opacity: 0.5; /* Set the opacity to fade the image */
           z-index: 0; /* Send the background behind the content */
       }

       .wrapper {
           position: relative; /* Make wrapper positioned to ensure content is above the overlay */
           max-width: 400px; /* Set max width */
           width: 100%; /* Full width */
           background: rgba(255, 255, 255, 0.9); /* White background with slight transparency */
           padding: 40px; /* Padding */
           border-radius: 10px; /* Rounded corners */
           box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2); /* Shadow effect */
           z-index: 1; /* Ensure it appears above the overlay */
       }

       h2 {
           text-align: center;
           margin-bottom: 30px;
       }

       .input-box {
           position: relative;
           margin-bottom: 20px;
       }

       .input-box input {
           width: 100%;
           padding: 10px;
           background: #f5f5f5;
           border: none;
           border-radius: 5px;
       }

       .input-box span.icon {
           position: absolute;
           left: 10px;
           top: 50%;
           transform: translateY(-50%);
       }

       .input-box input:focus {
           outline: none;
           background: #e0e0e0;
       }

       button.btn {
           width: 100%;
           padding: 10px;
           background: #007bff;
           border: none;
           color: white;
           font-size: 16px;
           border-radius: 5px;
           cursor: pointer;
       }

       button.btn:hover {
           background: #0056b3;
       }

       .login-register p {
           text-align: center;
       }

       .login-register a {
           color: #007bff;
       }

       .close-button {
           position: absolute; 
           top: 10px; 
           right: 15px; 
           font-size: 35px; /* Size of the 'X' */
           cursor: pointer; /* Change the cursor on hover */
           color: #333; /* Color of the 'X' */
           z-index: 1000; /* Ensure it appears above other content */
       }

       .close-button:hover {
           color: red; /* Change color on hover for better UX */
       }
   </style>
</head>
<body style="height: 100vh; display: flex; justify-content: center; align-items: center; margin: 0; background-color: #f5f5f5;">
    <div class="wrapper">
        <!-- Close button -->
        <div class="close-button" onclick="closeLogin()">
            &times; <!-- This represents the 'X' symbol -->
        </div>

        <h2>Login</h2>
        <?php if (!empty($error)) { ?>
            <div class="error-message" style="color:red; text-align:center;"><?php echo $error; ?></div>
        <?php } ?>
        <form action="login.php" method="POST">
            <div class="input-box">
                <span class="icon"><i class="fa-regular fa-envelope"></i></span>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" autocomplete="email" required>
            </div>
            <div class="input-box">
                <span class="icon"><i class="fa-solid fa-lock"></i></span>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="current-password" required>
                <span class="position-absolute top-50 end-0 translate-middle-y me-3" onclick="togglePasswordVisibility()">
                    <i class="fa-solid fa-eye" id="togglePassword"></i>
                </span>
            </div>

            <button type="submit" class="btn">Login</button>
            <div class="rememberforgot" style="text-align:center;">
                <a href="../../views/forgot_password.php">Forgot Password?</a>
            </div>
            <div class="login-register">
                <p>Don't have an account? <a href="../../views/register.php">Register</a></p>
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById("password");
            const togglePasswordIcon = document.getElementById("togglePassword");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                togglePasswordIcon.classList.remove("fa-eye");
                togglePasswordIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                togglePasswordIcon.classList.remove("fa-eye-slash");
                togglePasswordIcon.classList.add("fa-eye");
            }
        }

        function closeLogin() {
            window.location.href = '../../views/home.php'; // Redirects to home.php
        }
    </script>
</body>
</html>

</html>
